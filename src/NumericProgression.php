<?php

namespace ToolsParty\Progression;

/**
 * Interface NumericProgression It contains definitions for numerical progressions
 * @package ToolsParty\Progression
 */
interface NumericProgression {
    /**
     * Returns the sum of all elements of a sequence up to the nth member
     * @param $length
     * @return int|float
     */
    public function getSum($length);
}