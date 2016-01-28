<?php

namespace Machine\Console\Make;

use Machine\Composer;
use Machine\Console\BaseCommand;
use Machine\Generators\TestGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TestCommand extends BaseCommand
{
    /**
     * @var TestGenerator
     */
    private $generator;
    /**
     * @var \Machine\Composer
     */
    private $composer;

    public function __construct(Composer $composer, TestGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->composer = $composer;
    }

    public function configure()
    {
        $this->setName('make:test');
        $this->setDescription('Create a test.');

        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the class to make a test for.');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'The class should overwrite an existing one.');
    }

    public function fire()
    {
        $data = [
            'name' => $this->argument('name'),
        ];

        $result = $this->generator->setData($data)->setForce($this->option('force'))->make();

        if ($result)
        {
            $this->info('Test: ' . $this->composer->getTestPath($this->argument('name')) . ' created');
        }
        else
        {
            $this->error('Something went wrong!');
        }
    }
}
