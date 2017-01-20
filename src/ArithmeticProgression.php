<?php

namespace DevToolsParty\Progress;

/**
 * Class ArithmeticProgression
 * @package DevToolsParty\Progress
 */
class ArithmeticProgression extends Progression implements NumericProgression {

    /**
     * @inheritdoc
     * ArithmeticProgression constructor.
     */
    public function __construct($a, $difference = 0, $length = null)
    {
        if (!is_numeric($a)) {
            throw new ProgressionException("Parameter 'a' is not numeric");
        }

        if (!is_numeric($difference)) {
            throw new ProgressionException("Parameter 'difference' is not numeric");
        }

        parent::__construct($a, $difference, $length);
    }

    /**
     * @inheritdoc
     */
    public function getItem($n = 1)
    {
        return ($this->a + ($n - 1) * $this->difference);
    }

    /**
     * @inheritdoc
     */
    public function getSum($length)
    {
        $this->setLength($length);

        return (($this->a + $this->getItem($this->length)) * $this->length) / 2;
    }

    /**
     * @inheritdoc
     */
    public function getItems($n): array
    {
        return range($this->a, $this->getItem($n), $this->difference);
    }

    /**
     * @inheritdoc
     */
    public static function isProgression(array $sequence): bool
    {
        $isCheck = self::checkItemsTypes($sequence);
        $n = count($sequence);
//        var_dump($isCheck);

        if ($isCheck && $n > 2) {
            $c = mt_rand(1, $n - 1);

            try {
                $progression = new self($sequence[0], $sequence[1] - $sequence[0]);

                return ($sequence[$c] == $progression->getItem($c + 1) && array_sum($sequence) == $progression->getSum($n));
            } catch (\Exception $e) {
                return false;
            }
        } elseif ($isCheck && $n == 2) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public static function getDifference(array $sequence)
    {
        return self::isProgression($sequence) ? $sequence[1] - $sequence[0] : null;
    }

    /**
     * Проверяет последовательность на соответствии типам integer и/или float
     * @param array $sequence - массив с последовательностью
     * @return bool
     */
    protected static function checkItemsTypes(array $sequence): bool
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