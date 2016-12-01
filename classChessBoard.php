<?php

class ChessBoard
{

    // public
    public $eventOnSetFigure; // func
    public $eventOnSetSpecificFigure; // func
    public $eventOnFigureType; // int

    // protected
    protected $width;
    protected $height;
    protected $game = [];

    function __construct($width, $height)
    {

        $this->width  = $width;
        $this->height = $height;

    }

    function __toString()
    {

        return serialize($this->game);

    }

    function __debugInfo()
    {

        echo 'Size: '.$this->getSize()[0].' , '.$this->getSize()[1]."\r\n";
        for ($x = 0; $x < $this->width; $x++ ) {
            for ($y = 0; $y < $this->height; $y++) {
                $isFree = $this->isFree($x,$y);
                if ($isFree === true) {
                    $type = '_';
                } else {
                    $type = $isFree;
                };
                echo '|_'.$type.'_';
            }
            echo "\r\n";
        }

    }

    public function getSize()
    {

        return [$this->width, $this->height];

    }

    public function load($data)
    {

        $this->clear();
        $this->game = unserialize($data);

    }

    public function clear()
    {

        $this->game = [];

    }

    /**
     * @param $x
     * @param $y
     * @param int $type
     * @return bool, true if set successful and false if not
     */
    public function setFigureOn($x, $y, $type = 0)
    {

        // user functions
        if (isset($this->eventOnSetFigure)) {
            $fun = $this->eventOnSetFigure;
            $fun($type, $x, $y);
        }

        if ($type == $this->eventOnFigureType && isset($this->eventOnSetSpecificFigure)) {
            $funSF = $this->eventOnSetSpecificFigure;
            $funSF($type, $x, $y);
        }

        // check board's ranges
        if (($x > $this->width) OR ($y > $this->height)) {
            throw new Exception('setFigureOn :: Out of board');
        }

        // create new Figure
        $figure = new Figure($x, $y, $type);

        // check free status and push if true
        if ($this->isFree($x, $y)) {
            array_push($this->game,$figure);
            return true;
        } else {
            return false;
        }

    }

    public function findFigure($x, $y)
    {

        if (($x > $this->width) OR ($y > $this->height)) {
            throw new Exception('findFigure :: Out of board');
        }

        foreach ($this->game as $f) {
            if (($f->x == $x) && ($f->y == $y)) {
                return $f;
            }
        }

        return false;

    }

    public function removeFigure(Figure $figure)
    {

        $delete_key = 'no';

        foreach ($this->game as $key => $f) {
            if (($f->x == $figure->x) && ($f->y == $figure->y)) {
                $delete_key = $key;
                break;
            }
        }

        if ($delete_key == 'no') {
            throw new Exception('removeFigure :: no such figure');
        } else {
            unset( $this->game[$delete_key] );
            unset( $figure ); 
        }

    }

    /**
     * @param Figure $figure - figure obj
     * @param $x - new position
     * @param $y - new position
     */
    public function moveFigureTo(Figure $figure, $x, $y)
    {

        // check board's ranges
        if (($x > $this->width) OR ($y > $this->height)) {
            throw new Exception('moveFigureTo :: Out of board');
        }

        // check destination and set new position if ok
        if ($this->isFree($x, $y)) {
            $figure->x = $x;
            $figure->y = $y;
        } else {
            throw new Exception('no free destination');
        }

    }

    /**
     * @param $x
     * @param $y
     * @return bool, true if free and type figure if not
     */
    public function isFree($x, $y)
    {
        if (($x > $this->width) OR ($y > $this->height)) {
            throw new Exception('isFree :: Out of board');
        }

        $result = true;

        foreach ($this->game as $f) {
            if (($f->x == $x) && ($f->y == $y)) {
                $result = $f->type;
                break;
            }
        }
        return $result;

    }
    
}

