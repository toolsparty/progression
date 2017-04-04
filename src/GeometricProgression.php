<?php

namespace DevToolsParty\Progression;

/**
 * Class GeometricProgression
 * @package DevToolsParty\Progress
 */
class GeometricProgression extends Progression implements NumericProgression {

    use Utils;

    /**
     * GeometricProgression constructor.
     * @param $a
     * @param int $difference
     * @param null $length
     * @throws ProgressionException
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
     * @param int $n
     * @return float|int|string
     */
    public function getItem($n = 1)
    {
        return $this->a * pow($this->difference, $n - 1);
    }

    /**
     * @inheritdoc
     * @param int $n
     * @return array
     */
    public function getItems($n): array
    {
        $items = [];

        for ($i = 1; $i <= $n; ++$i) {
            $items[$i - 1] = $this->a * pow($this->difference, $i - 1);
        }

        return $items;
    }

    /**
     * @inheritdoc
     * @param $n
     * @return float
     */
    public function getSum($n)
    {
        return ($this->getItem($n) * $this->difference - $this->a) / ($this->difference - 1);
    }

    /**
     * @inheritdoc
     * @param $n
     * @return number
     */
    public function getProduct($n)
    {
        return pow($this->a * $this->getItem($n), $n / 2);
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
            try {
                $progression = new self($sequence[0], $sequence[1] / $sequence[0]);

                return ($progression->getSum($n) == array_sum($sequence) && $progression->getProduct($n) == array_product($sequence));
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
     * @return float|int
     */
    public static function getDifference(array $sequence)
    {
        return self::isProgression($sequence) ? $sequence[1] / $sequence[0] : null;
    }
}