#! /usr/bin/env php

<?php
//http://symfony.com/doc/current/console/coloring.html

use Symfony\Component\Console\Application;

require 'vendor/autoload.php';


$app = new Application('Code-Ark', '2.0');

$app->add(new \CodeArk\NewCommand(new GuzzleHttp\Client));

$app->run();