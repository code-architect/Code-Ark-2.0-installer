<?php

namespace CodeArk;


use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;

class NewCommand extends Command
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
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

        $output->writeln('<comment>Downloading.......</comment>');

        $this->assertApplicationDoesNotExists($directory, $output);

       // download nightly build of code ark
        $this->download($zipFile = $this->makeFileName())
            ->extract($zipFile, $directory) // extract zip file
            ->cleanUp($zipFile);

       // alert user that they are ready to go
        $output->writeln('<comment>Code-Ark is ready, create something awesome!</comment>');
    }


    /**
     * check the given named directory if not exists
     * @param $directory
     * @param OutputInterface $output
     */
    private function assertApplicationDoesNotExists($directory, OutputInterface $output)
    {
        if(is_dir($directory))
        {
            $output->writeln('<error>Application Already exists</error>');
            exit(1);    // 1 is the general error status code if something went wrong
        }
    }


    /**
     * Generate a unique filename
     */
    private function makeFileName()
    {
        return getcwd().'/codeArk_'. md5(time().uniqid()).'.zip';
    }


    /**
     * Download the desired zipfile
     * @param $zipFile
     * @return $this
     */
    private function download($zipFile)
    {
        //https://github.com/code-architect/Code-Ark-2.0/archive/master.zip
        $response = $this->client->get("http://github.com/code-architect/Code-Ark-2.0/archive/master.zip")->getBody();
        file_put_contents($zipFile, $response);

        return $this;
    }


    /**
     * Extract the downloaded zip file
     * @param $zipFile
     * @param $directory
     * @return $this
     */
    private function extract($zipFile, $directory)
    {
        $archive = new ZipArchive();

        $archive->open($zipFile); // open the zip file
        $archive->extractTo($directory);    // extract the file to the given directory

        $archive->close();  // close the connection

        return $this;
    }


    private function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);  //just in case, if we are not allowed to delete a file, and also suppress any warnings
        @unlink($zipFile);

        return $this;
    }


} 