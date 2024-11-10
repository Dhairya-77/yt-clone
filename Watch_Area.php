<?php
    require_once "db_code.php";

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $db_obj = new DB();
    $v_data=$db_obj->getVideoInWatchArea($_REQUEST['vid']);
    $comments_data= $db_obj->getComments($_REQUEST['vid']);

    $comment= '';
    $save_btn_img= $db_obj->isVideoSavedByUser($_REQUEST['vid'],$_SESSION['uid']) ? 'req_img//saved.png' : 'req_img//bookmark_icon.png';
    $save_btn_text= $db_obj->isVideoSavedByUser($_REQUEST['vid'],$_SESSION['uid']) ? 'Saved' : 'Save';

    $subscribe_btn_text= $db_obj->isUserSubscribed($_REQUEST['vid'],$_SESSION['uid']) ? 'Subscribed' : 'Subscribe';
    $sub_count= $db_obj->subCount($_REQUEST['vid']);

    //code for add vdeio info in recent watched
    if (!isset($_SESSION['watch_start_time'])) {
        $_SESSION['watch_start_time'] = time();
    }
    $timeSpent = time() - $_SESSION['watch_start_time'];

    if ($timeSpent >= 5) {
        $db_obj->insertVideoInRecent($_REQUEST['vid'],$_SESSION['uid']);
    }

    //upload comment
    if(isset($_POST['add_comment_btn'])){

        $comment=isset($_POST['comment']) ? $_POST['comment'] : '';

        if(isset($_POST['comment'])){
            $db_obj->insertComment($_REQUEST['vid'],$_SESSION['un'],$_POST['comment']);
            header('location: Dashboard.php?page=Watch_Area&vid= '. $v_data['v_id']);
            exit;
        }

    }

    //code for save video
    if(!$db_obj->isVideoSavedByUser($_REQUEST['vid'],$_SESSION['uid'])){

        if(isset($_POST['save_btn'])){
            $db_obj->insertVideoInSave($_REQUEST['vid'],$_SESSION['uid']);
            $save_btn_img='req_img//saved.png';
            $save_btn_text='Saved';
        }
    }

    //code for subscribe and subscriber counters
    if(!$db_obj->isUserSubscribed($_REQUEST['vid'],$_SESSION['uid'])){

        if(isset($_POST['subscribe_btn'])){
            $db_obj->insertUserInSubscribers($_REQUEST['vid'],$_SESSION['uid']);
            $subscribe_btn_text= 'Subscribed' ;
            $db_obj->incSubCount($_REQUEST['vid']);
            $sub_count= $db_obj->subCount($_REQUEST['vid']);
        }
    }

?>

<main class="flex-1 p-6">

    <h2 class="text-3xl font-bold mb-6">Watch Area</h2>

    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Video Section (Left Side) -->
        <div class="flex-1 bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4">
            <video controls class="w-full h-64 md:h-96 rounded-lg">
                <source src="<?php echo $v_data['v_path'];?>" type="video/mp4">
            </video>
            
            <!-- Video Details -->
            <div class="mt-4">
                <h3 class="text-2xl font-bold mb-2"><?php echo $v_data['v_title'];?></h3>
                
            <form method="post">
                <!-- Actions Section -->
                <div class="flex items-center gap-4">
                    <!-- Like Button -->
                    <button type="submit" name="like_btn" class="flex items-center">
                        <img src="req_img/not_like.png" alt="Like" class="w-6 h-6 mr-1"> 
                        <span id="likeCount">10</span>
                    </button>

                     <!-- Dislike Button -->
                    <button type="submit" name="dislike_btn" class="flex items-center">
                        <img src="req_img/not_dislike.png" alt="Dislike" class="w-6 h-6 mr-1"> 
                        <span id="dislikeCount">3</span>
                    </button>

                    <!-- Share Button -->
                    <button type="button" id="shareBtn" class="flex items-center" onclick="copyURL()">
                        <img src="req_img/share.png" alt="Share" class="w-6 h-6 mr-1"> Share
                    </button>

                    <!-- Save Button -->
                    <button type="submit" name="save_btn" class="flex items-center">
                        <img src="<?php echo $save_btn_img;?>" alt="Save" class="w-6 h-6 mr-1">
                        <span><?php echo $save_btn_text;?></span>
                    </button>

                    <!-- Subscribe Button -->
                    <button type="submit" name="subscribe_btn" class="bg-purple-600 px-4 py-1 rounded-md transition-colors duration-300 hover:border-yellow-500 border-2 border-transparent">
                    <?php echo $subscribe_btn_text;?>
                    </button>
                    <span name="sub_count"> <?php echo $sub_count;?> subscribers</span>
                </div>
            </form>
            </div>
        </div>

        <!-- Comments Section (Right Side) -->
        <div class="w-full md:w-1/3 bg-purple-800 rounded-lg shadow-lg p-4">
            <h3 class="text-xl font-bold mb-4">Comments</h3>
            
            <!-- Comment Input Box -->
            <form method="post" class="flex items-center mb-4">
                <input type="text" name="comment" value="<?php echo $comment;?>" placeholder="Add a comment..." class="w-full p-2 bg-purple-700 text-yellow-400 rounded-md border-2 border-yellow-500 focus:outline-none focus:border-yellow-300">
                <button type="submit" name="add_comment_btn" class="ml-2 bg-purple-600 px-4 py-1 rounded-md transition-colors duration-300 hover:border-yellow-500 border-2 border-transparent">
                    Post
                </button>
            </form>

            <!-- List of Comments -->
            <div class="space-y-4">
                <?php
                    // Sample comments data
                    /*$comments = [
                    ["username" => "User1", "comment" => "Great video, very informative!"],
                    ["username" => "User2", "comment" => "Thanks for sharing!"],
                    // Add more comments as needed
                    ];*/

                    // Loop through each comment and generate HTML
                    if (empty($comments_data)) {
                        echo 'No Comments Added :(';
                    } else {
                        foreach ($comments_data as $comment) {
                            // Ensure $comment is an array with one key-value pair
                            if (is_array($comment) && count($comment) === 1) {
                                foreach ($comment as $username => $userComment) {
                                    // Ensure both $username and $userComment are strings
                                    if (is_string($username) && is_string($userComment)) {
                                        echo '
                                        <div class="p-3 bg-purple-700 rounded-md">
                                            <p class="font-bold">' . htmlspecialchars($username) . '</p>
                                            <p>' . htmlspecialchars($userComment) . '</p>
                                        </div>';
                                    }
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</main>

<script>
    // Like button functionality
    let liked = false;
    let likeCount = 10;
    
    document.getElementById('likeBtn').addEventListener('click', function() {
        liked = !liked;
        likeCount = liked ? likeCount + 1 : likeCount - 1;
        document.getElementById('likeCount').innerText = likeCount;
        document.getElementById('likeBtn').querySelector('img').src = liked ? 'req_img/like.png' : 'req_img/not_like.png';
        
        if (disliked) {
            disliked = false;
            dislikeCount -= 1;
            document.getElementById('dislikeCount').innerText = dislikeCount;
            document.getElementById('dislikeBtn').querySelector('img').src = 'req_img/not_dislike.png';
        }
    });

    // Dislike button functionality
    let disliked = false;
    let dislikeCount = 3;
    
    document.getElementById('dislikeBtn').addEventListener('click', function() {
        disliked = !disliked;
        dislikeCount = disliked ? dislikeCount + 1 : dislikeCount - 1;
        document.getElementById('dislikeCount').innerText = dislikeCount;
        document.getElementById('dislikeBtn').querySelector('img').src = disliked ? 'req_img/dislike.png' : 'req_img/not_dislike.png';

        if (liked) {
            liked = false;
            likeCount -= 1;
            document.getElementById('likeCount').innerText = likeCount;
            document.getElementById('likeBtn').querySelector('img').src = 'req_img/not_like.png';
        }
    });

    // Save button functionality
    /*let saved = false;

    document.getElementById('saveBtn').addEventListener('click', function() {
        saved = !saved;
        document.getElementById('saveBtn').querySelector('img').src = saved ? 'req_img/saved.png' : 'req_img/bookmark_icon.png';
        document.getElementById('saveBtn').querySelector('span').innerText = saved ? 'Saved' : 'Save';
    });*/

    // Subscribe button functionality
    /*let subscribed = false;
    let subscriberCount = 123000;
    
    document.getElementById('subscribeBtn').addEventListener('click', function() {
        subscribed = !subscribed;
        subscriberCount += subscribed ? 1 : -1;
        document.getElementById('subscribeBtn').classList.toggle('bg-purple-700', subscribed);
        document.getElementById('subscribeBtn').classList.toggle('bg-purple-600', !subscribed);
        document.getElementById('subscribeBtn').innerText = subscribed ? 'Subscribed' : 'Subscribe';
        document.getElementById('subscriberCount').innerText = subscriberCount.toLocaleString() + " subscribers";
    });*/

    // Copy URL functionality for the Share button
    function copyURL() {
        const videoURL = window.location.href;
        navigator.clipboard.writeText(videoURL).then(() => {
            alert("Video URL copied to clipboard!");
        }).catch(() => {
            alert("Failed to copy URL. Please try again.");
        });
    }
</script>