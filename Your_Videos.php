<?php
    require_once "db_code.php";

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $db_obj = new DB();
    

    if(isset($_POST['del_btn'])){
        $db_obj->delYourVideo($_POST['video_id']);
        header('location: Dashboard.php?page=Your_Videos');
        exit;
    }

    $your_videos_data=$db_obj->getYourVideos($_SESSION['uid']);
?>

<main class="flex-1 p-6">
<h2 class="text-3xl font-bold mb-6">Your Videoes</h2>

<!-- Your Video List Container -->
<div class="space-y-4">
    <?php
        // Video data array with video source, title, and link
        /*$videos = [
            ["src" => "req_video/video1.mp4", "title" => "Saved Video 1", "link" => "video1.php"],
            ["src" => "req_video/video2.mp4", "title" => "Saved Video 2", "link" => "video2.php"],
            ["src" => "req_video/video3.mp4", "title" => "Saved Video 3", "link" => "video3.php"],
            ["src" => "req_video/video4.mp4", "title" => "Saved Video 4", "link" => "video4.php"],
            // Add more saved videos as needed
        ];*/

        // Loop through each video and generate HTML
        if(empty($your_videos_data)){
            echo 'Not Uploaded Any Video :( <br>';
        }
        else{
            foreach ($your_videos_data as $video) {
                echo '
                <div class="flex items-center bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4 space-x-4 hover:bg-purple-700 transition-colors duration-300">
                    <!-- Video Element -->
                    <video controls class="w-48 h-28 object-cover rounded-lg">
                            <source src="' . $video['v_path'] . '" type="video/mp4">
                    </video>
                        
                    <!-- Video Info -->
                    <div class="flex-1 flex items-center justify-between">
                        <a href="' . "Dashboard.php?page=Watch_Area&vid=" . $video['v_id'] . '" class="text-lg font-bold hover:underline">' . $video['v_title'] . '</a>
                            
                        <!-- Remove Button -->
                        <form method="POST">
                            <input type="hidden" name="video_id" value="' . $video['v_id'] . '">
                            <button type="submit" name="del_btn" class="hover:text-red-500 font-bold">Delete</button>
                        </form>
                    </div>
                </div>';
            }
        }
    ?>
</div>
</main>