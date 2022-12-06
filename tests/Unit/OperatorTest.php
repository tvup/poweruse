<?php

namespace Tests\Unit\Models;

use App\Models\Operator;
use Tests\TestCase;

class OperatorTest extends TestCase
{
    public function getGridAreas() {
        $this->assertEquals([], Operator::$gridOperatorArea);
    }
}
