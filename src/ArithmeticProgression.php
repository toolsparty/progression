<?php

namespace DevToolsParty\Progress;

/**
 * Class ArithmeticProgression
 * @package DevToolsParty\Progress
 */
class ArithmeticProgression extends Progression implements NumericProgression {

    use Utils;

    /**
     * @inheritdoc
     * ArithmeticProgression constructor.
     */
    public function __construct($a, $difference = 0, $length = null)
    {
        Utils::checkParams($a, $difference);

        parent::__construct($a, $difference, $length);
    }

    /**
     * @inheritdoc
     * @param int $n
     * @return float|int|string
     */
    public function getItem($n = 1)
    {
        return ($this->a + ($n - 1) * $this->difference);
    }

    /**
     * @inheritdoc
     * @param $length
     * @return float|int
     */
    public function getSum($length)
    {
        $this->setLength($length);

        return (($this->a + $this->getItem($this->length)) * $this->length) / 2;
    }

    /**
     * @inheritdoc
     * @param int $n
     * @return array
     */
    public function getItems($n): array
    {
        return range($this->a, $this->getItem($n), $this->difference);
    }

    /**
     * @inheritdoc
     * @param array $sequence
     * @return bool
     */
    public static function isProgression(array $sequence): bool
    {
        $isCheck = self::checkIsNumericItems($sequence);
        $n = count($sequence);

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
     * @param array $sequence
     * @return mixed|null
     */
    public static function getDifference(array $sequence)
    {
        return self::isProgression($sequence) ? $sequence[1] - $sequence[0] : null;
    }
}