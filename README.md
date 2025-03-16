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





