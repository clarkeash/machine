<?php

namespace Machine;

use Illuminate\Container\Container;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * @var Container
     */
    public $container;

    public function __construct($version)
    {
        parent::__construct('Machine', $version);
        $this->container = new Container;
    }
}
