## Important

## Desenvolvido em:

[Laravel](https://laravel.com/docs/11.x) (11)

## Tecnologias:

1. [PHP](https://www.php.net/) (8.3)
2. [MySQL](https://www.mysql.com) (8)
3. [Composer](https://getcomposer.org/) (2.1)

### Instructions for installing the project:

this project is dockerized, to start the project just run the command below with docker:

```sh
docker-compose up
```

este desafio foi desenvolvido em TDD, então se você quiser ver todos os testes pode rodar este comando:

```bash
docker exec -it backend sh -c "php artisan test"
```

# Observações

Por padrão, o Laravel implementa a arquitetura MVC. Implementei arquitetura DDD seguindo princípios sólidos
arquitetura, usando ações, repositórios e injeção de dependência.

# O que faria de melhor?

Usaria um framework reativo no frontend, desacoplado do backend, visando facilitar a manutenção do projeto. Escolho o
Nuxt.js, um framework baseado em Vue.js, devido às suas robustas funcionalidades para otimização de SEO e renderização
eficiente no servidor.

No backend, implementei o cache padrão oferecido pelo Laravel utilizando banco de dados. Contudo, para lidar com grandes
volumes de dados, recomenda-se o uso de uma ferramenta dedicada como Redis. Isso proporciona melhor desempenho ao
consultar dados no banco.

Para uma aplicação com alto volume de usuários, um aplicativo móvel integrado, e estrutura complexa com funcionalidades
como comentários e avaliações, considero vantajoso adotar GraphQL. Essa tecnologia facilita consultas flexíveis e
eficientes, além de suportar as necessidades dinâmicas de uma aplicação escalável.
