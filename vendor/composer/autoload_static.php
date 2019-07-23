<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd40072379e5094069aec4bde714619e7
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Wikilookup\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Wikilookup\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd40072379e5094069aec4bde714619e7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd40072379e5094069aec4bde714619e7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
