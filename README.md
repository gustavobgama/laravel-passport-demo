## Description

This repository is a tutorial to demonstrate the three types of authentication available for the laravel implementation of OAuth2, called [Laravel Passport](https://laravel.com/docs/master/passport). There are two simple laravel applications inside it, one is called **API** (containing the tasks resource to be accessed and protected) and the other is called **Consumer** (the app that want to access the tasks).

## Installation

You need **docker** and **docker compose** installed before proceed:

    $ curl -fsSL https://get.docker.com | sh
    $ sudo curl -L https://github.com/docker/compose/releases/download/1.25.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
    $ sudo chmod +x /usr/local/bin/docker-compose

More information on how to install both [here](https://docs.docker.com/engine/installation/) and [here](https://docs.docker.com/compose/install/).

    $ git clone https://github.com/gustavobgama/laravel-passport-demo.git ./LaravelPassport
    $ cd LaravelPassport && docker-compose up -d

The installation is complete and now you can move on to the demonstration steps.

## Demonstration

1. Create two clients in API app (using the command line):
        
        $ docker-compose exec api php artisan passport:client --password --no-interaction
        $ docker-compose exec api php artisan passport:client --client --no-interaction

2. Customize the `.env` file of the **consumer app** with the credentials created:

        OAUTH_GRANT_PASSWORD_CLIENT_ID=
        OAUTH_GRANT_PASSWORD_CLIENT_SECRET=
        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_ID=
        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_SECRET=

3. With all configurations in place, try to get the protected tasks from **task api** using the `password` grant type:

        $ docker-compose exec consumer php artisan tasks:get --grant-type=password

4. The **consumer** app will get the protected tasks from **task api** using the `client_credentials` grant type:

        $ docker-compose exec consumer php artisan tasks:get --grant-type=client_credentials