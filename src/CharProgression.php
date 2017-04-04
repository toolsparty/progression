<?php

namespace DevToolsParty\Progression;

/**
 * Class CharProgression
 * @package DevToolsParty\Progress
 */
class CharProgression extends Progression {

    /**
     * CharProgression constructor.
     * @param mixed $a
     * @param int $difference
     * @param null $length
     */
    public function __construct($a, $difference = 0, $length = null)
    {
        parent::__construct($a, $difference, $length);
    }

    /**
     * @inheritdoc
     * @param int $n
     * @return string
     */
    public function getItem($n = 1): string
    {
        return chr((ord($this->a) + ($n - 1) * $this->difference));
    }

    /**
     * @inheritdoc
     * @param int $n
     * @return array
     */
    public function getItems($n): array
    {
        $items = [];

        for ($i = ord($this->a), $j = 0; $i < ord($this->a) + $n*$this->difference; $i += $this->difference, ++$j) {
            $items[$j] = chr($i);
        }

        return $items;
    }

    /**
     * @inheritdoc
     * @param array $sequence
     * @return bool
     */
    public static function isProgression(array $sequence): bool
    {
        $n = count($sequence);

        if ($n > 2) {
            $c = mt_rand(1, $n - 1);

            try {
                $progression = new self($sequence[0], ord($sequence[1]) - ord($sequence[0]));

                return ($sequence[$c] == $progression->getItem($c + 1) && count(array_diff($sequence, $progression->getItems($n))) == 0);
            } catch (\Exception $e) {
                return false;
            }

        } elseif ($n == 2) {
            return false;
        }

        return false;
    }

    /**
     * @inheritdoc
     * @param array $sequence
     * @return int|null
     */
    public static function getDifference(array $sequence)
    {
        return self::isProgression($sequence) ? ord($sequence[1]) - ord($sequence[0]) : null;
    }
}