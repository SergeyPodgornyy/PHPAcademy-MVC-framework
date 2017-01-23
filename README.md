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

After migration 3 test account will be available. Account with role `user` get see website content, `admin` also can delete items, and `superadmin` can also create and modify existing items. All test accounts has `password` as a password.

 - Then start a server

```bash
    php -S 0.0.0.0:8000 -t public/
```

- Open 'http://localhost:8000' on your web browser

********************************************************************************

### Run CodeSniffer

To check your app code to accordance to PSR standards, run the following script

```bash
    php vendor/bin/phpcs --encoding=utf8
```

To fix your code according to PSR standards, run the following script

```bash
    php vendor/bin/phpcbf
```

********************************************************************************

### Update languages pack

**Run script**

```bash
    php bin/updateLangFiles.php
```

Provide translation for `.po` files located in `/locales` using `poedit` (just type `poeditor` in console to run it). `poeditor` will generate `.mo` files. After that, run script one more time to create `.json` files.

If you don't want to use `poeditor`, you can generate `.mo` files using the following script:

```bash
    msgfmt messages.po -o messages.mo
```

********************************************************************************

#### Install locales and important libraries

First of all, you need to install the following packages:

```bash
    sudo apt-get install libjson-perl liblocal-lib-perl liblocale-po-perl
```

Check which locales are supported on your machine:

```bash
    locale -a
```

Add locales you need (for example `ru_RU` or `ru_UA`):

```bash
    sudo locale-gen ru_RU
    sudo locale-gen ru_RU.UTF-8
    sudo locale-gen ru_UA.UTF-8
```

Update system locales:

```bash
    sudo update-locale
    sudo dpkg-reconfigure locales
```

Install `poedit` on your machine:

```bash
    sudo apt-get install poedit
```
