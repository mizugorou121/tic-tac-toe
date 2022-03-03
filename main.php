<?php
class User {
    //ユーザー○×場所選択
    private function selectPlace (array $pieceArray): array {
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

    //ユーザー処理
    public function userFlow (array $pieceArray, string $userPiece) :array{
        $game = new Game();
        $selectPlaceArray = $this->selectPlace($pieceArray);
        $length = $selectPlaceArray[0];
        $width = $selectPlaceArray[1];
        $pieceArray[$length][$width] = $userPiece;
        $game->display($pieceArray);
        return $pieceArray;
        

    }

}

class Cpu {
    //cpu○×場所選択
    private function selectCpu (array $pieceArray): array {
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

    //cpu処理
    public function cpuFlow (array $pieceArray, string $cpuPiece) :array{
        $game = new Game();
        $selectCpu = $this->selectCpu($pieceArray);
        $cpuLength = $selectCpu[0];
        $cpuWidth = $selectCpu[1];
        $pieceArray[$cpuLength][$cpuWidth] = $cpuPiece;
        $game->display($pieceArray);
        return $pieceArray;
}


}

class Game {
    //先攻後攻選択
    public function setTurn (): bool{
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
    public function setPiece (): array {
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

    //表示
    public function display (array $pieceArray): void {
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

    //勝敗判定
    public function pieceJudge (array $pieceArray, string $piece) {
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
    public function fullPiececheck (array $pieceArray) :bool{
        $fullPiece = true;
        for ($i = 0; $i < 3; $i++){
            if (in_array(0,array_column($pieceArray, $i))) {
                $fullPiece = false;
            }
        }

        return $fullPiece;
    }

    //勝敗・続行判定
    public function judgment (array $pieceArray,string $userPiece,string $cpuPiece) :bool{
        //user
        if($this->pieceJudge($pieceArray, $userPiece)){
            echo 'win!!';
            return false;
        }
        //cpu
        if($this->pieceJudge($pieceArray, $cpuPiece)){
            echo 'lose!!';
             return false;
       }
       if($this->fullPiececheck($pieceArray)){
                echo 'draw';
                return false;
      }
      return true;
    }
    function gameFlow() :void{ 
        $user = new User();
        $cpu = new Cpu();
    
    // 関数呼び出し
        $setPieceArray = $this->setPiece();
        $userPiece = $setPieceArray[0];
        $cpuPiece = $setPieceArray[1];
        $pieceArray = [
            [0,0,0],
            [0,0,0],
            [0,0,0]
        ];
    
        if ($this->setTurn()) {
            while ($this->judgment($pieceArray,$userPiece,$cpuPiece) ) {
                $pieceArray = $user->userFlow($pieceArray,$userPiece);
                $pieceArray = $cpu->cpuFlow($pieceArray,$cpuPiece);
            }
        }
        else {
            while ($this->judgment($pieceArray,$userPiece,$cpuPiece) ) {
                $pieceArray = $cpu->cpuFlow($pieceArray,$cpuPiece);
                $pieceArray = $user->userFlow($pieceArray,$userPiece);
            }
        }
    }
}

//----------------------------------------------------------------------

$game = new Game;
$game->gameFlow();