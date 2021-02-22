# Laravel ToDo

Laravel Todo is a web application to create ToDo Lists with itens and SubItens

## Prerequisites

The only two prerequisits are:

* Git (to clone the project)
* Docker (to run the application)

## Instalation

Follow this steps to run the application locally.

1.  Clone the repositiry:
    ``` bash
    git clone https://github.com/caiquebb/laravel-todo.git
    ```

2. Create .env file:
    ``` bash
    cp .env.example .env
    ```

    >If you need to change the default port add a variable APP_PORT in this file. ex.: APP_PORT=8000

3.  Install project depences:
    ``` bash
    docker run --rm \
        -v $(pwd):/opt \
        -w /opt \
        laravelsail/php80-composer:latest \
        bash -c "composer install"
    ```

4. Run the application:
    ``` bash
    ./vendor/bin/sail up -d
    ```

5. Run the migrations:
    ``` bash
    ./vendor/bin/sail artisan migrate
    ```

6. Create application key:
    ``` bash
    ./vendor/bin/sail artisan key:generate
    ```

## View Application

To view the application access http://localhost.

> If you configure APP_PORT don't forget to specify in URL. ex.: http://localhost:8000

## Previewing Emails

Laravel ToDo contains a service entry for MailHog. MailHog intercepts emails sent by your application during local development and provides a convenient web interface so that you can preview your email messages in your browser.

When Sail is running, you may access the MailHog web interface at: http://localhost:8025
