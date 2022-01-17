<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer;

/**
 * Mapping for Psalm issue type to DeepSource issue code.
 */
class IssueMapping
{
    private static array $mapping = [
        'PossiblyNullReference' => 'PSM-W1000',
    ];

    /**
     * Checks whether given psalm type mapped with any issue code or not.
     */
    public static function exists(string $psalmResultType): bool
    {
        return isset(self::$mapping[$psalmResultType]);
    }

    /**
     * Returns issue code for given psalm type.
     */
    public static function getIssueCode(string $psalmResultType): string
    {
        return self::$mapping[$psalmResultType];
    }
}
