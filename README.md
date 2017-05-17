xml-processor
=============

A Symfony project created on May 15, 2017, 11:03 pm.

> This is a XML Processor proof of concept. Enjoy!

# Requirements
 - PHP >= 7.0
 - MySQL >= 5.6
 - Composer >= 1.4.1
 - Gulp >= 3.8.11
 - or just try it running: `docker-composer build ; docker-compose up`

# Installing
```sh
# get a copy of the project
git clone https://github.com/diegonobre/xml-processor.git & cd xml-processor

# install dependencies
composer install

# update database
php app/console doctrine:schema:update --force

# install gulp for local assets minification
npm install gulp

# update database
php app/console doctrine:schema:update --force

# cache and log permissions
sudo chown $USER: -Rf . ; chmod 777 -Rf app/cache/dev app/logs/dev
```

# Running
> Open your browser and type: `http://localhost`

# Running API

## Enabling API authentication
First we need to create a oAuth2 client
```sql
INSERT INTO `oauth2_clients` VALUES (NULL, '3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4', 'a:0:{}', '4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k', 'a:1:{i:0;s:8:"password";}');
```

# Testing
Unit tests
```sh
php vendor/bin/phpunit -c
```

Functional tests
```sh
npm run tests
```
