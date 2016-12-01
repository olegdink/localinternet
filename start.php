<?php

require('classChessBoard.php');
require('classFigure.php');

$myBoard = new ChessBoard(5, 5);

// user's functionality on set any figure event
$myBoard->eventOnSetFigure = function (...$params) {

    // begin user's code
    echo "\r\n[ eventOnSetFigure ]\r\n\r\n";
    var_dump($params);
    echo "\r\n";
    // end user's code

};

// user's functionality on set just for figure type event
$myBoard->eventOnFigureType = 5;
$myBoard->eventOnSetSpecificFigure = function (...$params) use ($myBoard) {

    // begin user's code
    echo "\r\n[ eventOnSetSpecificFigure type = $myBoard->eventOnFigureType]\r\n";
    var_dump($params);
    echo "\r\n";
    // end users code

};

// set figure example

$myBoard->setFigureOn(2, 2, 5);
$myBoard->setFigureOn(1, 4, 3);

var_dump($myBoard);

// remove example

$f = $myBoard->findFigure(1, 4);
$myBoard->removeFigure($f);

var_dump($myBoard);

// move example

$f = $myBoard->findFigure(2, 2);
$myBoard->moveFigureTo($f, 3, 3);

var_dump($myBoard);

// you can save board to any storage (file, redis, mongo, memcache) example (now is a file)
// cause it's a string

file_put_contents('board.dat', $myBoard);

// load at anytime from any storage

$myBoard->clear();

var_dump($myBoard);

$myBoard->load(file_get_contents('board.dat'));

var_dump($myBoard);