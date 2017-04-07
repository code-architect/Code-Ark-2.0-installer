#! /usr/bin/env php

<?php

use Symfony\Component\Console\Application;

require 'vendor/autoload.php';


$app = new Application('Code-Ark', '2.0');

$app->add(new \CodeArk\NewCommand(new GuzzleHttp\Client));

$app->run();