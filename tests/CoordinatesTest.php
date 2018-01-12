<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use CoordinatesTest\Coordinates;
use CoordinatesTest\Exceptions\InvalidParameterException;
use CoordinatesTest\Exceptions\CoordinateOutOfRangeException;

/**
 * @covers Coordinates
 */
final class CoordinatesTest extends TestCase
{
    public function testInvalidParametersCoordinates()
    {
        $this->expectException(InvalidParameterException::class);
        $coordinates = new Coordinates("a", "b");
        $coordinates = new Coordinates(0, "b");
        $coordinates = new Coordinates("a", 0);
        $coordinates = new Coordinates(false, false);
    }

    public function testOutofRangeCoordinates()
    {
        $this->expectException(CoordinateOutOfRangeException::class);
        $coordinates = new Coordinates(-180, -91);
        $coordinates = new Coordinates(-90, -181);
    }

    public function testDistance()
    {
        $coord = new Coordinates(53.339428, -6.257664);

        $to = new Coordinates(53.345051, -6.270888);

        $this->assertEquals(
            1.07780,
            $coord->getDistanceTo($to, 5)
        );

        $this->assertEquals(
            1.07779916,
            $coord->getDistanceTo($to, 8)
        );
    }

    public function testWithinDistance()
    {
        $mainCoord = new Coordinates(53.339428, -6.257664);
        $testCoords = [
            [53.345051, -6.270888, 1, false],
            [53.345051, -6.270888, 2, true],
            [54.345051, -6.270888, 1, false],
            [54.345051, 50.270888, 1, false],
            [53.339428, -6.257664, 1, true],
            [53.339428, -6.257764, 1, true],
            [53.339448, -6.257764, 1, true],
            [54.345051, -6.270888, 1000, true],
            [54.345051, -6.270888, 500, true],
            [53.845051, -6.270888, 200, true],
        ];

        foreach ($testCoords as $coord) {
            $currentCoords = new Coordinates($coord[0], $coord[1]);
            
            if ($coord[3] === false) {
                $this->assertFalse($mainCoord->isWithinDistance($currentCoords, $coord[2]));
            } else {
                $this->assertTrue($mainCoord->isWithinDistance($currentCoords, $coord[2]));
            }
        }
        
    }
}
