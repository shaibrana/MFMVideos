<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//ini_set("display_errors", "1");
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$filename = "";

$videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["name"] != '') {
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5242880) { //5 MB limit
        $message = "Sorry, max file size is 5 MB.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($videoFileType != "mp4" && $videoFileType != "mpeg" && $videoFileType != "3gp") {
        $message = "Sorry, only MP4, MPEG & MPG files are allowed.";
        $uploadOk = 0;
    }
    //Check type of uploaded file to make sure its a video
    if(!preg_match('/video\/*/',$_FILES['fileToUpload']['type'])){
        $message = "Sorry, only video files are allowed.";
        $uploadOk = 0;    
    }
    // Check if $uploadOk is set to 0 by an error

    if ($uploadOk == 0) {
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $message = "File Uploaded Successfully.";
            $filename = basename( $_FILES["fileToUpload"]["name"]);
        } else {
            $message = "Sorry, there was an error uploading your file";
        }
    }
}else{
    $uploadOk = 0;
    $message = "Nothing to upload";
}

$returnArray = array("message"=>$message, "status"=>$uploadOk, "fileName" => $filename);
echo json_encode($returnArray);