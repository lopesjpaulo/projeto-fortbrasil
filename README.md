# Instruções para executar o projeto

## Clonar o projeto

## Rodar os comandos após o clone

```
docker-compose up -d
```
```
docker exec -ti projetofortbrasil_app_1 bash -c "cd /var/www/html && composer install -vvv && cp .env.example .env && php artisan migrate"
```

## Requisição para o projeto

Utilizando o postman ou qualquer outro aplicativo do tipo

- URL BASE:

    http://localhost/estabelecimento

    Header: 

    ```Authorization: key_secret```

- POST:

    Criar um novo estabelecimento

    Payload:

    ```
    {
        "nome": "Estabelecimento teste",
        "cep": "59123-321",
        "logradouro": "Rua Teste",
        "numero": "100",
        "bairro": "Bairro Teste",
        "cidade": "Cidade Teste",
        "estado": "CE",
        "complemento": "Complemento Teste"
    }
    ```
- GET:

    Recuperar todos os estabelecimentos

- PUT 

    Editar os dados de um estabelecimento

    /{id}

    Payload:

    ```
    {
        "nome": "Estabelecimento teste",
        "cep": "59123-321",
        "logradouro": "Rua Teste",
        "numero": "100",
        "bairro": "Bairro Teste",
        "cidade": "Cidade Teste",
        "estado": "CE",
        "complemento": "Complemento Teste"
    }
    ```
- DELETE

    Excluir um estabelecimento pelo id

    /{id}

- GET

    Buscar um estabelecimento pelo CEP

    /buscaCep/{cep}

## Testes

Executar com o PHPUnit:

```
vendor/bin/phpunit --filter=createEstabelecimento
vendor/bin/phpunit --filter=getEstabelecimento
vendor/bin/phpunit --filter=deleteEstabelecimento
```

## Demonstração

Dentro da pasta imagem, foram colocadas algumas imagens de requisições para os endpoints, usando o postman, para exemplificar a parte da api.