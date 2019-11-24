<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once('getid3/getid3.php');

class Video{
    var $getID3;
    
    function __construct() {
        // Initialize getID3 engine
        $this->getID3 = new getID3;
    }
    
    function getSize($video){
        
        $ThisFileInfo = $this->getID3->analyze($video);
        return $ThisFileInfo['filesize'];
    }
    
    function getDuration($video){ 
        $ThisFileInfo = $this->getID3->analyze($video);
        return $ThisFileInfo['playtime_seconds'];
    }
    
    function mergeVideosHorizontally($video1,$video2){
        $name1 = $this->rand_string(5).".mp4";
        $AspectRatio1 = "ffmpeg -i $video1 -vf \"scale=680:340:force_original_aspect_ratio=decrease,pad=680:340:(ow-iw)/2:(oh-ih)/2\" ../uploads/$name1";
        shell_exec($AspectRatio1);
        $name2 = $this->rand_string(5).".mp4";
        $AspectRatio2 = "ffmpeg -i $video2 -vf \"scale=680:340:force_original_aspect_ratio=decrease,pad=680:340:(ow-iw)/2:(oh-ih)/2\" ../uploads/$name2";
        shell_exec($AspectRatio2);

        $name = $this->rand_string(5).".mp4";
        $command = "ffmpeg -i ../uploads/$name1 -i ../uploads/$name2 -filter_complex hstack ../uploads/$name";
        shell_exec($command);
        return $name; 
    }
    function mergeVideosVertically($video1,$video2){ 
        $name1 = $this->rand_string(5).".mp4";
        $AspectRatio1 = "ffmpeg -i $video1 -vf \"scale=680:340:force_original_aspect_ratio=decrease,pad=680:340:(ow-iw)/2:(oh-ih)/2\" ../uploads/$name1";
        shell_exec($AspectRatio1);
        $name2 = $this->rand_string(5).".mp4";
        $AspectRatio2 = "ffmpeg -i $video2 -vf \"scale=680:340:force_original_aspect_ratio=decrease,pad=680:340:(ow-iw)/2:(oh-ih)/2\" ../uploads/$name2";
        shell_exec($AspectRatio2);

        $name = $this->rand_string(5).".mp4";
        $command = "ffmpeg -i ../uploads/$name1 -i ../uploads/$name2 -filter_complex vstack ../uploads/$name";
        shell_exec($command);
        return $name; 
    }
    function separateSoundLayer($video){
        $name = $this->rand_string(5).".mp3";
        $command = "ffmpeg -i $video ../uploads/$name";
        shell_exec($command);
        $returnArray = array("video"=>$video, "audio"=>$name);
        return $returnArray; 
    }
    
    function rand_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
}