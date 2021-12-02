<?php
echo "先攻か後攻を選択してください！\n";
echo "1:先攻,2:後攻\n";
$player = trim(fgets(STDIN));

if ($player = 1) {
    $cpu = "2\n";
}
else {
    $cpu = 1;
}

// echo $cpu;
// echo $player;

echo "場所を指定してください！";
