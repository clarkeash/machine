<?php

namespace Machine\Generators;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Machine\Composer;
use Machine\Utils;
use Mustache_Engine;

abstract class BaseGenerator
{
    /**
     * @var \Machine\Composer
     */
    protected $composer;
    /**
     * @var Filesystem
     */
    private $internal;
    /**
     * @var Mustache_Engine
     */
    private $engine;
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $external;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param mixed $data
     *
     * @return static
     */
    public function setData($data)
    {
        $fullClassName = $this->composer->getClassNamespace($data['name']);

        $data = array_merge([
            'namespace' => Utils::getJustNamespace($fullClassName),
            'className' => Utils::getJustClassName($fullClassName),
        ], $data);

        $this->data = $data;
        return $this;
    }

    /**
     * @var boolean
     */
    protected $force = false;

    /**
     * @param boolean $force
     *
     * @return static
     */
    public function setForce($force = false)
    {
        $this->force = $force;
        return $this;
    }

    public function __construct(Composer $composer, Filesystem $external = null, Mustache_Engine $engine = null)
    {
        $this->internal = new Filesystem(new Local(__DIR__ . '/../../stubs'));
        $this->external = $external ? $external : new Filesystem(new Local(getcwd()));
        $this->engine = $engine ? $engine : new Mustache_Engine;
        $this->composer = $composer;
    }

    public function prepare($template, $data = [])
    {
        $template = $this->internal->get($template)->read();

        return $this->engine->render($template, $data);
    }

    protected function write($data)
    {
        $destination = $this->composer->getClassPath($this->data['name']);

        if($this->force && $this->external->has($destination))
        {
            $this->external->delete($destination);
        }

        return $this->external->write($destination, $data);
    }

    public function generate($stub, $data)
    {
        $template = $this->prepare($stub, array_merge($this->data, $data));

        return $this->write($template);
    }

    abstract function make();
}
