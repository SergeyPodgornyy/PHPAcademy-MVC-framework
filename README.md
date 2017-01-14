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

**Run script**

```bash
    php bin/updateLangFiles.php
```

Install `poedit` on your machine:

```bash
    sudo apt-get install poedit
```

Provide translation for `.po` files located in `/locales` using `poedit` (just type `poeditor` in console to run it). `poeditor` will generate `.mo` files. After that, run script one more time to create `.json` files.

If you don't want to use `poeditor`, you can generate `.mo` files using the folowwing script:

```bash
    msgfmt messages.po -o messages.mo
```

Before pushing your `.po` files to remote repository, be sure, that their is no unuseful comments or logs. Open `.po` files and **remove logs** if they exists. Easiest way to do this is:

- Open Sublime Text, or other code editor
- Select and copy path of your project folder in logs
- Find all entries and choose them all using `Alt+Enter`
- Delete all selected rows using `Ctrl+Shift+K`
