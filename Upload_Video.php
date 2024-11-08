<?php 
    //include db file file
    require_once "db_code.php";

    /*session_start();

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
    }*/

    $db_obj = new DB();

    $v_file_err='';
    $v_title_err='';
    $v_title='';

    if(isset($_POST['upload_btn'])){

        //error messages and storing file title value
        $v_title=isset($_POST['video_title'])? $_POST['video_title'] : ' ';

        if(empty($_FILES['video_file']['name']) || empty($_POST['video_title'])){
            
            if(empty($_FILES['video_file']['name'])){
                $v_file_err='Upload File';
            }

            if(empty($_POST['video_title'])){
                $v_title_err='Enter Video Title';
            }
        }
        else{

            //file upload
            $dir="videos/";
            $extenstion=pathinfo($_FILES['video_file']['name'],PATHINFO_EXTENSION);

            //new file name
            $new_file_name="video_" .  $_REQUEST['uid']/*$_SESSION['uid']*/ . "_" . date("Ymd_His") . "." . $extenstion;
            $save_path=$dir . $new_file_name;

            if(move_uploaded_file($_FILES['video_file']['tmp_name'],$save_path)){
                $db_obj->uploadVideo($save_path,$_POST['video_title'],$_REQUEST['uid']);
                header('location:Dashboard.php?page=home');
                exit();
            }
            else{
                echo 'error in uploading file :(';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Upload Video</h2>

        <form method="post" enctype="multipart/form-data">
            <!-- Video Player -->
            <div class="mb-6">
                <video id="video_player" controls class="w-full h-48 bg-black rounded-md">
                    <source src="" type="video/mp4"> <!-- Placeholder for video source -->
                </video>
            </div>

            <!-- Select File -->
            <div class="mb-4">
                <input type="file" id="video_file" name="video_file" accept="video/*" class="w-full bg-purple-700 text-yellow-400 rounded-md border-2 border-yellow-500 focus:outline-none focus:border-yellow-300" onchange="loadVideo(event)">
                <label for="video_file" class="block text-red-500 mb-2"><?php echo $v_file_err;?></label>
            </div>

            <!-- Video Title -->
            <div class="mb-6">
                <label for="video_title" class="block text-yellow-400">Video Title</label>
                <input type="text" id="video_title" name="video_title" value="<?php echo $v_title;?>" placeholder="Enter Video Title" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="video_title" class="block text-red-500 mb-2"><?php echo $v_title_err;?></label>
            </div>

            <!-- Upload Button -->
            <button type="submit" name="upload_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">
                Upload Video
            </button>
        </form>

    </div>

    <script>
        // Load the selected video file into the video player
        function loadVideo(event) {
            const videoFile = event.target.files[0];
            const videoPlayer = document.getElementById("video_player");

            if (videoFile) {
                const videoURL = URL.createObjectURL(videoFile);
                videoPlayer.src = videoURL;
                videoPlayer.play();  // Optional: Auto-play the selected video
            }
        }
    </script>
</body>
</html>