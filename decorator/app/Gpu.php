<?php 

namespace App;

use App\decorator\ComputerDecorator;

class Gpu extends ComputerDecorator {

    public function getPrice(): int 
    {
        return $this->computer->getPrice() + 530;
    }

    public function getDescription(): string 
    {
        return $this->computer->getDescription().", with GPU";
    }
}
