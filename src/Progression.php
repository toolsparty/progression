<?php

namespace DevToolsParty\Progression;

/**
 * Class Progression
 * common properties for progressions
 * @package DevToolsParty\Progress
 */
abstract class Progression {

    /**
     * The first term of an arithmetic progression
     * @var int|float|string
     */
    protected $a;

    /**
     * Step progression
     * @var int|float
     */
    protected $difference = 0;

    /**
     * Sequence length
     * @var int|null
     */
    protected $length;

    /**
     * Progression constructor.
     * @param $a - first member of the progression
     * @param int|float $difference - step progression
     * @param int|null $length - progression length
     * @throws ProgressionException
     */
    public function __construct($a, $difference = 0, $length = null)
    {
        $this->a = $a;
        $this->difference = $difference;

        $this->setLength($length);
    }

    /**
     * Sets the length of the sequence
     * @param int $length - progression length
     * @throws ProgressionException
     */
    public function setLength($length)
    {
        if ($length !== null && (int)$length == 0) {
            throw new ProgressionException("Parameter 'length' must be numeric and greater than zero");
        }

        $this->length = (int)$length;
    }

    /**
     * Returns the value of the sequence length
     * @return int|null
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Progression increasing
     */
    const TYPE_INCREASING = 1;

    /**
     * Progression decreasing
     */
    const TYPE_DECREASING = -1;

    /**
     * Stationary progression
     */
    const TYPE_STATIONARY = 0;

    /**
     * Returns the type of progression
     * @return int
     */
    public function getType(): int
    {
        if ($this->difference > 0) {
            return self::TYPE_INCREASING;
        } elseif ($this->difference < 0) {
            return self::TYPE_DECREASING;
        } else {
            return self::TYPE_STATIONARY;
        }
    }

    /**
     * Separator for the sequence in the default row
     */
    const DEFAULT_DELIMITER = ' ';

    /**
     * The method prepares a string or array for use in child classes
     * @param array|string $sequence - sequence
     * @param string $delimiter - string separator
     * @return array - sequence as an array
     */
    public static function prepareSequence($sequence, $delimiter = self::DEFAULT_DELIMITER): array
    {
        if (is_array($sequence)) {
            return array_values($sequence);
        } elseif (is_string($sequence)) {
            return explode($delimiter, $sequence);
        }

        return [];
    }

    /**
     * Displays the line sequence
     * @return string
     * @throws ProgressionException
     */
    public function __toString()
    {
        if (!$this->length) {
            throw new ProgressionException("Progression length is undefined");
        }

        return implode(self::DEFAULT_DELIMITER, $this->getItems($this->length));
    }

    /**
     * Returns the nth member of the progression
     * @param int $n - progression member number
     * @return mixed
     */
    abstract public function getItem($n = 1);

    /**
     * Returns an array with elements of the sequence up to the nth progression member
     * @param int $n - sequence element number
     * @return array
     */
    abstract public function getItems($n): array;

    /**
     * Returns true if the sequence is a progression, false - if not
     * @param array $sequence - array sequence
     * @return bool
     */
    abstract public static function isProgression(array $sequence): bool;

    /**
     * Returns the step (difference) of the sequence
     * @param array $sequence
     * @return int|float|null
     */
    abstract public static function getDifference(array $sequence);
}