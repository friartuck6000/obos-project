# O'Tuckerson Business Office Suite

OBOS is a back-office suite built for developers and IT consultants. It combines project management, timekeeping and billing in
one slick Web application. One application means the user's administrative workflow is more efficient, which means he or she
can spend more time on what matters: actually working.

## Table of contents

-   [Installation](#installation)
    -   [Installing Composer](#installing-composer)
    -   [Installing the project](#installing-the-project)

## Installation

Installing this project to begin development requires a basic knowledge of command line usage, and this guide assumes you
will be contributing on a **Unix/Linux** system. Although highly recommended, this is not a requirement; with that said, the
command-line snippets/samples provided in this documentation are for *nix only—if you are developing on Windows, you'll need
to find the Windows equivalents to these steps on your own.

The Symfony framework requires that PHP 5.4 or greater be installed in order to run; the framework depends on many components
that were not present in version 5.3 or earlier. Please run `php -v` from the command line to verify your PHP version before
installing this project.

### Installing [Composer][composer]

Composer is the foremost _dependency manager_ for PHP—much like **NuGet** for .NET or **RubyGems** for Ruby. This project is
built on Symfony, which _relies on Composer_ to manage all of the components of the framework; if you don't already have it
installed, you'll need to install it in order to begin working:

```shell
# You may need to use sudo depending on your system's permissions
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

### Installing the project

1.  Clone this repository:

    ```shell
    git clone git@github.com:friartuck6000/obos-app.git /path/to/project-folder
    cd /path/to/project-folder
    ```

2.  Run `composer install` to install the framework components and dependencies.

3.  Use PHP's built-in webserver feature to start a local server:
    
    ```shell
    # From the root project directory
    php app/console server:run 127.0.0.1:8888
    # Note: Once the server has started, just press CTRL+C in the
    #       terminal window to stop it
    ```

4.  Go to `http://localhost:8888/app_dev.php/` in your browser to verify that the temporary server is working properly.

    If you'd prefer to work with a normal Web server like Apache or Nginx, check Symfony's
    [Configuring a Web Server][symfony-webserver] article.

## The front controller


[composer]: https://getcomposer.org
[gh-wiki]: https://github.com/friartuck6000/obos-app/wiki
[symfony-webserver]: http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
