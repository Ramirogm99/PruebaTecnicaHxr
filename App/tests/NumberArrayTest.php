<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\NumberToArray\NumberArray;

class NumberArrayTest extends TestCase
{
    public function test_numberarray() : void
    {
        $numbertoarray = new NumberArray();
        $array = [1, 4, 9, 16, 25];
        $this->assertEquals(["08:00"=> 1, "08:30" => 4,"09:00" =>9,"09:30" => 16,"10:00" => 25], $numbertoarray->CreateArray($array));
    }
}