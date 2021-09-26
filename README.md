# Candy Store

Sistema para o cadastro de bolos, tortas e interessados pelos produtos.

Desenvolvido utilizando as tecnologias: PHP 7.4, Laravel Framework 8, Laravel Passport, Laravel Queues, Laravel Oauth2, Laravel Mail e PostgreSQL.

Base de dados: https://github.com/TalesSathler/candy-store-laravel/tree/master/database/dump.

Requisições via Postman: https://github.com/TalesSathler/candy-store-laravel/tree/master/public/postman

<br>

### Executar
composer install

php artisan serve

<br>

### Chaves da autenticação
Client ID: 1

Client secret: CMTmQ1DmtMI8p02RinMKbcdZKPOifcsNjbcB7Exf

Usuário:
atendente@gmail.com

Senha:
123

<br>

### Configurar execução da fila de envio de e-mail:
php artisan queue:listen --queue=emails --tries=3 --timeout=60 &
