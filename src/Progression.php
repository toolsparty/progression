<?php

namespace DevToolsParty\Progress;

/**
 * Class Progression определяет общие свойства для прогрессий
 * @package DevToolsParty\Progress
 */
abstract class Progression {

    /**
     * Первый член арифметической прогрессии
     * @var int|float|string
     */
    protected $a;

    /**
     * Шаг прогрессии
     * @var int|float
     */
    protected $difference = 0;

    /**
     * Длина последовательности
     * @var int|null
     */
    protected $length;

    /**
     * Progression constructor.
     * @param $a - первый член прогресии
     * @param int|float $difference - шаг прогресии
     * @param int|null $length - длинна прогресии
     * @throws ProgressionException
     */
    public function __construct($a, $difference = 0, $length = null)
    {
        $this->a = $a;
        $this->difference = $difference;

        $this->setLength($length);
    }

    /**
     * Устанавливает длину последовательности
     * @param int $length - длина последовательности
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
     * Возвращает значение длины последовательности
     * @return int|null
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Прогрессия возрастающая
     */
    const TYPE_INCREASING = 1;

    /**
     * Прогрессия убывающая
     */
    const TYPE_DECREASING = -1;

    /**
     * Стационарная прогрессия
     */
    const TYPE_STATIONARY = 0;

    /**
     * Возвращает тип прогрессии
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
     * разделитель для последовательности в строке по умолчанию
     */
    const DEFAULT_DELIMITER = ' ';

    /**
     * Метод подготавливает строку или массив для использования в потомках
     * @param array|string $sequence - последовательность
     * @param string $delimiter - разделитель строки
     * @return array - массив с последовательностью
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
     * Выводит последовательность строкой
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
     * Возвращает n-ый член прогрессии
     * @param int $n - номер члена прогресии
     * @return mixed
     */
    abstract public function getItem($n = 1);

    /**
     * Возвращает массив с элементами последовательности до n-го члена
     * @param int $n - номер элемента последовательности
     * @return array
     */
    abstract public function getItems($n): array;

    /**
     * возвращает true если последовательность является прогрессией, false - если нет
     * @param array $sequence - массив последовательность
     * @return bool
     */
    abstract public static function isProgression(array $sequence): bool;

    /**
     * Возвращает шаг(разность) последовательности
     * @param array $sequence
     * @return int|float|null
     */
    abstract public static function getDifference(array $sequence);
}