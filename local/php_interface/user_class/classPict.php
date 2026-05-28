<?
namespace Bas;

class Pict {

	private static $isPng = true;

	private static $arFile = Array();

	private static function checkFormat($str)
	{
		if ($str === 'image/png')
		{
			self::$isPng = true;

			return true;
		}
		elseif ($str === 'image/jpeg')
		{
			self::$isPng = false;

			return true;
		}
		else return false;
	}

	private static function implodeSrc($arr)
	{
		$arr[count($arr) - 1] = '';

		return implode('/', $arr);
	}

	private static function generateSrc($str)
	{
		$arPath = explode('/', $str);

		if ($arPath[2] === 'resize_cache')
		{
			$arPath = self::implodeSrc($arPath);

			return str_replace('resize_cache/iblock', 'webp/resize_cache', $arPath);
		}
		else
		{
			$arPath = self::implodeSrc($arPath);

			return str_replace('upload/iblock', 'upload/webp/iblock', $arPath);
		}
	}

	public static function getWebp($intQuality = 100)
	{
		if (!self::$arFile['CONTENT_TYPE'])
		{
			self::$arFile['CONTENT_TYPE'] = image_type_to_mime_type(exif_imagetype($_SERVER['DOCUMENT_ROOT'] . self::$arFile['SRC']));
		}

		if (!self::$arFile['FILE_NAME'])
		{
			self::$arFile['FILE_NAME'] = array_pop(explode('/', self::$arFile['SRC']));
		}

		if (self::checkFormat(self::$arFile['CONTENT_TYPE']))
		{
			self::$arFile['WEBP_PATH'] = self::generateSrc(self::$arFile['SRC']);

			if (self::$isPng)
			{
				self::$arFile['WEBP_FILE_NAME'] = str_replace('.png', '.webp', strtolower(self::$arFile['FILE_NAME']));
			}
			else
			{
				self::$arFile['WEBP_FILE_NAME'] = str_replace('.jpg', '.webp', strtolower(self::$arFile['FILE_NAME']));
				self::$arFile['WEBP_FILE_NAME'] = str_replace('.jpeg', '.webp', strtolower(self::$arFile['WEBP_FILE_NAME']));
			}

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . self::$arFile['WEBP_PATH']))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . self::$arFile['WEBP_PATH'], 0777, true);
			}

			self::$arFile['WEBP_SRC'] = self::$arFile['WEBP_PATH'] . self::$arFile['WEBP_FILE_NAME'];

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . self::$arFile['WEBP_SRC']))
			{
				if (self::$isPng)
				{
					$im = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . self::$arFile['SRC']);
				}
				else
				{
					$im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . self::$arFile['SRC']);
				}

				imagewebp($im, $_SERVER['DOCUMENT_ROOT'] . self::$arFile['WEBP_SRC'], $intQuality);

				imagedestroy($im);
			}
		}
	}

	public static function getResizeSrc($file, $width, $height, $isProportional = true, $intQuality = 100)
	{
		self::$arFile = Array();

		if (is_array($file)) self::$arFile = $file;
		else self::$arFile['ID'] = $file;

		$file = \CFile::ResizeImageGet($file, array('width'=>$width, 'height'=>$height), ($isProportional ? BX_RESIZE_IMAGE_EXACT : BX_RESIZE_IMAGE_EXACT), true, false, false, $intQuality);

		self::$arFile['SRC'] = $file['src'];
		self::$arFile['WIDTH'] = $file['width'];
		self::$arFile['HEIGHT'] = $file['height'];

		return self::$arFile['SRC'];
	}

	public static function getResizeWebpSrc($file, $width, $height, $isProportional = true, $intQuality = 100)
	{
		self::getResizeSrc($file, $width, $height, $isProportional, $intQuality);

		self::getWebp($intQuality);

		return self::$arFile['WEBP_SRC'];
	}

	public static function getLastWidth()
	{
		return self::$arFile['WIDTH'];
	}

	public static function getLastHeight()
	{
		return self::$arFile['HEIGHT'];
	}
}