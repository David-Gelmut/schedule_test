run:
	@cd public; \
	php -S localhost:8000
migrate:
	php console.php migrate
delete:
	php console.php delete
seed:
	php console.php seeding
sch_seed:
	php console.php seeding_schedules
backup_base:
	php console.php backup_base
backup_site:
	php console.php backup_site
up:
	docker-compose up -d
up_build:
	docker-compose up -d --build
down:
	docker-compose down
bash:
	docker-compose exec -it app bash
docker_migrate:
	docker-compose exec app php console.php migrate
docker_delete:
	docker-compose exec app php console.php delete
docker_seed:
	docker-compose exec app php console.php seeding
docker_sch_seed:
	docker-compose exec app php console.php seeding_schedules

