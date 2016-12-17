# Custom written framework

This application powered on custom written framework. Application has MVC structure and made for learning purposes.

## Start working

To start this app, first run **composer**

```bash
    composer install
```

Copy config file

```bash
    cp etc/app-conf.php.sample etc/app-conf.php
```

Then start a server

```bash
    php -S 0.0.0.0:8000 -t public/
```