<?php

require_once 'env.php';
require_once 'polite.class.php';

Polite::cors();

header('Content-type: application/json');

$accountId = 1;
$appId = 1;
$puzzleVersion = 1;
$puzzleExpiry = EXPIRY_TIMES_5_MINUTES;
$numberOfSolutions = NUMBER_OF_SOLUTIONS;
$puzzleDifficulty = PUZZLE_DIFFICULTY;

$nonce = random_bytes(8);


$timeHex = dechex(time());
$accountIdHex = Polite::padHex(dechex($accountId), 4);
$appIdHex = Polite::padHex(dechex($appId), 4);
$puzzleVersionHex = Polite::padHex(dechex($appId), 1);
$puzzleExpiryHex = Polite::padHex(dechex($puzzleExpiry), 1);
$numberOfSolutionsHex = Polite::padHex(dechex($numberOfSolutions), 1);
$puzzleDifficultyHex = Polite::padHex(dechex($puzzleDifficulty), 1);
$reservedHex = Polite::padHex('', 8);
$puzzleNonceHex = Polite::padHex(bin2hex($nonce), 8);

$bufferHex = Polite::padHex($timeHex, 4) . $accountIdHex . $appIdHex . $puzzleVersionHex . $puzzleExpiryHex . $numberOfSolutionsHex . $puzzleDifficultyHex . $reservedHex . $puzzleNonceHex;


$buffer = hex2bin($bufferHex);
$hash = Polite::signBuffer($buffer);

$puzzle = $hash . '.' . base64_encode($buffer);


$result = [
        'data' => [
                'puzzle' => $puzzle
            ]
        ];

echo json_encode($result);
