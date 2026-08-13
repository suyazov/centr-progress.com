<?php

namespace CentrProgress\Search;

final class CatalogSearch
{
    const IBLOCK_ID = 7;
    const MIN_TOKEN_LENGTH = 2;
    const MAX_QUERY_LENGTH = 256;
    const MAX_TOKENS = 8;
    const MAX_CANDIDATES = 2000;
    const MAX_RESULTS = 50;

    public static function search($query, $limit = self::MAX_RESULTS)
    {
        if (!\CModule::IncludeModule('iblock') || !class_exists('CIBlockElement')) {
            return array();
        }
        $tokens = self::tokens($query);
        if (!$tokens) {
            return array();
        }
        $limit = max(1, min((int) $limit, self::MAX_RESULTS));
        $rows = array();
        $result = \CIBlockElement::GetList(
            array('SORT' => 'ASC', 'ID' => 'ASC'),
            array(
                'IBLOCK_ID' => self::IBLOCK_ID,
                'ACTIVE' => 'Y',
                'ACTIVE_DATE' => 'Y',
                'CHECK_PERMISSIONS' => 'Y',
                'MIN_PERMISSION' => 'R',
            ),
            false,
            array('nTopCount' => self::MAX_CANDIDATES),
            array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'SORT')
        );
        while ($element = $result->GetNext()) {
            $score = self::score($element['NAME'], $tokens);
            if ($score === null) {
                continue;
            }
            $element['_SEARCH_SCORE'] = $score;
            $rows[] = $element;
        }
        usort($rows, array(__CLASS__, 'compare'));
        return array_slice($rows, 0, $limit);
    }

    public static function tokens($query)
    {
        $value = self::normalize($query);
        preg_match_all('/[\p{L}\p{N}]+/u', $value, $matches);
        $tokens = array();
        foreach (array_slice($matches[0], 0, self::MAX_TOKENS) as $token) {
            if (self::length($token) >= self::MIN_TOKEN_LENGTH) {
                $tokens[] = $token;
            }
        }
        return array_values(array_unique($tokens));
    }

    public static function score($name, array $tokens)
    {
        $normalized = self::normalize($name);
        preg_match_all('/[\p{L}\p{N}]+/u', $normalized, $matches);
        $words = $matches[0];
        $score = 0;
        foreach ($tokens as $token) {
            $best = null;
            foreach ($words as $position => $word) {
                if ($word === $token) {
                    $candidate = 1000 - $position;
                } elseif (strpos($word, $token) === 0) {
                    $candidate = 700 - $position - (self::length($word) - self::length($token));
                } else {
                    continue;
                }
                $best = $best === null ? $candidate : max($best, $candidate);
            }
            if ($best === null) {
                return null;
            }
            $score += $best;
        }
        if ($normalized === implode(' ', $tokens)) {
            $score += 2000;
        }
        return $score;
    }

    public static function compare($left, $right)
    {
        if ($left['_SEARCH_SCORE'] != $right['_SEARCH_SCORE']) {
            return $left['_SEARCH_SCORE'] > $right['_SEARCH_SCORE'] ? -1 : 1;
        }
        if ((int) $left['SORT'] != (int) $right['SORT']) {
            return (int) $left['SORT'] < (int) $right['SORT'] ? -1 : 1;
        }
        return (int) $left['ID'] - (int) $right['ID'];
    }

    private static function normalize($value)
    {
        $value = html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
        $value = function_exists('mb_substr') ? mb_substr($value, 0, self::MAX_QUERY_LENGTH, 'UTF-8') : substr($value, 0, self::MAX_QUERY_LENGTH);
        $value = function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value);
        return str_replace('ё', 'е', trim($value));
    }

    private static function length($value)
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }
}
