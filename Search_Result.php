<?php
    require_once "db_code.php";

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $db_obj = new DB();
    $str=isset($_POST['search_str']) ? $_POST['search_str']: " ";
    $videos_data=$db_obj->searchVideo($str);
?>

<main class="flex-1 p-6">
    <h2 class="text-3xl font-bold mb-6">Searched Results</h2>

    <!-- Video List Container -->
    <div class="space-y-4">
    <?php
        // Video data array with video source, title, owner name, and profile image
        /*$videos = [
            ["src" => "req_video/video1.mp4", "title" => "Video Title 1", "owner" => "Owner 1", "profile_img" => "req_img/owner1.png", "link" => "video1.php"],
            ["src" => "req_video/video2.mp4", "title" => "Video Title 2", "owner" => "Owner 2", "profile_img" => "req_img/owner2.png", "link" => "video2.php"],
            ["src" => "req_video/video3.mp4", "title" => "Video Title 3", "owner" => "Owner 3", "profile_img" => "req_img/owner3.png", "link" => "video3.php"],
            ["src" => "req_video/video4.mp4", "title" => "Video Title 4", "owner" => "Owner 4", "profile_img" => "req_img/owner4.png", "link" => "video4.php"],
            ["src" => "req_video/video5.mp4", "title" => "Video Title 5", "owner" => "Owner 5", "profile_img" => "req_img/owner5.png", "link" => "video5.php"],
            // Add more videos as needed
        ];*/

        // Loop through each video and generate HTML
        if(empty($videos_data)){
            echo 'No Video Found :( <br>';
            echo 'Please Enter Proper Words For Search';
        }
        else{
            foreach ($videos_data as $v_data) {
                echo '
                <a href="' . "Dashboard.php?page=Watch_Area&vid=" . $v_data['v_id'] . '" class="block">
                    <div class="flex items-center bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4 space-x-6 hover:bg-purple-700 transition-colors duration-300">
                        <!-- Video Element -->
                        <div class="flex-shrink-0">
                            <video controls class="w-64 h-36 object-cover rounded-lg">
                                <source src="' . $v_data['v_path'] . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        
                        <!-- Video Info -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold">' . $v_data['v_title'] . '</h3>
                            <div class="flex items-center space-x-2 mt-10">
                                <img src="' . $v_data['img_path'] . '" alt="' . $v_data['username'] . '" class="w-10 h-10 rounded-full">
                                <span class="text-sm">' . $v_data['username'] . '</span>
                            </div>
                        </div>
                    </div>
                </a>';
            }
        }
    ?>
    </div>
</main>
