<?php

//先攻後攻選択
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

//○×選択
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

//場所選択
function selectPlace (): array {
    do {
        echo "縦の位置を0~2で入力してください！\n";
        $length = trim(fgets(STDIN));
    } while ($length >= 0 && $length > 3);
    do {
        echo "横の位置を0~2で入力してください！\n";
        $width = trim(fgets(STDIN));
    } while($width >= 0 && $width > 3);    
    
    return[$length,$width];
}

//表示
function display (array $pieceArray): void {
    for ($i=0; $i < 3; $i++) { 
        for ($j=0; $j < 3; $j++) { 
            if ($pieceArray[$i][$j] === 0) {
                echo '-';
            }
            elseif ($pieceArray[$i][$j] === 'o')  {
                echo 'o';
            }
            elseif ($pieceArray[$i][$j] === 'x') {
                echo 'x';
            }
        }
        echo "\n";
    }
}

function selectCpu (array $pieceArray): array {
    do {
        $cpuLength = rand(0,2);
        $cpuWidth = rand(0,2);
        $checkPiece = $pieceArray[$cpuLength][$cpuWidth];
    } while ( $checkPice = 0);
    return [$cpuLength,$cpuWidth];
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
$cpuPiece = $setPieceArray[1];
$length = $selectPlaceArray[0];
$width = $selectPlaceArray[1];
$pieceArray[$length][$width] = $userPiece;
display($pieceArray);

$selectCpu = selectCpu($pieceArray);
$cpuLength = $selectCpu[0];
$cpuWidth = $selectCpu[1];
$pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
display($pieceArray);

//勝敗判定
//横一列
if ($pieceArray[1] == ['o','o','o'] || $pieceArray[2] == ['o','o','o'] || $pieceArray[3] == ['o','o','o'] ) {
    $check = 1;
}
if ($pieceArray[1] == ['x','x','x'] || $pieceArray[2] == ['x','x','x'] || $pieceArray[3] == ['o','o','o'] ) {
    $check = 2;
}
