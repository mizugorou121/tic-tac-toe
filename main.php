<?php

function setTurn (): array{
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

function setPiece (): array {
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

$pieceArray = [
    [0,0,0],
    [0,0,0],
    [0,0,0]
];

function selectPlace (): array {
    echo "縦の位置を0~2で入力してください！";
    $length = trim(fgets(STDIN));

    echo "横の位置を0~2で入力してください！";
    $width = trim(fgets(STDIN));
    return[$length,$width];
}