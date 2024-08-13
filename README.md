## Demo
[usergems.webm](https://github.com/user-attachments/assets/8768d62e-af51-4ccd-b06b-f3e5f1ff2f1c)

## Developed in:

[Laravel](https://laravel.com/docs/11.x) (11)

## Requirements:

1. [PHP](https://www.php.net/) (8.3)
2. [MySQL](https://www.mysql.com) (9.0.1)
3. [Composer](https://getcomposer.org/) (2.7.7)

### Instructions for installing the project:
this project is dockerized, to start the project just run the command below with docker:

```sh
docker-compose up
```
### Commands to sync Calendars and send emails
##### sync host meetings
```bash
docker exec -it backend sh -c "php artisan integration:meetings"
```

##### send email to hosts
```bash
docker exec -it backend sh -c "php artisan integration:meetings-emails"
```

### Runing tests
this challenge was developed in TDD, so if you like to see all the tests you can run this command:

```bash
docker exec -it backend sh -c "php artisan test"
```

# notes

By default, Laravel implements the MVC architecture. I implemented DDD architecture following solid principles
architecture, using actions, repositories, and dependency injection.
