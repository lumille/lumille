<?php


namespace Lumille\Utility;


use Lumille\Exception\ScanException;

class Scan
{

    private static $codes = [
        'dir' => 1,
        'file' => 2
    ];

    public static function dir ($path, $onlyExtensions = null, $removeFiles = null)
    {

        if (!\file_exists($path)) {
            throw new ScanException("Path not found", self::$codes['dir']);
        }

        $defaultExcludeExtensions = ['.', '..'];

        if ($removeFiles) {
            if (!is_array($removeFiles)) {
                $removeFiles = [$removeFiles];
            }

            $defaultExcludeExtensions = \array_merge($defaultExcludeExtensions, $removeFiles);
        }

        $files = array_diff(\scandir($path), $defaultExcludeExtensions);

        if ( $onlyExtensions) {

            if (!\is_array($onlyExtensions)) {
                $onlyExtensions = [$onlyExtensions];
            }

            $_files = $files;
            $files = [];
            foreach  ($_files as $file) {
                $ext = \pathinfo($file, \PATHINFO_EXTENSION);
                if (in_array($ext, $onlyExtensions)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }
}