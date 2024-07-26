## Demo

## Developed in:

[Laravel](https://laravel.com/docs/11.x) (9)

## Requirements:

1. [PHP](https://www.php.net/) (8.3)
2. [MySQL](https://www.mysql.com) (9.0.1)
3. [Composer](https://getcomposer.org/) (2.7.7)

### Instructions for installing the project:

this project is dockerized, to start the project just run the command below with docker:

```sh
docker-compose up
```

this challenge was developed in TDD, so if you like to see all the tests you can run this command:

```bash
docker exec -it backend sh -c "php artisan test"
```

# notes

By default, Laravel implements the MVC architecture. I implemented DDD architecture following solid principles
architecture, using actions, repositories, and dependency injection.
