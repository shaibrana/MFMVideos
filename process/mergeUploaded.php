<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('max_execution_time', 300);
require_once('../lib/Video.php');
$videoObj = new Video();

$fileName1 = filter_input(INPUT_POST, "video1", FILTER_DEFAULT);
$fileName2 = filter_input(INPUT_POST, "video2", FILTER_DEFAULT);
$type = filter_input(INPUT_POST, "type", FILTER_DEFAULT);

if ($type == 'mergeHorizontally'){
    $mergedVideo = $videoObj->mergeVideosHorizontally($fileName1, $fileName2);
}else{
    $mergedVideo = $videoObj->mergeVideosVertically($fileName1, $fileName2);
}
$message = "Videos merged succesffully.";

$returnArray = array("message"=>$message, "mergedVideo" => $mergedVideo);
echo json_encode($returnArray);