<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit686b86f432bfd8c336052796b638226a
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Elhelper\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Elhelper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
        'K' => 
        array (
            'KubAT\\PhpSimple\\HtmlDomParser' => 
            array (
                0 => __DIR__ . '/..' . '/kub-at/php-simple-html-dom-parser/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit686b86f432bfd8c336052796b638226a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit686b86f432bfd8c336052796b638226a::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit686b86f432bfd8c336052796b638226a::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit686b86f432bfd8c336052796b638226a::$classMap;

        }, null, ClassLoader::class);
    }
}
