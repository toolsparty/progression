<?php

namespace DevToolsParty\Progress;

class GeometricProgression extends Progression implements NumericProgression {

    use Utils;

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

    public function getItem($n)
    {
        return $this->a * pow($this->difference, $n - 1);
    }

    public function getItems($n): array
    {
        $items = array_fill(0, $n - 1, $this->a);

        array_walk($items, function (&$item, $key, $q) use ($items) {
            $b = ($key) ? $items[$key - 1] : $items[$key];
            $item = $b * $q;
        }, $this->difference);

        return $items;
    }

    public function getSum($n)
    {
        return ($this->getItem($n) * $this->difference - $this->a) / ($this->difference - 1);
    }

    public function getProduct($n)
    {
        return pow($this->a * $this->getItem($n), $n/2);
    }

    public static function isProgression(array $sequence): bool
    {
        $isCheck = self::checkIsNumericItems($sequence);
        $n = count($sequence);

        if ($isCheck && $n > 2) {
            try {
                //$progression = new self($sequence[0]);
            } catch (\Exception $e) {

            }
        } elseif ($isCheck && $n == 2) {
            return true;
        }

        return false;
    }

    public static function getDifference(array $sequence)
    {
        // TODO: Implement getDifference() method.
    }
}