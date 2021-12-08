<?php

function setTurn (){
    echo "先攻か後攻を選択してください！\n";
    echo "1:先攻,2:後攻\n";
    $player = trim(fgets(STDIN));
    
    if ($player = 1) {
        $cpu = "2";
    }
    else {
        $cpu = 1;
    }
    return [$player, $cpu];
}

function setPiece () {
    echo "○がいいですか？×がいいですか？/n";
    echo "1:○、2:×/n";
    $playerPiece = trim(fgets(STDIN));

    $selectInput = trim(fgets(STDIN));

    if ($selectInput = 1) {
        $playerPiece = 'o';
        $cpuPiece    = 'x';
    }
    else {
        $playerPiece = 'x';
        $cpuPiece    = 'o';
    }
    return [$playerPiece, $cpuPiece];
}

// 関数を使う
$setTurnArray = setTurn ();
$setPieceArray = setPiece();

echo "場所を指定してください！";