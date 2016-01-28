<?php

namespace Machine;

use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use RuntimeException;

class Composer
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $path;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ? $filesystem : new Filesystem(new Local(getcwd()));

        $this->load();
    }

    public function load()
    {
        $composer = json_decode($this->filesystem->get('composer.json')->read(), true);
        if(!isset($composer['autoload']['psr-4']) || empty($composer['autoload']['psr-4'])) throw new RuntimeException('Unable to detect namespace. Ensure you have PSR4 autoloading setup in your composer.json');

        $namespace = array_keys($composer['autoload']['psr-4'])[0];
        $path = $composer['autoload']['psr-4'][$namespace];

        $this->namespace = Utils::removeTrailingSlashes($namespace);
        $this->path = Utils::removeTrailingSlashes($path);
    }

    public function getRootNamespace()
    {
        return $this->namespace;
    }

    public function getRootPath()
    {
        return $this->path;
    }

    public function getClassNamespace($name)
    {
        $name = Utils::switchToNamespaceSlashes($name);

        if(Str::startsWith($name, $this->getRootNamespace()))
        {
            return $name;
        }
        return $this->getRootNamespace() . '\\' . $name;
    }

    public function getClassPath($name)
    {
        $name = $this->getClassNamespace($name);
        $name = Str::substr($name, strlen($this->getRootNamespace()) + 1);

        return $this->getRootPath() . DIRECTORY_SEPARATOR . Utils::switchToDirectorySlashes($name) . '.php';
    }
}
