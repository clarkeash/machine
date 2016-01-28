<?php

namespace Machine\Console\Make;

use Machine\Composer;
use Machine\Console\BaseCommand;
use Machine\Generators\ClassGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ClassCommand extends BaseCommand
{
    /**
     * @var \Machine\Generators\ClassGenerator
     */
    private $generator;
    /**
     * @var \Machine\Composer
     */
    private $composer;

    public function __construct(Composer $composer, ClassGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->composer = $composer;
    }
    public function configure()
    {
        $this->setName('make:class');
        $this->setDescription('Create a class.');

        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the class to make.');
        $this->addOption('abstract', null, InputOption::VALUE_NONE, 'The class should be abstract.');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'The class should overwrite an existing one.');
    }

    public function fire()
    {
        $data = [
            'name' => $this->argument('name'),
            'abstract' => $this->option('abstract'),
        ];

        $result = $this->generator->setData($data)->setForce($this->option('force'))->make();

        if ($result)
        {
            $this->info('Class: ' . $this->composer->getClassPath($this->argument('name')) . ' created');
        }
        else
        {
            $this->error('Something went wrong!');
        }
    }
}
