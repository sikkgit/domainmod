<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3ab966f785e19e974c6db0c215f41237
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        'a1105708a18b76903365ca1c4aa61b02' => __DIR__ . '/..' . '/symfony/translation/Resources/functions.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'iamdual\\' => 8,
        ),
        'W' => 
        array (
            'Webmozart\\Assert\\' => 17,
        ),
        'T' => 
        array (
            'Thamaraiselvam\\MysqlImport\\' => 27,
            'Tests\\Thamaraiselvam\\MysqlImport\\' => 33,
            'Telegram\\Bot\\' => 13,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Contracts\\Translation\\' => 30,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Container\\' => 14,
            'Psr\\Clock\\' => 10,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Contracts\\' => 21,
            'Ifsnop\\' => 7,
        ),
        'G' => 
        array (
            'GJClasses\\' => 10,
        ),
        'D' => 
        array (
            'DomainMOD\\' => 10,
            'Doctrine\\Inflector\\' => 19,
        ),
        'C' => 
        array (
            'Cron\\' => 5,
            'Carbon\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'iamdual\\' => 
        array (
            0 => __DIR__ . '/..' . '/iamdual/uploader/src',
        ),
        'Webmozart\\Assert\\' => 
        array (
            0 => __DIR__ . '/..' . '/webmozart/assert/src',
        ),
        'Thamaraiselvam\\MysqlImport\\' => 
        array (
            0 => __DIR__ . '/..' . '/thamaraiselvam/mysql-import',
        ),
        'Tests\\Thamaraiselvam\\MysqlImport\\' => 
        array (
            0 => __DIR__ . '/..' . '/thamaraiselvam/mysql-import/tests',
        ),
        'Telegram\\Bot\\' => 
        array (
            0 => __DIR__ . '/..' . '/irazasyed/telegram-bot-sdk/src',
        ),
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Contracts\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation-contracts',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Psr\\Clock\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/clock/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Ifsnop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ifsnop/mysqldump-php/src/Ifsnop',
        ),
        'GJClasses\\' => 
        array (
            0 => __DIR__ . '/..' . '/chetcuti/gjclasses/src/GJClasses',
        ),
        'DomainMOD\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/DomainMOD',
        ),
        'Doctrine\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Inflector',
        ),
        'Cron\\' => 
        array (
            0 => __DIR__ . '/..' . '/dragonmantank/cron-expression/src/Cron',
        ),
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/..' . '/nesbot/carbon/src/Carbon',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3ab966f785e19e974c6db0c215f41237::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3ab966f785e19e974c6db0c215f41237::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3ab966f785e19e974c6db0c215f41237::$classMap;

        }, null, ClassLoader::class);
    }
}
