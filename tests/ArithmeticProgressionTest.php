<?php

require_once '../src/Progression.php';
require_once '../src/NumericProgression.php';
require_once '../src/ArithmeticProgression.php';

use DevToolsParty\Progress\Progression;
use DevToolsParty\Progress\ArithmeticProgression;

/**
 * Class ArithmeticProgressionTest
 */
class ArithmeticProgressionTest extends PHPUnit_Framework_TestCase {
    public function testIsProgression() {
        $arr = [
            'one' => 1,
            2,
            'three' => 3,
            'four' => 4,
            'five' => 5,
            6
        ];

        $this->assertFalse(ArithmeticProgression::isProgression($arr));

        $seq = Progression::prepareSequence($arr);

        $this->assertEquals($seq, [1,2,3,4,5,6]);

        $this->assertTrue(ArithmeticProgression::isProgression($seq));

        $str = '1 3 5 7 9';

        $seq = Progression::prepareSequence($str);

        $this->assertEquals($seq, [1,3,5,7,9]);

        $this->assertTrue(ArithmeticProgression::isProgression($seq));

        $this->assertFalse(ArithmeticProgression::isProgression(array_merge($seq, [8, 9])));

        $seq[] = '111';
        $this->assertFalse(ArithmeticProgression::isProgression($seq));
    }

    public function testProgression() {
        $progression = new ArithmeticProgression(1, 1);
        $this->assertEquals($progression->getItem(), 1);
        $this->assertEquals($progression->getItem(2), 2);
        $this->assertEquals($progression->getItem(10), 10);
        $this->assertEquals($progression->getItem(2000), 2000);
        $this->assertEquals(count($progression->getItems(5)), 5);
        $this->assertEquals($progression->getItems(5), [1,2,3,4,5]);
        $seq = $progression->getItems(1500);
        $this->assertTrue(ArithmeticProgression::isProgression($seq));
        $this->assertEquals($progression->getSum(1500), array_sum($seq));
        $this->assertEquals($progression->getType(), ArithmeticProgression::TYPE_INCREASING);

        $progression = new ArithmeticProgression(10, -15);
        $this->assertEquals($progression->getItem(), 10);
        $this->assertEquals($progression->getItem(2), -5);
        $this->assertEquals($progression->getItem(10), -125);
        $this->assertEquals($progression->getItem(2000), -29975);
        $this->assertEquals(count($progression->getItems(50)), 50);
        $this->assertEquals($progression->getItems(5), [10,-5,-20,-35,-50]);
        $seq = $progression->getItems(1500);
        $this->assertTrue(ArithmeticProgression::isProgression($seq));
        $this->assertEquals($progression->getSum(1500), array_sum($seq));
        $this->assertEquals($progression->getType(), ArithmeticProgression::TYPE_DECREASING);
    }
}
