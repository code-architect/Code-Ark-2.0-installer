#! /usr/bin/env php

<?php
//http://symfony.com/doc/current/console/coloring.html
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

require 'vendor/autoload.php';


$app = new Application('Code-Architect Console Tool', 1.0);

$app->register('sayHello')
    ->setDescription('Offer a greetings')
    ->addArgument('name', InputArgument::REQUIRED, '<info>Your Name should be here</info>')
    ->setCode(function(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $message = 'Hello, '.$name;
        $output->writeln($message);
    });

$app->run();