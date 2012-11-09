# RediSlim

A really simple &amp; quick web app to view the contents of a redis database.

## Install
There are two dependencies:
* [phpredis](https://github.com/nicolasff/phpredis) to connect to a [Redis](http://redis.io) database.
* [Slim](http://slimframework.com), a php micro framework

After cloning this repo, you just have to install Slim using composer:

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

You can setup your redis configuration in the first lines of index.php

## Thanks
Made while working at [ActivScreen](http://www.activscreen.com) and using [Bootstrap](http://twitter.github.com/bootstrap/)
