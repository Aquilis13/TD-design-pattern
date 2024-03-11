<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use App\Laptop;
use App\Gpu;
use App\OledScreen;

class ComputerDecoratorTest extends TestCase
{
    public function testBasicLaptop()
    {
        $laptop = new Laptop();
        
        $this->assertSame(400, $laptop->getPrice());
        $this->assertSame("A laptop computer", $laptop->getDescription());
    }

    public function testLaptopWithGPU()
    {
        $computer = new Laptop();
        $computer = new Gpu($computer);
        
        $this->assertSame(930, $computer->getPrice());
        $this->assertSame("A laptop computer, with GPU", $computer->getDescription());
    }

    public function testLaptopWithOLEDScreen()
    {
        $computer = new Laptop();
        $computer = new OledScreen($computer);
        
        $this->assertSame(570, $computer->getPrice());
        $this->assertSame("A laptop computer, with OLED Screen", $computer->getDescription());
    }

    public function testLaptopWithOLEDScreenAndGpu()
    {
        $computer1 = new Laptop();
        $computer1 = new OledScreen($computer1);
        $computer1 = new Gpu($computer1);
        
        $this->assertSame(1100, $computer1->getPrice());
        $this->assertSame("A laptop computer, with OLED Screen, with GPU", $computer1->getDescription());

        $computer2 = new Laptop();
        $computer2 = new Gpu($computer2);
        $computer2 = new OledScreen($computer2);
        
        $this->assertSame(1100, $computer2->getPrice());
        $this->assertSame("A laptop computer, with GPU, with OLED Screen", $computer2->getDescription());
    }
}