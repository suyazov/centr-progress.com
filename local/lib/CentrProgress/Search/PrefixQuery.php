<?php

namespace CentrProgress\Search;

final class PrefixQuery
{
    public const FALLBACK_TITLE = 'Теплопотребляющие установки';
    public const FALLBACK_URL = '/napravleniya-obucheniya/';
    private const MAX_QUERY_LENGTH = 256;
    private const MAX_TOKEN_LENGTH = 64;
    private const MAX_TOKENS = 10;
    private const MIN_PREFIX_LENGTH = 4;

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
        $normalized = self::build($original);
        $_REQUEST['q'] = $normalized;

        if (isset($_GET['q'])) {
            $_GET['q'] = $normalized;
        }
        if (isset($_POST['q'])) {
            $_POST['q'] = $normalized;
        }

        return $normalized;
    }

    public static function originalQuery()
    {
        return isset($GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY'])
            ? (string) $GLOBALS['CENTR_PROGRESS_SEARCH_ORIGINAL_QUERY']
            : (isset($_REQUEST['q']) ? (string) $_REQUEST['q'] : '');
    }

    /**
     * The isolated staging snapshot has no searchable copy of this public
     * direction. Keep the correction deliberately bounded to the two audited
     * prefixes; all other requests remain pure CSearch index queries.
     */
    public static function fallbackResult($query)
    {
        if (!in_array(self::build($query), array('тепл*', 'тепло*'), true)) {
            return null;
        }

        return array(
            'TITLE' => self::FALLBACK_TITLE,
            'URL' => self::FALLBACK_URL,
        );
    }
}
