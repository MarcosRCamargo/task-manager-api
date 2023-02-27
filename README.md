<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Projeto

A API consiste em gerenciar tarefas, onde os usuário podem atribuir uma tarefa a outro usuário  e acompanhar o seus status.

Seguindo o card CANVA elaborado a partir das especificações:

Registro de usuários:
![Reristro de Usuários](https://cdn.discordapp.com/attachments/1078448238471958658/1078448370462494720/1.png)

As tarefas terão os seguintes campos na API.
![Reristro de Usuários](https://media.discordapp.net/attachments/1078448238471958658/1078448370873532487/2.png)

### Banco de Dados - PostGress

Para persistir os dados será utilizado Postgres Utilizando container Docker para provisionar o Banco instanciado pela aplicação.
O arquivo docker-compose contém as configurações necessárias para criação do container.

Para subir o container do banco de dados acesse a pasta rais da aplicação  e execute o seguinte comando:
```bash
docker-compose up -d
```

### Modelo de dados.

O modelo de dados abaixo foi implementado via Eloquent ORM nativo do laravel.

### Testes Unitários

Para execução dos testes Unitários é necessario executar o seguinte comando:

```bash
php artisan queue:work
```
### Notificações de e-mail:

O envio de e-mail:
Quando uma nova tarefa é criada é criado um job que fica armazenado na fila (queue) para o envio da notificação para o usuário. Para que o job seja executado é necessario que o worker do Laravel esteja ativo, ele é responsável por executar a fila Para isto é necessário executar o comando:
```bash
php artisan queue:work
```

### Instruções adicionais


```bash
php artisan queue:work
```


### License

Licença - [MIT license](https://opensource.org/licenses/MIT).

### Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.
