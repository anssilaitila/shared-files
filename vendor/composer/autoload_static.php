<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit33131af5ad177fa13c083553ea6cf913
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'enshrined\\svgSanitize\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'enshrined\\svgSanitize\\' => 
        array (
            0 => __DIR__ . '/..' . '/enshrined/svg-sanitize/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'enshrined\\svgSanitize\\ElementReference\\Resolver' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Resolver.php',
        'enshrined\\svgSanitize\\ElementReference\\Subject' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Subject.php',
        'enshrined\\svgSanitize\\ElementReference\\Usage' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Usage.php',
        'enshrined\\svgSanitize\\Exceptions\\NestingException' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Exceptions/NestingException.php',
        'enshrined\\svgSanitize\\Helper' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Helper.php',
        'enshrined\\svgSanitize\\Sanitizer' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Sanitizer.php',
        'enshrined\\svgSanitize\\data\\AllowedAttributes' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AllowedAttributes.php',
        'enshrined\\svgSanitize\\data\\AllowedTags' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AllowedTags.php',
        'enshrined\\svgSanitize\\data\\AttributeInterface' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AttributeInterface.php',
        'enshrined\\svgSanitize\\data\\TagInterface' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/TagInterface.php',
        'enshrined\\svgSanitize\\data\\XPath' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/XPath.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit33131af5ad177fa13c083553ea6cf913::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit33131af5ad177fa13c083553ea6cf913::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit33131af5ad177fa13c083553ea6cf913::$classMap;

        }, null, ClassLoader::class);
    }
}
