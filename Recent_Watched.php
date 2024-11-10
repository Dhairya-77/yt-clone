<?php
    require_once "db_code.php";

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $db_obj = new DB();
    $result= $db_obj->getRecentWatchedData($_SESSION['uid']);
?>

<main class="flex-1 p-6">

    <h2 class="text-3xl font-bold mb-6">Recent Watched</h2>

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
                if(empty($result)){
                    echo 'Not Watched Any Video :(';
                }
                else{
                    foreach ($result as $data) {
                        echo '
                        <a href="' . "Dashboard.php?page=Watch_Area&vid=" . $data['v_id'] . '" class="block">
                            <div class="flex items-center bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4 space-x-4 hover:bg-purple-700 transition-colors duration-300">
                                <!-- Video Element -->
                                <div class="flex-shrink-0">
                                    <video controls class="w-48 h-28 object-cover rounded-lg">
                                        <source src="' . $data['v_path'] . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                
                                <!-- Video Info -->
                                <div class="flex-1 flex items-center justify-between">
                                    <h3 class="text-lg font-bold">' . $data['v_title'] . '</h3>
                                    <div class="flex items-center space-x-2">
                                        <img src="' . $data['img_path'] . '" alt="' . $data['username']  . '" class="w-8 h-8 rounded-full">
                                        <span>' . $data['username'] . '</span>
                                    </div>
                                </div>
                            </div>
                        </a>';
                    }
                }
            ?>
    </div>
</main>