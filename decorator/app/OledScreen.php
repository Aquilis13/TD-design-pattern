<?php

namespace App;

use App\decorator\ComputerDecorator;

class OledScreen extends ComputerDecorator {

    public function getPrice(): int 
    {
        return $this->computer->getPrice() + 170;
    }

    public function getDescription(): string 
    {
        return $this->computer->getDescription().", with OLED Screen";
    }
}