<?php

namespace CodeArk;


use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NewCommand extends Command
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function configure()
    {
        $this->setName('new')
            ->setDescription('Create a new Code-Ark 2.0 application')
            ->addArgument('name', InputArgument::REQUIRED);
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
       // assert that the folder doesn't already exists
        // geth the current directory and file name
        $directory = getcwd(). '/' .$input->getArgument('name');
        $this->assertApplicationDoesNotExists($directory, $output);

       // download nightly build of code ark
        $this->download()->extract();

       // extract zip file

       // alert user that they are ready to go
    }



    private function assertApplicationDoesNotExists($directory, OutputInterface $output)
    {
        if(is_dir($directory))
        {
            $output->writeln('<error>Application Already exists</error>');
            exit(1);    // 1 is the general error status code if something went wrong
        }
    }



    private function download()
    {
        //https://github.com/code-architect/Code-Ark-2.0/archive/master.zip
    }





} 