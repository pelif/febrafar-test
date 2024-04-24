## Estudos de Testes Unitários e Design Patterns no Laravel

Este projeto consiste em desenvolvimento de api Utlizando PHP 8.1, Laravel 9.19, Mysql5.7, Nginx, Docker e Docker Compose. Ele foi desenvolvido para estudos de API, testes unitários e Design Patterns. 

## Instruções de Instalação

Para rodar este projeto é necessário ter o Docker e Docker Compose devidamente instalado no host. Na raíz do projeto 
basta rodar o comando **composer install**, após concluir as instalações do composer rode o comando **docker-compose up -d --build** que o projeto vai subir em containers e após todo o processo de build o mesmo estará disponível no endereço: **http://localhost**. É necessário ter a porta 80 liberada para rodar a aplicação. 

Também será preciso configurar o arquivo .env com algumas credenciais, primeiramente copie o arquivo .env.example na raíz do projeto renomeando-o para .env. Depois configure as credenciais de banco de dados da seguinte forma: 

DB_CONNECTION=mysql
DB_HOST=172.80.0.2
DB_PORT=3306
DB_DATABASE=laravel_api_tests
DB_USERNAME=laravel_tests
DB_PASSWORD=laravel_tests

Pois como o ambiente do projeto está configurado para rodar no docker, é preciso que pelo o DB_HOST esteja conforme especificado, pois o docker está usando rede interna com este ip fixo para o banco de dados. 

No .env também configure estas credenciais : 

API_USER_TEST=test@email.com
API_PSSWD_TEST=123456
API_TOKEN=2|9G9xngOqXx3TiQYX0eShZ2BTCygNeCfYEihLBssA8120175e

Para instalar a base da aplicação, na raiz da aplicação basta rodar o comando **php artisan migrate** que as tables serão criadas. Para criar um usuário de teste basta rodar uma seeder específica com o comando: **php artisan db:seed \\\Database\\\Seeders\\\UserSeeder** . Com este comando será criado o usuário : 

{ "email": "test@email.com",  "password": "123456" }

Este é o usuário que será usado no endpoint de login e será enviado no body payload.
 
### Observações: 

Na raíz do projeto há um arquivo **docker-compose.yml**. O projeto foi separado em três serviços: 

 - db_laravel_api_tests - Este é o serviço que está rodando nosso banco de dados Mysql, seu contianer é **db_lara_api**
 - app_laravel_api_tests - Este é o serviço que contém a aplicação , seu container é **app_lara_api** roda php 8.1 fpm
 - nginx_laravel_api_tests - Este é o serviço que contém a nginx que faz proxy reverso com o serviço app_laravel_api_tests , seu container é **nginx_lara_api** roda servidor web nginx
 - redis - serviço rodando redis para eventuais caches necessários, seu container é redis_lara_api

 
## Endpionts da API

Segue a lista de alguns endpoints da API: 

 - POST - api/login
 - POST - api/schedules
 - GET|POST - api/schedules/list
 - PUT|PATCH - api/schedules/{schedule}
 - DELETE - api/schedules/{schedule}


Também será disponibilizado uma collection no formato postman para validação dos Endpoints e para detalhamento maior a respeito dos payloads e retornos. 

OBS: 

Ao testar a API, é necessário pegar o token gerado e atualizar na variável de ambiente API_TOKEN do .env . Posteriormente o processo de reaproveitamento de token será feito automaticamente. 

