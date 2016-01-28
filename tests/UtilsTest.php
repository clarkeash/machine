<?php

use Machine\Utils;

class UtilsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_removes_trailing_slashes()
    {
        $this->assertEquals('Apples', Utils::removeTrailingSlashes('Apples/'));
        $this->assertEquals('Apples', Utils::removeTrailingSlashes('Apples\\'));

        $this->assertEquals('Apples', Utils::removeTrailingSlashes('/Apples'));
        $this->assertEquals('Apples', Utils::removeTrailingSlashes('\\Apples'));

        $this->assertEquals('Apples', Utils::removeTrailingSlashes('/Apples/'));
        $this->assertEquals('Apples', Utils::removeTrailingSlashes('\\Apples\\'));

        $this->assertEquals('Fruits\\Apples', Utils::removeTrailingSlashes('\\Fruits\\Apples\\'));
    }

    /**
     * @test
     */
    public function it_switches_slashes_to_namespace_slashes()
    {
        $this->assertEquals('Fruits\\Apples', Utils::switchToNamespaceSlashes('Fruits/Apples'));
    }

    /**
     * @test
     */
    public function it_switches_slashes_to_directory_slashes()
    {
        $this->assertEquals('Fruits/Apples', Utils::switchToDirectorySlashes('Fruits\\Apples'));
    }

    /**
     * @test
     */
    public function it_gets_just_the_namespace()
    {
        $this->assertEquals('Beverages\\Alcohol', Utils::getJustNamespace('Beverages\\Alcohol\\Cider'));
    }

    /**
     * @test
     */
    public function it_gets_just_the_class_name()
    {
        $this->assertEquals('Cider', Utils::getJustClassName('Beverages\\Alcohol\\Cider'));
    }
}
