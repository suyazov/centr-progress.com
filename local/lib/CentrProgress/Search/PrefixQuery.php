<?php

namespace CentrProgress\Search;

final class PrefixQuery
{
    private const MAX_QUERY_LENGTH = 256;
    private const MAX_TOKEN_LENGTH = 64;
    private const MAX_TOKENS = 10;
    private const MIN_PREFIX_LENGTH = 3;
    private const MAX_INDEX_EXPANSIONS = 40;
    private const MAX_EXPANDED_QUERY_LENGTH = 220;

    public static function build($query)
    {
        $query = trim((string) $query);
        if ($query === '') {
            return '';
        }

        if (function_exists('mb_substr')) {
            $query = mb_substr($query, 0, self::MAX_QUERY_LENGTH, 'UTF-8');
            $query = mb_strtolower($query, 'UTF-8');
        } else {
            $query = substr($query, 0, self::MAX_QUERY_LENGTH);
            $query = strtolower($query);
        }

        $query = str_replace('ё', 'е', $query);
        preg_match_all('/[\p{L}\p{N}]+/u', $query, $matches);
        $tokens = array_slice($matches[0], 0, self::MAX_TOKENS);
        $result = array();

        foreach ($tokens as $token) {
            if (function_exists('mb_substr')) {
                $token = mb_substr($token, 0, self::MAX_TOKEN_LENGTH, 'UTF-8');
                $length = mb_strlen($token, 'UTF-8');
            } else {
                $token = substr($token, 0, self::MAX_TOKEN_LENGTH);
                $length = strlen($token);
            }

            if ($token !== '') {
                $result[] = $token . ($length >= self::MIN_PREFIX_LENGTH ? '*' : '');
            }
        }

        return implode(' ', $result);
    }

    public static function applyToRequest()
    {
        $original = isset($GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'])
            ? (string) $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY']
            : (isset($_REQUEST['q']) ? (string) $_REQUEST['q'] : '');
        $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'] = $original;
        // CSearchTitle performs indexed prefix matching natively. Keep its
        // query bounded to normalized wildcard tokens; only search.page needs
        // the dictionary expansion used for ranking complete indexed stems.
        $isTitleAjax = isset($_REQUEST['ajax_call'], $_REQUEST['INPUT_ID'])
            && (string) $_REQUEST['ajax_call'] === 'y';
        $normalized = $isTitleAjax ? self::build($original) : self::buildIndexed($original);
        $_REQUEST['q'] = $normalized;

        if (isset($_GET['q'])) {
            $_GET['q'] = $normalized;
        }
        if (isset($_POST['q'])) {
            $_POST['q'] = $normalized;
        }

        return $normalized;
    }

    /**
     * Expand a single bounded prefix through Bitrix's indexed stem dictionary.
     * The range predicate uses the b_search_stem.STEM index and deliberately
     * avoids SQL LIKE/full table scans. Multi-token queries retain the normal
     * bounded search syntax.
     */
    public static function buildIndexed($query)
    {
        $fallback = self::build($query);
        $tokens = self::tokens($query);
        if (count($tokens) !== 1 || self::length($tokens[0]) < self::MIN_PREFIX_LENGTH) {
            return $fallback;
        }

        if (!class_exists('Bitrix\\Main\\Application')) {
            return $fallback;
        }

        try {
            $prefix = function_exists('mb_strtoupper')
                ? mb_strtoupper($tokens[0], 'UTF-8')
                : strtoupper($tokens[0]);
            $connection = \Bitrix\Main\Application::getConnection();
            $helper = $connection->getSqlHelper();
            $lower = $helper->forSql($prefix, self::MAX_TOKEN_LENGTH);
            // U+FFFF is a valid three-byte UTF-8 sentinel above every normal
            // letter suffix in Bitrix's utf8_bin stem index.
            $upper = $helper->forSql($prefix . "\xEF\xBF\xBF", self::MAX_TOKEN_LENGTH + 1);
            $result = $connection->query(
                "SELECT s.STEM FROM b_search_stem s "
                . "INNER JOIN b_search_content_stem cs ON cs.STEM = s.ID "
                . "INNER JOIN b_search_content c ON c.ID = cs.SEARCH_CONTENT_ID "
                . "WHERE s.STEM >= '" . $lower . "' AND s.STEM < '" . $upper . "' "
                . "AND c.MODULE_ID = 'iblock' AND c.PARAM1 = 'infosection' AND c.PARAM2 = '7' "
                . "GROUP BY s.ID, s.STEM "
                . "ORDER BY MAX(cs.TF) DESC, CHAR_LENGTH(s.STEM), s.STEM "
                . "LIMIT " . self::MAX_INDEX_EXPANSIONS
            );
            $stems = array();
            while ($row = $result->fetch()) {
                $stem = isset($row['STEM']) ? trim((string) $row['STEM']) : '';
                if ($stem !== '') {
                    $candidate = array_keys($stems);
                    $candidate[] = $stem;
                    if (self::length(implode(' OR ', $candidate)) > self::MAX_EXPANDED_QUERY_LENGTH) {
                        break;
                    }
                    $stems[$stem] = true;
                }
            }
            if ($stems) {
                return implode(' OR ', array_keys($stems));
            }
        } catch (\Exception $error) {
            // Search remains available through the bounded normal query if
            // the optional index lookup is unavailable.
        }

        return $fallback;
    }

    public static function originalQuery()
    {
        return isset($GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'])
            ? (string) $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY']
            : (isset($_REQUEST['q']) ? (string) $_REQUEST['q'] : '');
    }

    private static function tokens($query)
    {
        $query = trim((string) $query);
        if ($query === '') {
            return array();
        }
        if (function_exists('mb_substr')) {
            $query = mb_substr($query, 0, self::MAX_QUERY_LENGTH, 'UTF-8');
            $query = mb_strtolower($query, 'UTF-8');
        } else {
            $query = substr($query, 0, self::MAX_QUERY_LENGTH);
            $query = strtolower($query);
        }
        $query = str_replace('ё', 'е', $query);
        preg_match_all('/[\p{L}\p{N}]+/u', $query, $matches);
        return array_slice($matches[0], 0, self::MAX_TOKENS);
    }

    private static function length($value)
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }
}
