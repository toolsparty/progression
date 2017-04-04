<?php

namespace ToolsParty\Progression;

/**
 * Class Utils
 * @package ToolsParty\Progression
 */
trait Utils {

    /**
     * @param $a
     * @param $difference
     * @throws ProgressionException
     */
    public static function checkParams($a, $difference) {
        if (!is_numeric($a)) {
            throw new ProgressionException("Parameter 'a' is not numeric");
        }

        if (!is_numeric($difference)) {
            throw new ProgressionException("Parameter 'difference' is not numeric");
        }
    }

    /**
     * Checks the sequence according to the types integer and / or float
     * @param array $sequence - array with sequence
     * @return bool
     */
    protected static function checkIsNumericItems(array $sequence): bool
    {
        $isCheck = true;
        $callback = function (&$item, $key) use (&$isCheck) {
            if ($isCheck && !is_numeric($item)) {
                $isCheck = false;
            }
        };

        array_walk($sequence, $callback);

        return $isCheck;
    }
}