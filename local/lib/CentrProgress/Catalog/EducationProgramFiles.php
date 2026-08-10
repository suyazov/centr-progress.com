<?php

namespace CentrProgress\Catalog;

final class EducationProgramFiles
{
    public static function fromDisplayProperty(array $property)
    {
        if (empty($property['FILE_VALUE']) || !is_array($property['FILE_VALUE'])) {
            return array();
        }

        $value = $property['FILE_VALUE'];
        $files = isset($value['SRC']) ? array($value) : $value;
        $result = array();

        foreach ($files as $file) {
            if (!is_array($file) || empty($file['SRC']) || !is_string($file['SRC'])) {
                continue;
            }

            $src = trim($file['SRC']);
            if (!self::isSafeSource($src)) {
                continue;
            }

            $result[] = array(
                'SRC' => $src,
                'FILE_SIZE' => isset($file['FILE_SIZE']) ? max(0, (int) $file['FILE_SIZE']) : 0,
            );
        }

        return $result;
    }

    private static function isSafeSource($src)
    {
        if ($src === '') {
            return false;
        }

        if ($src[0] === '/') {
            return !isset($src[1]) || $src[1] !== '/';
        }

        $scheme = parse_url($src, PHP_URL_SCHEME);
        return is_string($scheme) && in_array(strtolower($scheme), array('http', 'https'), true);
    }
}
