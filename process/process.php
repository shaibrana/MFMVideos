<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../lib/Video.php');

//ini_set("display_errors", "1");

$fileName = filter_input(INPUT_POST, "fileName", FILTER_DEFAULT);
 
$videoObj = new Video();

$fileName = '../uploads/'.$fileName;
        
$size = $videoObj->getSize($fileName);

$sizeInMB = round((int)$size/(1024*1024), 2); //convert Bytes to Mega bytes
$duration = $videoObj->getDuration($fileName);

$returnFiles = $videoObj->separateSoundLayer($fileName);
$audio = $returnFiles['audio'];

$returnArray = array("size"=>$sizeInMB, "duration"=>$duration, "audio" => $audio);
echo json_encode($returnArray);
