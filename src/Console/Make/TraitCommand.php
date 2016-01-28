<?php

namespace Machine\Console\Make;

use Machine\Composer;
use Machine\Console\BaseCommand;
use Machine\Generators\TraitGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TraitCommand extends BaseCommand
{
    /**
     * @var TraitGenerator
     */
    private $generator;
    /**
     * @var \Machine\Composer
     */
    private $composer;

    public function __construct(Composer $composer, TraitGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->composer = $composer;
    }

    public function configure()
    {
        $this->setName('make:trait');
        $this->setDescription('Create a trait.');

        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the trait to make.');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'The class should overwrite an existing one.');
    }

    public function fire()
    {
        $data = [
            'name' => $this->argument('name'),
        ];

        $result = $this->generator->setData($data)->setForce($this->option('force'))->make();

        if ($result) {
            $this->info('Trait: ' . $this->composer->getClassPath($this->argument('name')) . ' created');
        } else {
            $this->error('Something went wrong!');
        }
    }
}
