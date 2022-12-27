<?php

namespace Tests\Unit;

use App\Models\Operator;
use Tests\TestCase;

class OperatorTest extends TestCase
{
    public function testGetGridAreaForOperator() {
        $this->assertEquals('DK2', Operator::$gridOperatorArea['Radius Elnet A/S']);
    }

    public function testGetOperatorNumbers() {
        $this->assertEquals('5790000705689', Operator::$operatorNumber['Radius Elnet A/S']);
    }

    public function testGetOperatorName() {
        $this->assertEquals('Radius Elnet A/S', Operator::$operatorName['5790000705689']);
    }
}
