<?php

namespace Machine;

class Utils
{
    public static function removeTrailingSlashes($str)
    {
        return trim($str, '\\/');
    }

    public static function switchToNamespaceSlashes($str)
    {
        return str_replace('/', '\\', static::removeTrailingSlashes($str));
    }

    public static function switchToDirectorySlashes($str)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, static::removeTrailingSlashes($str));
    }

    public static function getJustNamespace($fullClassName)
    {
        $items = explode('\\', $fullClassName);

        array_pop($items);

        return implode('\\', $items);
    }

    public static function getJustClassName($fullClassName)
    {
        $items = explode('\\', $fullClassName);

        return array_pop($items);
    }
}
