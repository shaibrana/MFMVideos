<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<!DOCTYPE html>
<html>
    <head>
        <title>MFM Video Tasks</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container mt-3">
            <h3>Get Video Size, Duration & Separate Audio from Video</h3>
            <form id="form" action="upload.php" method="POST" enctype="multipart/form-data">
                <p>You can get video size, duration and also separate audio from video using the same file:</p>
                <div class="message">
                    <div id="err" class="alert alert-danger hidden">
                    </div>
                    <div id="success" class="alert alert-success hidden">
                    </div>
                </div>
                <div class="custom-file mb-3">
                    <input type="hidden" id="uploadedfile" value="">
                    <input type="file" class="custom-file-input" id="customFile" name="fileToUpload">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>

                <div id="submitButton" class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div id="proccess" class="mt-3 hidden">
                <button type="button" class="btn btn-success">Process File</button>
            </div>
            <div id="proccessDetails" class="mt-3 hidden">
                <p>Size of the uploaded video is: <span id="size"></span> MBs</p>
                <p>Duration of the uploaded video is: <span id="duration"></span> secs</p>
                <p>Audio from the video file is: 
                <audio controls>
                    <source src="" type="audio/mpeg">
                </audio>
            </div>
        </div>
        <hr>
        <div class="container mt-3 merge">
            <h3>Merge Videos Horizontally & Vertically</h3>
            <form id="mergeform" action="process/merge.php" method="POST" enctype="multipart/form-data">
                <p>Select two videos to merge them in horizontal and vertical direction:</p>
                <div class="message">
                    <div id="mergeerr" class="alert alert-danger hidden">
                    </div>
                    <div id="mergesuccess" class="alert alert-success hidden">
                    </div>
                </div>
                <div class="custom-file mb-3">
                    <input type="hidden" id="uploadedfile1" value="">
                    <input type="hidden" id="uploadedfile2" value="">
                    <input type="file" class="custom-file-input" name="mergeVideos[]" multiple>
                    <label class="custom-file-label" for="customFile">Choose files</label>
                </div>

                <div id="mergeButton" class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div id="mergeproccess" class="mt-3 hidden">
                <div class="leftSide">
                    <div id="leftLoading" style="display:none;" class="spinner-border text-primary hidden" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="button" id="mergeHorizontally" class="btn btn-success">Merge Videos Horizontally</button>
                </div>
                <div class="rightSide">
                    <div id="rightLoading" style="display:none;" class="spinner-border text-primary hidden" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="button" id="mergeVertically" class="btn btn-success">Merge Videos Vertically</button>
                </div>
            </div>
            <div id="mergeproccessDetails" class="mt-3 ">
                <div class="leftSide">
                    <div class="horizontalMergedVideo hidden">
                        <video controls>
                            <source src="" type="video/mp4" />
                        </video>
                    </div>
                </div>
                <div class="rightSide">
                    <div class="verticalMergedVideo hidden">
                        <video controls>
                            <source src="" type="video/mp4" />
                        </video>
                    </div>
                </div>
            </div>
        </div>    

        <script>
            var filename;
            $(function () {
                initFileUpload();
                initProcessFile();
                initUploadMergeFiles();
                initMergeUploadedFiles();
            });
            function initFileUpload() {
                $("#form").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "process/upload.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function (){
                            $("#err").hide();
                            $("#success").hide();
                            $("#process").hide();
                        },
                        success: function (data){
                            data = JSON.parse(data);
                            console.log(data.message);
                            if (data.status == '0'){
                                $("#err").html(data.message).fadeIn();
                                $("#process").hide();
                            } else{
                                $("#success").html(data.message).fadeIn();
                                $("#form")[0].reset();
                                $("#uploadedfile").val(data.fileName);
                                $("#submitButton").hide();
                                $("#proccess").fadeIn();
                            }
                        },
                        error: function (data){
                            data = JSON.parse(data);
                            $("#process").hide();
                            $("#err").html(data.message).fadeIn();
                        }
                    });
                }));
            }
            function initProcessFile(){
                $("#proccess").on('click', (function (e) {
                    $.ajax({
                        url: "process/process.php",
                        type: "POST",
                        data: {"fileName":$("#uploadedfile").val()},
                        beforeSend: function (){
                            $("#err").hide();
                            $("#success").hide();
                            $("#process").show();
                        },
                        success: function (data){
                            data = JSON.parse(data);
                            $("#proccess").fadeOut();
                            $("#size").html(data.size);
                            $("#duration").html(data.duration);
                            $("#proccessDetails").fadeIn();
                            var audio = $('#proccessDetails audio')[0];
                            audio.src = "uploads/"+data.audio;
                            audio.load();
                        },
                        error: function (data){
                            data = JSON.parse(data);
                            $("#err").html(data.message).fadeIn();
                        }
                    });
                }));
            }
            function initUploadMergeFiles(){
                $("#mergeform").on('submit', (function (e) {
                    e.preventDefault();
                    $("#mergeButton button").text("Uploading");
                    $.ajax({
                        url: "process/mergeupload.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function (){
                            $("#mergeerr").hide();
                            $("#mergesuccess").hide();
                            $("#mergeprocess").show();
                        },
                        success: function (data){
                            data = JSON.parse(data);
                            if (data.status == '0'){
                                $("#mergeerr").html(data.message).fadeIn();
                                $("#mergeproccessDetails").hide();
                                $("#mergeButton button").text("Submit");
                            } else{
                                $("#mergesuccess").html(data.message).fadeIn();
                                $("#mergeButton").fadeOut();
                                $("#mergeproccess").fadeIn();
                                $("#uploadedfile1").val(data.video1);
                                $("#uploadedfile2").val(data.video2);
                            }
                        },
                        error: function (data){
                            data = JSON.parse(data);
                            $("#mergeerr").html(data.message).fadeIn();
                            $("#mergeButton button").text("Submit");
                        }
                    });
                }));
            }
            function initMergeUploadedFiles(){
                $("#mergeproccess button").on('click', (function (e) {
                    e.preventDefault();
                    var type = $(this).attr("id");
                    
                    $.ajax({
                        url: "process/mergeUploaded.php",
                        type: "POST",
                        data: {"type":type,"video1":$("#uploadedfile1").val(),"video2":$("#uploadedfile2").val()},
                        beforeSend: function (){
                            $("#err").hide();
                            $("#mergesuccess").hide();
                            $("#"+type).fadeOut();
                            if (type == 'mergeHorizontally'){
                                $("#leftLoading").show();
                            }else{
                                $("#rightLoading").show();
                            }
                        },
                        success: function (data){
                            data = JSON.parse(data);
                            $("#mergesuccess").html(data.message).fadeIn();
                            if (type == 'mergeHorizontally'){
                                $(".horizontalMergedVideo").show();
                                var video = $('.horizontalMergedVideo video')[0];
                                video.src = "uploads/"+data.mergedVideo;
                                video.load();
                                $("#leftLoading").hide();
                                //video.play();
                            }else{
                                $(".verticalMergedVideo").show();
                                var video = $('.verticalMergedVideo video')[0];
                                video.src = "uploads/"+data.mergedVideo;
                                video.load();
                                $("#rightLoading").hide();
                                //video.play();
                            }
                        },
                        error: function (data){
                            data = JSON.parse(data);
                            $("#err").html(data.message).fadeIn();
                        }
                    });
                }));
            }
        </script>
    </body>
</html>