# MFMVideos
Get videos size, duration, audio. Also merge them vertically &amp; horizontally.

Pre-Requisites 

For this code to work, you must need the following libraries
Pre Requisites:
PHP preferably > 7.0 version 
PHP libxml
PHP gd lib
PHP mbstring lib
PHP FFMpeg lib installed on your system 
A very detailed description is given in the following link how to install on windows 
https://windowsloop.com/install-ffmpeg-windows-10/
If you are using Linux based operating system, then following link explains the installation process
https://linuxize.com/post/how-to-install-ffmpeg-on-ubuntu-18-04/


Code Structure:

The code structure is quite simple and self-explanatory. I have tried to keep it simple and short, yet effective and efficient to do the job.
There is only 1 main file index.php from which it starts and the rest of the files are divided into respective directories like css, js, lib, process, uploads.


How it works:

Simply download or clone the project on to your server (either local or cloud based) with the above mentioned libraries installed. Run the index.php file. 
It has two major parts. 
In first part, you can upload a single video file, and get its size, duration audio with a single click of Process.
In the second part, you can upload two files at a time, and then after uploading, you will see two options to merge them either horizontally or vertically.

Libraries Used:

I have used the following libraries to do the above tasks:
For processing video files:
getID3 and FFMpeg
For DOM purposes:
jQuery
For styling and responsive designs:
Bootstrap

I have applied the upload limit to 5 MBs for each file for the smooth and quick response of the tasks.






Video Class Functions Explained:
I don’t believe in re-inventing the wheel. Instead I prefer to use the wheel to make something more useful. That’s why I have used external libraries and also took help from different sources available over the internet specially stackoverflow. 
function getSize($video)
function getDuration($video)
These two functions use the id3 library to analyze the video file and return a detailed array of information about the video. I just used size and duration of the video as required.

function mergeVideosHorizontally($video1,$video2)
function mergeVideosVertically($video1,$video2)
These two functions use the FFMpeg library to merge the two videos. Both the two function are almost similar just one his for horizontal merge and other is for vertical merge.
There is another important step in these functions that first I convert the aspect ratios of the two videos in fix size that is 680:340 and mp4 format so that when they are merged they look of same size in the video frame.

function separateSoundLayer($video)
This function also uses FFMpeg library to just convert the video file into an audio mp3 file and return the audio and video files both.
