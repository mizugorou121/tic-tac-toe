<?php

function setTurn (): array{
    $cpu = 1;
    echo "先攻か後攻を選択してください！\n";
    echo "1:先攻,2:後攻\n";
    $player = trim(fgets(STDIN));
    
    if ($player == 1) {
        $cpu = 2;
    }
    return [$player, $cpu];
}

function setPiece (): array {
    $playerPiece = 'x';
    $cpuPiece    = 'o';
    do{
        echo "○がいいですか？×がいいですか？\n";
        echo "1:○、2:×\n";

        $selectInput = trim(fgets(STDIN));
    } while ($selectInput === 1 || $selectInput ===2);

    if ($selectInput == 1) {
        $playerPiece = 'o';
        $cpuPiece    = 'x';
    }

    return [$playerPiece, $cpuPiece];
}

function selectPlace (): array {
    do {
        echo "縦の位置を0~2で入力してください！\n";
        $length = trim(fgets(STDIN));
    } while ($length >= 0 && $length < 3);
    do {
        echo "横の位置を0~2で入力してください！\n";
        $width = trim(fgets(STDIN));
    } while($width >= 0 && $width < 3);    
    
    return[$length,$width];
}

function display (array $pieceArray): void {
    for ($i=0; $i < 3; $i++) { 
        for ($j=0; $j < 3; $j++) { 
            if ($pieceArray[$i][$j] === 0) {
                echo "-";
            }
            else {
                echo $pieceArray[$i][$j];
            }
        }
        echo "\n";
    }
}

// 関数を使う
$setTurnArray = setTurn();
$setPieceArray = setPiece();
$selectPlaceArray = selectPlace();

$pieceArray = [
    [0,0,0],
    [0,0,0],
    [0,0,0]
];

$userPiece = $setPieceArray[0];
$length = $selectPlaceArray[0];
$width = $selectPlaceArray[1];
$pieceArray[$length][$width] = $userPiece;
display($pieceArray);