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
    echo "\n";
}

function selectCpu (array $pieceArray): array {
    do {
        $cpuLength = rand(0,2);
        $cpuWidth = rand(0,2);
        $checkPiece = $pieceArray[$cpuLength][$cpuWidth];
    } while ( $checkPice = 0);
    return [$cpuLength,$cpuWidth];
}

function judgment (array $pieceArray,string $userPiece,string $cpuPiece) :bool{
    //user
    if(pieceJudge($pieceArray, $userPiece)){
        echo 'win!!';
        return false;
    }
    //cpu
    if(pieceJudge($pieceArray, $cpuPiece)){
        echo 'lose!!';
         return false;
   }
   if(fullPiececheck($pieceArray)){
            echo 'draw';
            return false;
  }
  return true;
}

//勝敗・続行判定
function pieceJudge (array $pieceArray, string $piece) {
    return  $pieceArray[0][0] == $piece && $pieceArray[1][0] == $piece && $pieceArray[2][0] == $piece ||
            $pieceArray[0][1] == $piece && $pieceArray[1][1] == $piece && $pieceArray[2][1] == $piece ||
            $pieceArray[0][2] == $piece && $pieceArray[1][2] == $piece && $pieceArray[2][2] == $piece ||
            $pieceArray[0] == [$piece,$piece,$piece] ||
            $pieceArray[1] == [$piece,$piece,$piece] ||
            $pieceArray[2] == [$piece,$piece,$piece] ||
            $pieceArray[0][0] == $piece && $pieceArray[1][1] == $piece && $pieceArray[2][2] == $piece ||
            $pieceArray[0][2] == $piece && $pieceArray[1][1] == $piece && $pieceArray[2][0] == $piece;
}

//置く場所が埋まっていないか確認
function fullPiececheck (array $pieceArray) :bool{
    $fullPiece = true;
    if (in_array(0,$pieceArray)) {
    $fullPiece = false;
    }
    return $fullPiece;
}

// 関数呼び出し

    $setTurnArray = setTurn();
    $setPieceArray = setPiece();
    $userTurn = $setTurnArray[0];
    $cpuTurn = $setTurnArray[1];
    $userPiece = $setPieceArray[0];
    $cpuPiece = $setPieceArray[1];
    $pieceArray = [
        [0,0,0],
        [0,0,0],
        [0,0,0]
    ];

    if ($userTurn == 1) {
        while (judgment($pieceArray,$userPiece,$cpuPiece) ) {
            $selectPlaceArray = selectPlace();
            $length = $selectPlaceArray[0];
            $width = $selectPlaceArray[1];
            $pieceArray[$length][$width] = $userPiece;
            display($pieceArray);
    
            $selectCpu = selectCpu($pieceArray);
            $cpuLength = $selectCpu[0];
            $cpuWidth = $selectCpu[1];
            $pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
            display($pieceArray);
        }
    }
    
    if ($userTurn == 2) {
        while (judgment($pieceArray,$userPiece,$cpuPiece) ) {
            $selectCpu = selectCpu($pieceArray);
            $cpuLength = $selectCpu[0];
            $cpuWidth = $selectCpu[1];
            $pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
            display($pieceArray);

            $selectPlaceArray = selectPlace();
            $length = $selectPlaceArray[0];
            $width = $selectPlaceArray[1];
            $pieceArray[$length][$width] = $userPiece;
            display($pieceArray);
        }
    }