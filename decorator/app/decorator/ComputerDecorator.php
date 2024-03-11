<?php

namespace App\decorator;

use App\Computer;

abstract class ComputerDecorator implements Computer {
    protected Computer $computer;

    public function __construct(Computer $computer){
        $this->computer = $computer;
    }
}