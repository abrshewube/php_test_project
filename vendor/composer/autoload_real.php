<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit4f638ff7ca322abe616d7e0cc3422fee
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit4f638ff7ca322abe616d7e0cc3422fee', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit4f638ff7ca322abe616d7e0cc3422fee', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit4f638ff7ca322abe616d7e0cc3422fee::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
