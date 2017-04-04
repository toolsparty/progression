<?php

require_once '../src/Progression.php';
require_once '../src/NumericProgression.php';
require_once '../src/Utils.php';
require_once '../src/GeometricProgression.php';


use DevToolsParty\Progression\Progression;
use DevToolsParty\Progression\GeometricProgression;


class GeometricProgressionTest extends PHPUnit_Framework_TestCase {
    public function testIsProgression()
    {
        $arr = [
            'one' => 1,
            'tow' => 3,
            9,
            27,
            81,
            243
        ];

        $this->assertFalse(GeometricProgression::isProgression($arr));
        $seq = Progression::prepareSequence($arr);
        $this->assertEquals($seq, [1, 3, 9, 27, 81, 243]);

        $this->assertTrue(GeometricProgression::isProgression($seq));

        $str = '5 10 20 40 80 160 320 640 1280 2560 5120';

        $seq = Progression::prepareSequence($str);
        $this->assertEquals($seq, [5, 10, 20, 40, 80, 160, 320, 640, 1280, 2560, 5120]);
        $this->assertTrue(GeometricProgression::isProgression($seq));

        $this->assertTrue(GeometricProgression::isProgression(array_merge($seq, [10240])));
        $this->assertFalse(GeometricProgression::isProgression(array_merge($seq, [5000])));
    }

    public function testProgression()
    {
        $progression = new GeometricProgression(7, 9);
        $this->assertEquals($progression->getItem(), 7);
        $this->assertEquals($progression->getItem(3), 567);
        $this->assertEquals($progression->getItem(10), 2711943423);
        $this->assertEquals($progression->getItems(5), [7, 63, 567, 5103, 45927]);
        $seq = $progression->getItems(50);
        $this->assertTrue(GeometricProgression::isProgression($seq));
        $this->assertEquals($progression->getSum(50), array_sum($seq));
        $this->assertEquals($progression->getProduct(50), array_product($seq));
        $this->assertEquals($progression->getType(), Progression::TYPE_INCREASING);
    }
}
