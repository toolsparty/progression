<?php

require_once '../src/Progression.php';
require_once '../src/Utils.php';
require_once '../src/CharProgression.php';

use DevToolsParty\Progress\Progression;
use DevToolsParty\Progress\CharProgression;


class CharProgressionTest extends PHPUnit_Framework_TestCase {
    public function testIsProgression() {
        $arr = [
            'one' => 'a',
            'c',
            'e',
            'g'
        ];

        $this->assertFalse(CharProgression::isProgression($arr));

        $seq = CharProgression::prepareSequence($arr);

        $this->assertTrue(CharProgression::isProgression($seq));

        $str = 'a b c d e f';

        $seq = CharProgression::prepareSequence($str);

        $this->assertTrue(CharProgression::isProgression($seq));
    }

    public function testProgression() {
        $progression = new CharProgression('a', 1);
        $this->assertEquals($progression->getItems(5), ['a', 'b', 'c', 'd', 'e']);

        $progression = new CharProgression('a', 5);
        $this->assertEquals($progression->getItems(3), ['a', 'f', 'k']);

        $progression = new CharProgression('0', 4);
        $this->assertEquals($progression->getItems(4), ['0', '4', '8', '<']);
    }
}
