<?php
namespace Bas;

class Pict
{
    public static function getResizeWebpSrc($picture, $width, $height)
    {
        if (empty($picture)) {
            return "";
        }

        $fileId = is_array($picture) ? (isset($picture["ID"]) ? $picture["ID"] : $picture["SRC"]) : intval($picture);

        if ($fileId <= 0 && is_string($picture)) {
            return $picture;
        }

        $resize = \CFile::ResizeImageGet(
            $fileId,
            array("width" => $width, "height" => $height),
            BX_RESIZE_IMAGE_EXACT,
            false
        );

        return $resize ? $resize["src"] : "";
    }
}
