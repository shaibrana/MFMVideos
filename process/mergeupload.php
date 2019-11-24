<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//ini_set("display_errors", "1");
require_once('../lib/Video.php');
$target_dir = "../uploads/";
$uploadOk = 1;
$names = array();
$mergedVideoHorizontally = '';
$mergedVideoVertically = '';
$videosCount = (count($_FILES["mergeVideos"]["name"]));
if ($videosCount != 2){
    $message = "Please upload two video files";
    $uploadOk = 0;
}
if ($uploadOk == 1){
    $content = "";
    $videoObj = new Video();
    for ($a = 0; $a < $videosCount; $a++){
        
        $videoFileType = strtolower(pathinfo($_FILES["mergeVideos"]["name"][$a],PATHINFO_EXTENSION));

        $target_file = $target_dir . $videoObj->rand_string(5).".".$videoFileType;

        // Check file size
        if ($_FILES["mergeVideos"]["size"][$a] > 5242880) { //5 MB limit
            $message = "Sorry, max file size is 5 MB.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($videoFileType != "mp4" && $videoFileType != "3gp") {
            $message = "Sorry, only MP4 videos are allowed.";
            $uploadOk = 0;
        }
        //Check type of uploaded file to make sure its a video
        if(!preg_match('/video\/*/',$_FILES['mergeVideos']['type'][$a])){
            $message = "Sorry, only video files are allowed.";
            $uploadOk = 0;    
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["mergeVideos"]["tmp_name"][$a], $target_file)) {
                $names[] = $target_file;
            } else {
                $message = "Sorry, there was an error uploading your file";
            }
        }

    }
}
if ($uploadOk == 1){
    $message = "Videos Uploaded succesffully.";
    $returnArray = array("message"=>$message, "status"=>"$uploadOk", "video1" => $names[0], "video2"=>$names[1]);
}else{
    $returnArray = array("message"=>$message, "status"=>"$uploadOk", "video1" => '', "video2"=>'');    
}
echo json_encode($returnArray);