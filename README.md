## Развёртывание приложения локально:

### Локально:
    #Запуск локального сервера php:
    make run

    #Запуск миграций:
    make migrate

    #удаление таблиц:
    make delete
    
    #запуск сидеров:
    make seed
    
    #Запуск сидеров для таблицы schelules:
    make sch_seed    

    #Бэкап базы в папку backup:
    make backup_base

    #Бэкап сайта в папку backup:
    make backup_site
#### Запуск проекта по http://localhost:8000 . 
#### Настройки базы в config/core 
    const DB_SETTINGS = [
            ....
        'host' => 'localhost',
        'database' => 'database_test',
        'user' => 'root',
        'password' => '12345',
            ....
    ];

### Докеризация:
    #Запуск контейнеров докера:
    make up
    make up_build

    #Остановка контейнеров:
    make down

    #Запуск миграций:
    make docker_migrate

    #удаление таблиц:
    make docker_delete
    
    #запуск сидеров:
    make docker_seed
    
    #Запуск сидеров для таблицы schelules:
    make docker_sch_seed    
#### Запуск проекта по http://localhost:8080 .
#### Настройки базы в config/core
    const DB_SETTINGS = [
            ....
        'host' => 'db',
        'database' => 'db_name',
        'user' => 'root',
        'password' => 'root',
            ....
    ];


