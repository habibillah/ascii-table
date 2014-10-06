<?php

//namespace Utility;

use Utility\AsciiTable;

class AsciiTableTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyArray() {
        $asciiTable = new AsciiTable(array());
        $this->assertEmpty($asciiTable->render());
    }

    public function testNonArray() {
        $this->setExpectedException('InvalidArgumentException', 'The data just accepted array.');

        $asciiTable = new AsciiTable(1);
        $asciiTable->render();
    }

    public function testMultiCulumn() {

        $asciiTable = new AsciiTable(array(
            array(
                'Name' => 'Tinkerbell',
                'Element' => 'Air',
                'field2' => 'field2 value',
                'Likes' => 'Singning',
                'Color' => 'Blue',
                'field3' => 'field3 value'
            ),
            array(
                'Name' => 'Trixie',
                'Color' => 'Green',
                'Element' => 'Earth',
                'Likes' => 'Flowers',
                'field1' => 'field1 value'
            ),
            array(
                'Element' => 'Water',
                'Likes' => 'Dancing',
                'Name' => 'Blum',
                'Color' => 'Pink',
            ),
        ));

        $expect = "+----------------+-----------+------------------+--------------+-----------+------------------+------------------+\n";
        $expect .= "+      Name      |  Element  |      field2      |    Likes     |   Color   |      field3      |      field1      |\n";
        $expect .= "+----------------+-----------+------------------+--------------+-----------+------------------+------------------+\n";
        $expect .= "+ Tinkerbell     | Air       | field2 value     | Singning     | Blue      | field3 value     |                  |\n";
        $expect .= "+----------------+-----------+------------------+--------------+-----------+------------------+------------------+\n";
        $expect .= "+ Trixie         | Earth     |                  | Flowers      | Green     |                  | field1 value     |\n";
        $expect .= "+----------------+-----------+------------------+--------------+-----------+------------------+------------------+\n";
        $expect .= "+ Blum           | Water     |                  | Dancing      | Pink      |                  |                  |\n";
        $expect .= "+----------------+-----------+------------------+--------------+-----------+------------------+------------------+\n";
        $this->assertEquals($expect, $asciiTable->render());
    }

    public function testTwoDimenstionOfArray() {
        $asciiTable = new AsciiTable(array(
            array(
                'Name' => 'Trixie',
                'Color' => 'Green',
                'Element' => 'Earth',
                'Likes' => 'Flowers'
            ),
            array(
                'Name' => 'Tinkerbell',
                'Element' => 'Air',
                'Likes' => 'Singning',
                'Color' => 'Blue'
            ),
            array(
                'Element' => 'Water',
                'Likes' => 'Dancing',
                'Name' => 'Blum',
                'Color' => 'Pink'
            ),
        ));

        $expected = "+----------------+-----------+-----------+--------------+\n";
        $expected .= "+      Name      |   Color   |  Element  |    Likes     |\n";
        $expected .= "+----------------+-----------+-----------+--------------+\n";
        $expected .= "+ Trixie         | Green     | Earth     | Flowers      |\n";
        $expected .= "+----------------+-----------+-----------+--------------+\n";
        $expected .= "+ Tinkerbell     | Blue      | Air       | Singning     |\n";
        $expected .= "+----------------+-----------+-----------+--------------+\n";
        $expected .= "+ Blum           | Pink      | Water     | Dancing      |\n";
        $expected .= "+----------------+-----------+-----------+--------------+\n";
        $this->assertEquals($expected, $asciiTable->render());
    }

}