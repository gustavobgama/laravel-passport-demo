## Description

This repository is a tutorial to demonstrate the three types of authentication available for the laravel implementation of OAuth2, called [Laravel Passport](https://laravel.com/docs/master/passport). There are two simple laravel applications inside it, one is called **API** (containing the tasks resource to be accessed and protected) and the other called **Consumer** (the app that want to access the tasks).

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

1. Using the comsumer, try to access the **protected resource** (tasks) of API:

        $ docker-compose exec consumer php artisan tasks:get --grant=password

    Probably you got an authentication error, because you didn't configure the OAuth clients yet, so let's move to the next step.

2. Create two OAuth clients in **API app** (using the command line, later you will create it using the web interface):

        $ docker-compose exec api php artisan passport:client --password --no-interaction
        $ docker-compose exec api php artisan passport:client --client --no-interaction

3. Customize the `.env` file of the **consumer app** with the credentials created:

        OAUTH_GRANT_PASSWORD_CLIENT_ID=
        OAUTH_GRANT_PASSWORD_CLIENT_SECRET=

        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_ID=
        OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_SECRET=

4. With all configurations in place, now you can get the protected resource (tasks) from **API app** using the `password` grant type:

        $ docker-compose exec consumer php artisan tasks:get --grant=password

5. You can also get the same resource using other grant type like `client_credentials`:

        $ docker-compose exec consumer php artisan tasks:get --grant=client_credentials

6. As said before, you can create OAuth clients using the web interface, so let's do this:

    * Access the [api app web interface](http://localhost:8000/) to make the login using these credentials (`johndoe@example.com`/`password`)
    * Follow the steps show in images below:

![List of clients](./API/resources/images/client_list.png?raw=true)
![Register a client](./API/resources/images/client_details.png?raw=true)

7. Customize again the `.env` file of the **consumer app** with the credentials created:

        OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_ID=
        OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_SECRET=

8. Now try to access the consumer app to get tasks without authorization: http://localhost:8001/tasks:

    You will probably see nothing because the consumer was not authorized yet, so let's authorize it.

9. Access http://localhost:8001/ and you will be redirected to authenticate and then authorize the **consumer app**:

![List of clients](./API/resources/images/asking_for_authorization.png?raw=true)

10. Once authorized you will be redirected again to http://localhost:8001/tasks now with the **tasks retrieved from api**.

## References

* [Laravel Passport documentation](https://laravel.com/docs/master/passport)
* [Tutorial about Passport](https://scotch.io/@neo/getting-started-with-laravel-passport)
* [Tutorial about Passport](https://blog.pusher.com/make-an-oauth2-server-using-laravel-passport/)
