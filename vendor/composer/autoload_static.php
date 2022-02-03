<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84053251f3503d01b4fd1fd30535a36f
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core23E43R3WQ\\' => 14,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core23E43R3WQ\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84053251f3503d01b4fd1fd30535a36f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84053251f3503d01b4fd1fd30535a36f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit84053251f3503d01b4fd1fd30535a36f::$classMap;

        }, null, ClassLoader::class);
    }
}