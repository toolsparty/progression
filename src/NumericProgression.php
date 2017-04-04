<?php

namespace DevToolsParty\Progress;

/**
 * Interface NumericProgression It contains definitions for numerical progressions
 * @package DevToolsParty\Progress
 */
interface NumericProgression {
    /**
     * Returns the sum of all elements of a sequence up to the nth member
     * @param $length
     * @return int|float
     */
    public function getSum($length);
}