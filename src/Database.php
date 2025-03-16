<?php

namespace src;

use PDO;

class Database
{
    private PDO $pdo;
    private \PDOStatement $stmt;
    private static $instance;
    private string $select;
    private ?string $joins = null;
    private ?string $where = null;
    private ?string $having = null;
    private ?string $limit = null;
    private ?string $order = null;

    private function __construct()
    {
        $dsn = "mysql:host=" . DB_SETTINGS['host'] . ";port=" . DB_SETTINGS['port'] . ";dbname=" . DB_SETTINGS['database'] . ";charset=" . DB_SETTINGS['charset'];

        $this->pdo = new PDO(
            $dsn, DB_SETTINGS['user'], DB_SETTINGS['password'], DB_SETTINGS['options']
        );

        return $this;
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function query(string $query, array $params = []): self
    {

        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);
        return $this;
    }

    public function findOne(string $table, mixed $value, mixed $key = 'id'): array|false
    {
        $this->query("SELECT * FROM   {$table} WHERE {$key}= ? LIMIT 1", [$value]);
        return $this->stmt->fetch();
    }

    public function findAll(string $table): array|false
    {
        $this->query("SELECT * FROM  {$table}");
        return $this->stmt->fetchAll();
    }


    public function select(array $fields): self
    {
        $this->select = implode(',', $fields) ?? '*';
        return $this;
    }

    public function insert(string $table, array $data)
    {
        $queryKeys = $queryValues = '';
        $data = array_map(function ($item) {
            return "'{$item}'";
        }, $data);
        $queryKeys .= implode(',', array_keys($data));
        $queryValues .= implode(',', array_values($data));

        try {
            Database::getInstance()->beginTransaction();
            $this->query("INSERT INTO {$table} ({$queryKeys}) VALUES ($queryValues)");
            Database::getInstance()->commit();
            return $this->lastInsertId();
        } catch (\PDOException $e) {
            Log::msg("Ошибка сохранения в базе {$e->getMessage()} c кодом {$e->getCode()} в файле {$e->getFile()} на строке {$e->getLine()}");
            Database::getInstance()->rollBack();
            return false;
        }
    }

    public function insertMany(string $table, array $fields, array $data)
    {
        $data = array_map(function ($item) {
            $item = array_map(function ($item1) {
                return "'{$item1}'";
            }, $item);
            $item = implode(',', $item);
            return "({$item})";
        }, $data);
        $queryKeys = implode(',', $fields);
        $queryValues = implode(',', $data);
        try {
            Database::getInstance()->beginTransaction();
            $this->query("INSERT INTO {$table} ({$queryKeys}) VALUES {$queryValues}");
            Database::getInstance()->commit();
        } catch (\PDOException $e) {
            Log::msg("Ошибка сохранения в базе {$e->getMessage()} c кодом {$e->getCode()} в файле {$e->getFile()} на строке {$e->getLine()}");
            echo $e->getMessage();
            Database::getInstance()->rollBack();
        }
    }


    public function join(string $table, string $tableJoin, string $keyTable, string $foreignKeyReferencesTable): self
    {
        $this->joins .= "JOIN {$tableJoin} ON {$table}.{$keyTable}={$tableJoin}.{$foreignKeyReferencesTable} ";
        return $this;
    }

    public function get(string $table, array $params = []): array|false
    {
        $query = "SELECT {$this->select} FROM {$table} {$this->joins} {$this->where}  {$this->having} {$this->limit} {$this->order}";
        $this->query($query, $params);
        return $this->stmt->fetchAll();
    }

    public function orderBy(string $column, string $dir = 'ASC'): self
    {
        $this->order = " ORDER BY {$column} {$dir}";
        return $this;
    }

    public function limit(string $count): self
    {
        $this->limit = " LIMIT {$count}";
        return $this;
    }

    public function where(string $operator1, string $operation, string $operator2): self
    {
        $this->where = " WHERE ({$operator1}{$operation}{$operator2})";
        return $this;
    }

    public function whereRaw(string $query): self
    {
        $this->where = " WHERE {$query}";
        return $this;
    }

    public function having(string $operator1, string $operation, string $operator2): self
    {
        $this->having = " HAVING {$operator1}{$operation}{$operator2}";
        return $this;
    }

    public function havingRaw(string $query): self
    {
        $this->having = " HAVING {$query}";
        return $this;
    }

    public function havingAnd(string $operator1, string $operation, string $operator2): self
    {
        $this->having .= "AND ({$operator1}{$operation}{$operator2})";
        return $this;
    }

    public function whereAnd(string $operator1, string $operation, string $operator2): self
    {
        $this->where .= "AND ({$operator1}{$operation}{$operator2})";
        return $this;
    }

    public function fetchAll(): array|false
    {
        return $this->stmt->fetchAll();
    }

    public function fetch(): mixed
    {
        return $this->stmt->fetch();
    }

    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    public function truncate(string $table): void
    {
        $this->query("TRUNCATE TABLE {$table}");
    }

    public function backupBase(): void
    {
        $fullFileName = ROOT . '/backup/backup_' . date('Y_m_d_h_i_s') . '.sql';
        $command = 'mysqldump -h' . DB_SETTINGS['host'] . ' -u' . DB_SETTINGS['user'] . ' -p' . DB_SETTINGS['password'] . ' ' . DB_SETTINGS['database'] . ' > ' . $fullFileName;
        shell_exec($command);
    }

    public function backupSite(): void
    {
        $fullFileName = ROOT . '/backup/backup_' . date('Y_m_d_h_i_s') . '.tar.gz';
        shell_exec("tar -cvf {$fullFileName} " . ROOT);
    }

    private function __clone()
    {
    }
}