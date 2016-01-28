<?php

use Clarkeash\Vfs\Adapter;
use League\Flysystem\Filesystem;
use Machine\Composer;
use org\bovigo\vfs\vfsStream;

class ComposerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * @var Composer
     */
    protected $composer;

    public function setUp()
    {
        $data = json_encode(['autoload' => ['psr-4' => ['Example\\' => 'src/']]]);

        VfsStream::setup('foo', null, [
            'composer.json' => $data
        ]);

        $adapter = new Adapter(VfsStream::url('foo'));
        $this->file = new Filesystem($adapter);
        $this->composer = new Composer($this->file);
    }

    /**
     * @test
     */
    public function it_gets_the_namespace()
    {
        $this->assertEquals('Example', $this->composer->getRootNamespace());
    }

    /**
     * @test
     */
    public function it_gets_the_path()
    {
        $this->assertEquals('src', $this->composer->getRootPath());
    }

    /**
     * @test
     * @expectedException \League\Flysystem\FileNotFoundException
     */
    public function it_throws_exception_if_no_file()
    {
        VfsStream::setup('foo', null, []);

        $adapter = new Adapter(VfsStream::url('foo'));
        $file = new Filesystem($adapter);

        new Composer($file);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function it_throws_exception_if_psr4_not_setup()
    {
        $data = json_encode(['autoload' => ['psr-4' => []]]);

        VfsStream::setup('foo', null, [
            'composer.json' => $data
        ]);

        $adapter = new Adapter(VfsStream::url('foo'));
        $file = new Filesystem($adapter);

        new Composer($file);
    }
}
