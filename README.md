xml-processor
=============

A Symfony project created on May 15, 2017, 11:03 pm.

> This is a XML Processor proof of concept. Enjoy!

# Requirements
 - PHP >= 7.0
 - MySQL >= 5.6
 - Composer >= 1.4.1
 - Gulp >= 3.8.11
 - or just try it running: `docker-compose up`

# Installing
```sh
# get a copy of the project
git clone https://github.com/diegonobre/xml-processor.git & cd xml-processor

# install dependencies
composer install

# install gulp for local assets minification
npm install gulp

# update database
php app/console doctrine:schema:update --force
```

# Running
> Open your browser and type: `http://localhost`

# Testing
Unit tests
```sh
php vendor/bin/phpunit -c
```

Functional tests
```sh
npm run tests
```
