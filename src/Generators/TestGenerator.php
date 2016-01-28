<?php

namespace Machine\Generators;

use Illuminate\Support\Str;
use Machine\Utils;

class TestGenerator extends BaseGenerator
{
    function make()
    {
        return $this->generate('test.txt', []);
    }

    public function setData($data)
    {
        $fullClassName = $this->composer->getClassNamespace($data['name']);

        $testName = str_replace("\\", "", Str::substr($fullClassName, strlen($this->composer->getRootNamespace()) + 1)) . 'Test';

        $data = array_merge([
            'namespace' => Utils::getJustNamespace($fullClassName),
            'className' => Utils::getJustClassName($fullClassName),
            'testName' => $testName
        ], $data);



        $this->data = $data;
        return $this;
    }

    public function write($data)
    {
        $destination = $this->composer->getTestPath($this->data['name']);

        if($this->force && $this->external->has($destination))
        {
            $this->external->delete($destination);
        }

        return $this->external->write($destination, $data);
    }
}
