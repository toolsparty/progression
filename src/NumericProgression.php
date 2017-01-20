<?php

namespace DevToolsParty\Progress;

/**
 * Interface NumericProgression содержит определния для числовых прогрессий
 * @package DevToolsParty\Progress
 */
interface NumericProgression {
    /**
     * Возвращает сумму всех элементов последовательности до n-го члена
     * @param $n
     * @return int|float
     */
    public function getSum($n);
}