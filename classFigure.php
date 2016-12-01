<?php

class Figure
{
    
    public $x;
    public $y;
    public $type; // int

    function __construct($x = 0, $y = 0, $type = 0)
    {
        $this->x    = $x;
        $this->y    = $y;
        $this->type = $type;
    }

}