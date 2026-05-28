<?
// Autoload Bas\Pict replacement
spl_autoload_register(function($class) {
    if ($class === 'Bas\Pict') {
        require_once __DIR__ . '/../../local/php_interface/classes/Bas/Pict.php';
    }
});

// Fix: BeGet nginx does not pass QUERY_STRING to PHP-FPM for rewritten URLs
if (empty($_SERVER['QUERY_STRING']) && strpos($_SERVER['REQUEST_URI'], '?') !== false) {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    if (!empty($parts['query'])) {
        $_SERVER['QUERY_STRING'] = $parts['query'];
        parse_str($parts['query'], $_GET);
        foreach ($_GET as $key => $val) {
            $GLOBALS[$key] = $val;
        }
    }
}
?>
