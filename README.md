## Description

This repository is a tutorial to demonstrate how [Laravel Passport](https://laravel.com/docs/master/passport) implements the four authorization flows defined by the [OAuth2 RFC](https://tools.ietf.org/html/rfc6749). There are two simple laravel applications inside it, one is called **API** (containing the tasks protected resource to be accessed) and the other called **Consumer** (the app that wants to access the tasks).

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

### Authorization code flow

1. First try to access the resource without being authorized, accessing the **consumer** route: http://localhost:8001/tasks

    You will probably get an `authorization error`, so let's create an OAuth client in API app and configure the consumer app.

2. You can create the OAuth client using both `command line` and `web interface`.

    With command line you can create the OAuth client (you have to answer some questions interactively):

        $ docker-compose exec api php artisan passport:client

    Or you can use the web interface, doing you login here http://localhost:8000/ using these credentials (`johndoe@example.com`/`password`). Then following the steps in the images below: 

![List of clients](./API/resources/images/client_list.png?raw=true)
![Register a client](./API/resources/images/client_details.png?raw=true)

3. Now you must configure the `.env` file of **consumer app** with `client_id` and `client_secret` generated in the last step:

        OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_ID=
        OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_SECRET=

4. You are now ready to do the complete authorization flow.

* Access the home of the consumer app: http://localhost:8001/
* You will be redirected to authenticate at **API app**, authenticate using the same credentials (`johndoe@example.com`/`password`)
* This authorization page will be displayed, this represents the **consumer app** asking for permission to access the **api app** protected resource (tasks), answer "Authorize"

![Asking for authorization](./API/resources/images/asking_for_authorization.png?raw=true)

5. You will be redirected to the tasks route of consumer http://localhost:8001/tasks and now will be able to see a list of the tasks :tada:

This flow is the most complex of all, the next ones are simpler and involves fewer steps.

### Resource owner password credentials flow

1. Using the comsumer, try to access the **protected resource** (tasks) of API:

        $ docker-compose exec consumer php artisan tasks:get --grant=password

    You will probably get an `authorization error`, so let's create an OAuth client in API app and configure the consumer app.

2. As shown before you can create OAuth clients in **API app** using the command line or web interface, let's create with command line

        $ docker-compose exec api php artisan passport:client --password --no-interaction

3. Now you must configure the `.env` file of **consumer app** with `client_id` and `client_secret` generated in the last step:

        OAUTH_GRANT_PASSWORD_CLIENT_ID=
        OAUTH_GRANT_PASSWORD_CLIENT_SECRET=

4. With all configurations in place, now you can get the protected resource (tasks) from **API app** executing the same command of the first step :tada:

        $ docker-compose exec consumer php artisan tasks:get --grant=password

### Client credentials flow

Pretty much similar to the `Resource owner password credentials flow`, the steps are pratically the same.

1. Using the comsumer, try to access the **protected resource** (tasks) of API:

        $ docker-compose exec consumer php artisan tasks:get --grant=client_credentials

    You will probably get an `authorization error`, so let's create an OAuth client in API app and configure the consumer app.

2. Let's create the OAuth client:

        $ docker-compose exec api php artisan passport:client --client --no-interaction

3. Now you must configure the `.env` file of **consumer app** with `client_id` and `client_secret` generated in the last step:

        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_ID=
        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_SECRET=

4. With all configurations in place, now you can get the protected resource (tasks) from **API app** executing the same command of the first step :tada:

        $ docker-compose exec consumer php artisan tasks:get --grant=client_credentials

### Implicit flow

TODO

## References

* [Laravel Passport documentation](https://laravel.com/docs/master/passport)
* [OAuth2 Flows](https://medium.com/@darutk/diagrams-and-movies-of-all-the-oauth-2-0-flows-194f3c3ade85)
* [Tutorial about Passport](https://scotch.io/@neo/getting-started-with-laravel-passport)
* [Tutorial about Passport](https://blog.pusher.com/make-an-oauth2-server-using-laravel-passport/)
