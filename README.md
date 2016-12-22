# Custom written framework

This application powered on custom written framework. Application has MVC structure and made for learning purposes.

## Start working

To start this app, perform the following steps:

 - Install external libraries using **composer** and **bower**

```bash
    composer install
    bower install
```

 - Copy config file

```bash
    cp etc/app-conf.php.sample etc/app-conf.php
```

 - Change DB configuration in `etc/app-conf.php`

 - Migrate data to your database

```bash
    php deploy/setup.php -fd
```

 - Then start a server

```bash
    php -S 0.0.0.0:8000 -t public/
```

- Open 'http://localhost:8000' on your web browser

***

### Run CodeSniffer

To check your app to accordance to PSR standards, run the following script

```bash
    php vendor/bin/phpcs --encoding=utf8
```
