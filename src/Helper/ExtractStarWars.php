<?php

namespace Wead\Helper;

final class ExtractStarWars
{
    private static $passwd = "the Cake is a Lie";
    private static $algo = "blowfish";
    private static $option = OPENSSL_RAW_DATA;
    private static $ivector = 51654676;

    public static function getContent(): string
    {
        return self::getFromFile();
    }

    private static function getFromFile(): string
    {
        $file = getcwd() . "/StarWars";

        $content = openssl_decrypt(
            file_get_contents($file),
            self::$algo,
            self::$passwd,
            self::$option,
            self::$ivector
        );

        return gzuncompress($content);
    }
}
