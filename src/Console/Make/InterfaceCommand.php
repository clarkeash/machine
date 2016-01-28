<?php

namespace Machine\Console\Make;

use Machine\Composer;
use Machine\Console\BaseCommand;
use Machine\Generators\InterfaceGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InterfaceCommand extends BaseCommand
{
    /**
     * @var InterfaceGenerator
     */
    private $generator;
    /**
     * @var \Machine\Composer
     */
    private $composer;

    public function __construct(Composer $composer, InterfaceGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->composer = $composer;
    }

    public function configure()
    {
        $this->setName('make:interface');
        $this->setDescription('Create an interface.');

        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the class to make.');
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
            $this->info('Interface: ' . $this->composer->getClassPath($this->argument('name')) . ' created');
        }
        else
        {
            $this->error('Something went wrong!');
        }
    }
}
