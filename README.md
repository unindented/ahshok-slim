# Ahshok [![Build Status](https://img.shields.io/travis/unindented/ahshok-slim.svg)](http://travis-ci.org/unindented/ahshok-slim) [![Dependency Status](https://img.shields.io/gemnasium/unindented/ahshok-slim.svg)](https://gemnasium.com/unindented/ahshok-slim)

Small Slim app that masks Amazon associate links, so that when the client makes the following request:

```
GET /1937785491 HTTP/1.1
Host: ahshok.example.org
```

The server responds with:

```
HTTP/1.1 301 Moved Permanently
Location: http://www.amazon.com/Programming-Ruby-1-9-2-0-Programmers/dp/1937785491?tag=sometag-20
```

It can also serve the product image by adding `.jpg` to the URL:

```
GET /1937785491.jpg HTTP/1.1
Host: ahshok.example.org
```

The server responds with:

```
HTTP/1.1 301 Moved Permanently
Location: http://ecx.images-amazon.com/images/I/51grBo2vQuL._SL160_.jpg
```

## Installing

Pull all submodules:

```sh
git submodule update --init
```

If you have `composer` installed, just run:

```sh
composer install
```

## Testing

To run the tests, execute the default `phing` task:

```sh
vendor/bin/phing
```

You can also check for messes by executing:

```sh
vendor/bin/phing mess
```

## Deploying

To deploy, copy `build.properties.dist` to `build.properties` and adjust it to match your configuration:

```properties
ssh.destination=unindented:~/ahshok.unindented.org/
```

Then execute the `deploy` task:

```sh
vendor/bin/phing deploy
```

## Running locally

The first thing to do would be to copy `config.php.dist` to `config.php` and adjust the necessary parameters for your environment.

This section of the `config.php` file determines the access credentials that will be used to authenticate against Amazon's product advertising API:

```php
$default = array(
  'amazon' => array(
    'country' => 'US',
    'tag'     => 'realtag-20',
    'key'     => 'REALACCESSKEYID',
    'secret'  => 'REALSECRETACCESSKEY'
  )
);
```

This section of the `config.php` file determines the database connection parameters for the development and production environments. By default, the development environment will use SQLite, while the production environment will use MySQL:

```php
$specific = array(
  'development' => array(
    'pdo' => array(
      'dsn'      => 'sqlite:' . __DIR__ . '/db/app.db',
      'username' => NULL,
      'password' => NULL
    )
  ),

  'production' => array(
    'pdo' => array(
      'dsn'      => 'mysql:host=localhost;port=3306;dbname=ahshok;charset=utf8',
      'username' => 'ahshok',
      'password' => 'ahshok'
    )
  )
);
```

Once you have everything configured properly, the next thing to do would be to install VirtualBox and Vagrant, and execute:

```sh
vagrant up
```

This will provision a new box with the IP address `192.168.168.168`, and the following Apache virtual hosts:

* <http://ahshok.dev> or <http://www.ahshok.dev>: The web app.
* <http://db.ahshok.dev>: A phpMyAdmin installation.

Be sure to add these entries to your `/etc/hosts` file to be able to access them:

```sh
192.168.168.168 ahshok.dev
192.168.168.168 www.ahshok.dev
192.168.168.168 db.ahshok.dev
```

The `ahshok.dev` virtual host has the environment variables `APP_ENV` and `SLIM_MODE` set to `development`. If you want it to run in `production` mode, do a `vagrant ssh` and edit `/etc/apache2/sites-available/1-ahshok.dev.conf` so that it looks like this:

```apache
<VirtualHost *:80>
  ServerAdmin webmaster@ahshok.dev
  DocumentRoot /var/www/web/
  ServerName ahshok.dev
  ServerAlias www.ahshok.dev
  SetEnv APP_ENV production
  SetEnv SLIM_MODE production

  ErrorLog  /var/log/apache2/ahshok.dev-error_log
  CustomLog /var/log/apache2/ahshok.dev-access_log common
</VirtualHost>
```

## Meta

* Code: `git clone git://github.com/unindented/ahshok-slim.git`
* Home: <https://github.com/unindented/ahshok-slim/>

## Contributors

Daniel Perez Alvarez ([unindented@gmail.com](mailto:unindented@gmail.com))

## License

Copyright (c) 2013 Daniel Perez Alvarez ([unindented.org](https://unindented.org/)). This is free software, and may be redistributed under the terms specified in the LICENSE file.
