<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c4369b27032f33a7d354659fb9b1001
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c4369b27032f33a7d354659fb9b1001::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c4369b27032f33a7d354659fb9b1001::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2c4369b27032f33a7d354659fb9b1001::$classMap;

        }, null, ClassLoader::class);
    }
}