<?php
class User {

}

class Cpu {

}

class Game {

}
//先攻後攻選択
function setTurn (): bool{
    echo "先攻か後攻を選択してください！\n";
    echo "1:先攻,2:後攻\n";
    $player = trim(fgets(STDIN));
    // true=先攻
    if ($player == 1) {
        return true;
    }
    return false;
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
function selectPlace (array $pieceArray): array {
    $checkPiece = 4;
    $length = 4;
    $width = 4;
    do {
        do {
            echo "縦の位置を0~2で入力してください！\n";
            $length = trim(fgets(STDIN));
        } while ($length >= 0 && $length > 3);
        do {
            echo "横の位置を0~2で入力してください！\n";
            $width = trim(fgets(STDIN));
        } while($width >= 0 && $width > 3);   
        $checkPiece = $pieceArray[$length][$width];
    } while ( $checkPiece !== 0);
     
    
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
    $checkPiece = 4;
    $cpuLength = 4;
    $cpuWidth = 4;
    do {
        $cpuLength = rand(0,2);
        $cpuWidth = rand(0,2);
        $checkPiece = $pieceArray[$cpuLength][$cpuWidth];
    } while ( $checkPiece !== 0);
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
    return  $pieceArray[0][0] === $piece && $pieceArray[1][0] === $piece && $pieceArray[2][0] === $piece ||
            $pieceArray[0][1] === $piece && $pieceArray[1][1] === $piece && $pieceArray[2][1] === $piece ||
            $pieceArray[0][2] === $piece && $pieceArray[1][2] === $piece && $pieceArray[2][2] === $piece ||
            $pieceArray[0] === [$piece,$piece,$piece] ||
            $pieceArray[1] === [$piece,$piece,$piece] ||
            $pieceArray[2] === [$piece,$piece,$piece] ||
            $pieceArray[0][0] === $piece && $pieceArray[1][1] === $piece && $pieceArray[2][2] === $piece ||
            $pieceArray[0][2] === $piece && $pieceArray[1][1] === $piece && $pieceArray[2][0] === $piece;
}

//置く場所が埋まっていないか確認
function fullPiececheck (array $pieceArray) :bool{
    $fullPiece = true;
    for ($i = 0; $i < 3; $i++){
        if (in_array(0,array_column($pieceArray, $i))) {
            $fullPiece = false;
        }
    }

    return $fullPiece;
}


// ユーザー処理
// function userFlow (array $pieceArray, string $userPiece): void {
//     $selectPlaceArray = selectPlace($pieceArray);
//     $length = $selectPlaceArray[0];
//     $width = $selectPlaceArray[1];
//     $pieceArray[$length][$width] = $userPiece;
//     display($pieceArray);
// }

// // コンピュータ処理
// function cpuFlow (array $pieceArray, string $cpuPiece): void {
//     $selectCpu = selectCpu($pieceArray);
//     $cpuLength = $selectCpu[0];
//     $cpuWidth = $selectCpu[1];
//     $pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
//     display($pieceArray);
// }

 function userFlow (array $pieceArray, string $userPiece) :array{
     $selectPlaceArray = selectPlace($pieceArray);
     $length = $selectPlaceArray[0];
     $width = $selectPlaceArray[1];
     $pieceArray[$length][$width] = $userPiece;
     display($pieceArray);
     return $pieceArray;

 }

 function cpuFlow (array $pieceArray, string $cpuPiece) :array{
     $selectCpu = selectCpu($pieceArray);
     $cpuLength = $selectCpu[0];
     $cpuWidth = $selectCpu[1];
     $pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
     display($pieceArray);
     return $pieceArray;
 }

// 関数呼び出し
    $isUserFirst = setTurn();
    $setPieceArray = setPiece();
    // $userTurn = $setTurnArray[0];
    // $cpuTurn = $setTurnArray[1];
    $userPiece = $setPieceArray[0];
    $cpuPiece = $setPieceArray[1];
    $pieceArray = [
        [0,0,0],
        [0,0,0],
        [0,0,0]
    ];

    if ($isUserFirst) {
        while (judgment($pieceArray,$userPiece,$cpuPiece) ) {
            $pieceArray = userFlow($pieceArray,$userPiece);
            $pieceArray = cpuFlow($pieceArray,$cpuPiece);
        }
    }
    else {
        while (judgment($pieceArray,$userPiece,$cpuPiece) ) {
            $pieceArray = cpuFlow($pieceArray,$cpuPiece);
            $pieceArray = userFlow($pieceArray,$userPiece);
        }
    }