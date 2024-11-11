<?php
    class DB{
        private $con;

        //for db connection 
        public function __construct(){
            $dsn="mysql:host=localhost;dbname=casestudy";
            $un="root";
            $pw="";
            try{
                $this->con=new PDO($dsn,$un,$pw);
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        //for get user id 
        public function getUid($un,$pw){
            $q="select uid from users where username=:a and password=:b";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$un);
            $stmt->bindParam(":b",$pw);
            $stmt->execute();
            $uid_arr=$stmt->fetch(PDO::FETCH_ASSOC);
            return $uid_arr['uid'];
        }

        //for uploading the video
        public function uploadVideo($vpath,$vtitle,$uid){
            $q="insert into videos (v_path,v_title,uid) values(:a,:b,:c)";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vpath);
            $stmt->bindParam(":b",$vtitle);
            $stmt->bindParam(":c",$uid);
            $stmt->execute();
        }

        //for home
        public function getVideoInHome(){
            $q="select v_id,v_path,v_title from videos order by v_date desc limit 9";
            $stmt=$this->con->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //for watch area
        public function getVideoInWatchArea($vid){
            $q="select * from videos where v_id=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vid);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        //for profile image in dashboard
        public function getProfileImg($uid){
            $q="select img_path from users where uid=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$uid);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        //for your videos
        public function getYourVideos($uid){
            $q="select v_id,v_path,v_title from videos where uid=:a ORDER BY v_date DESC";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$uid);
            $stmt->execute();
            return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
        }       
        
        //for delete your video 
        public function delYourVideo($vid){
            $q="delete from videos where v_id=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vid);
            $stmt->execute();
        } 

        //for search results 
        public function searchVideo($searched_str){
             // Base SQL query to select all videos
            $q = "select videos.v_id,videos.v_path,videos.v_title,users.username,users.img_path from videos join users on videos.uid=users.uid";

            // If there's a search term, modify the SQL query to filter results
            if ($searched_str!==null) {
                $q .= " where v_title like :a";
                $stmt = $this->con->prepare($q); // Prepare the statements
                $search_term = "%" . $searched_str. "%"; // Create wildcard search term
                $stmt->bindParam(":a", $search_term);// Bind parameters
            } 
            else {
                // If no search term, order results by upload date descending
                $stmt = $this->con->prepare($q . " ORDER BY v_date DESC limit 10");
            }

            // Execute the prepared statement
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //for login
        function userLogin($un,$pw) // user login
        {
            $q="select count(*) from users where username=:a and password=:b";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$un);
            $stmt->bindparam(':b',$pw);
            $stmt->execute();

            $is_exist = $stmt->fetchColumn();

            if($is_exist == 1){
                return true;
            }
            else{
                return false;
            }
        }

        //for sign up
        function insertUser($fn,$un,$email,$pw)
        {
            $q='Insert Into users (name,username,email,password) values (:a,:b,:c,:d)';
            $stmt= $this->con->prepare($q);
           
            $stmt->bindParam(':a',$fn);
            $stmt->bindParam(':b',$un);
            $stmt->bindParam(':c',$email);
            $stmt->bindParam(':d',$pw);
            
            $stmt->execute();
        }
        //checking user is unique or not
        public function isUserPresent($un,$id=null){
            $q='select * from users where username=:a';
            if($id!==null){
                $q=$q. ' and uid != :b';
            }
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(':a',$un);

            if($id!==null){
               $stmt->bindParam(':b',$id);
            }
            $stmt->execute();

            return $stmt->rowCount()>0;
        }

        //for forgot passwords
        function updatePassword($un,$pw) 
        {
            $q="update users set password=:a where username=:b";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$pw);
            $stmt->bindparam(':b',$un);
            $stmt->execute();
        }

        //for get profile info
        function getProfileInfo($uid) 
        {
            $q="select name,username,email,img_path from users where uid=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$uid);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        //for profile update
        function updateProfile($fn,$un,$email,$img,$uid) 
        {
            $q="update users set name=:a,username=:b,email=:c,img_path=:d where uid=:e";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$fn);
            $stmt->bindparam(':b',$un);
            $stmt->bindparam(':c',$email);
            $stmt->bindparam(':d',$img);
            $stmt->bindparam(':e',$uid);

            $stmt->execute();
        }

        //for store comment
        function insertComment($vid,$un,$usercomment)
        {
            // Step 1: Retrieve the existing comments
            $q = 'select v_comments from videos where v_id = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a', $vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Decode the existing JSON comments or initialize as an empty array if null
            $comments = $result['v_comments'] ? json_decode($result['v_comments'], true) : [];

            // Step 2: Add the new comment as an associative array with the username as the key
            $comments[] = [$un => $usercomment];

            // Step 3: Update the comments in the database
            $q = 'update videos set v_comments = :a where v_id = :b';
            $stmt = $this->con->prepare($q);
            $updated_comments = json_encode($comments); // Convert array back to JSON
            $stmt->bindParam(':a', $updated_comments);
            $stmt->bindParam(':b', $vid);
            $stmt->execute();
        }
        //for get comment data
        function getComments($vid) 
        {
            $q="select v_comments from videos where v_id=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['v_comments'] ? json_decode($result['v_comments'], true) : [];
        }

        //for store recent watched video
        function insertVideoInRecent($vid,$uid)
        {
            $q='Insert Into recent_watched (v_id,watched_by) values (:a,:b)';
            $stmt= $this->con->prepare($q);
           
            $stmt->bindParam(':a',$vid);
            $stmt->bindParam(':b',$uid);
            
            if($stmt->execute()){
                unset($_SESSION['watch_start_time']);
            }

        }

        //for get recent watched data
        function getRecentWatchedData($uid) 
        {
            $q="select videos.v_id,videos.v_path, videos.v_title,users.username,users.img_path from recent_watched join videos on recent_watched.v_id=videos.v_id join users on videos.uid=users.uid where recent_watched.watched_by=:a order by recent_watched.watched_date desc";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //for check wheter is user saved video or not
        function isVideoSavedByUser($vid,$uid){
            $q='select * from saved_videos where v_id=:a and saved_by=:b';
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(':a',$vid);
            $stmt->bindParam(':b',$uid);
            $stmt->execute();

            return $stmt->rowCount()>0;
        }
        //for store save video
        function insertVideoInSave($vid,$uid)
        {
            $q='Insert Into saved_videos (v_id,saved_by) values (:a,:b)';
            $stmt= $this->con->prepare($q);
           
            $stmt->bindParam(':a',$vid);
            $stmt->bindParam(':b',$uid);
            $stmt->execute();
        }
        //for get saved video data
        function getSavedvideosData($uid) 
        {
            $q="select videos.v_id,videos.v_path, videos.v_title from saved_videos join videos on saved_videos.v_id=videos.v_id where saved_videos.saved_by=:a order by saved_videos.saved_date desc";
            $stmt=$this->con->prepare($q);
            $stmt->bindparam(':a',$uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //for delete remove saved video 
        public function delSavedVideo($vid,$uid){
            $q="delete from saved_videos where v_id=:a and saved_by=:b";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vid);
            $stmt->bindParam(":b",$uid);
            $stmt->execute();
        } 
        
        //for checking user is subscriber or not
        function isUserSubscribed($vid,$subscriber_uid){
            $uid = $this->getUidFromVid($vid);
            $q = 'SELECT subscribers FROM subscribers WHERE uid = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a', $uid);
            $stmt->execute();

            //Check if the `subscribers` column contains the user's ID in JSON format
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $subscribers = $result['subscribers'] ? json_decode($result['subscribers'], true) : [];

                //Verify if `subscriber_uid` exists in the subscribers array
                return in_array($subscriber_uid, $subscribers);
            }
            // Return false if no subscription data exists for the given `uid`
            return false;
        }

        //for get uid from vid
        function getUidFromVid($vid){
            $q="select uid from videos where v_id=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vid);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['uid'];
        }

        //for get subscriber count
        function subCount($vid){
            $q='select subscribers from users where uid=:a';
            $stmt=$this->con->prepare($q);

            $uid=$this->getUidFromVid($vid);

            $stmt->bindParam(':a',$uid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['subscribers'];
        }

        //update increment subscriber count
        function incSubCount($vid){
            $q='update users set subscribers=subscribers+1 where uid=:a';
            $stmt=$this->con->prepare($q);

            $uid=$this->getUidFromVid($vid);
            $stmt->bindParam(':a',$uid);
            $stmt->execute();
        }
        //for store subscribed channel
        function insertUserInSubscribers($vid,$subscriber_uid)
        {
            $uid=$this->getUidFromVid($vid);
            // Step 1: Retrieve the current subscribers for the user
            $q = 'SELECT subscribers FROM subscribers WHERE uid = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a', $uid);
            $stmt->execute();

            if ($stmt->rowCount() > 0) 
            {
                // Step 2: Get current subscribers JSON data
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $subscribers = $result['subscribers'] ? json_decode($result['subscribers'], true) : [];

                // Step 3: Add new subscriber if not already in the list
                if (!in_array($subscriber_uid, $subscribers)) {
                    $subscribers[] = $subscriber_uid; // Add the new subscriber ID
                    $updated_subscribers = json_encode($subscribers); // Convert back to JSON

                    // Step 4: Update the subscribers column with the new array
                    $update_query = 'UPDATE subscribers SET subscribers = :b WHERE uid = :a';
                    $update_stmt = $this->con->prepare($update_query);
                    $update_stmt->bindParam(':a', $uid);
                    $update_stmt->bindParam(':b', $updated_subscribers);
                    $update_stmt->execute();
                }
            } 
            else
            {
                // If no entry exists for this user, insert a new row with the subscriber
                $new_subscribers = json_encode([$subscriber_uid]); // Create a new JSON array
                $insert_query = 'INSERT INTO subscribers (uid, subscribers) VALUES (:a, :b)';
                $insert_stmt = $this->con->prepare($insert_query);
                $insert_stmt->bindParam(':a', $uid);
                $insert_stmt->bindParam(':b', $new_subscribers);
                $insert_stmt->execute();
            }
        }

        //for get subscribed channels data
        function getSubscribedChannelssData($uid) 
        {
            $q = 'SELECT u.uid,u.username, u.img_path FROM subscribers s JOIN users u ON s.uid = u.uid WHERE JSON_CONTAINS(s.subscribers, :a)';
            $stmt = $this->con->prepare($q);
            $currentUser = json_encode($uid);
            $stmt->bindParam(':a', $currentUser);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }

        //update decrement subscriber count
        function dcrSubCount($channel_uid){
            $q='update users set subscribers=subscribers - 1  where uid=:a';
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(':a',$channel_uid);
            $stmt->execute();
        }

        //for delete remove saved video 
        public function unsunscribe($channel_uid,$cuurent_uid)
        {
            //etrieve current subscribers list for the given channel
            $q = 'SELECT subscribers FROM subscribers WHERE uid = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a', $channel_uid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //Check if any subscribers exist for this channel
            if ($result && !empty($result['subscribers'])) {
                //Decode the JSON array of subscribers
                $subscribers = json_decode($result['subscribers'], true);

                //Remove the current user's UID if it exists
                if (($key = array_search($cuurent_uid, $subscribers)) !== false) {
                    unset($subscribers[$key]);

                    // Re-index the array to maintain JSON structure
                    $subscribers = array_values($subscribers);

                    // Step 4: Update the database with the modified JSON array
                    $updatedSubscribers = json_encode($subscribers);
                    $updateQuery = 'UPDATE subscribers SET subscribers = :a WHERE uid = :b';
                    $updateStmt = $this->con->prepare($updateQuery);
                    $updateStmt->bindParam(':a', $updatedSubscribers);
                    $updateStmt->bindParam(':b', $channel_uid);
                    $updateStmt->execute();
                }
            }
        } 

        //for decrement or increment like counter
        private function updateLikeCounter($vid, $increment) {
            $q = "UPDATE videos SET v_like = GREATEST(v_like + :a, 0) WHERE v_id = :b";
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(":a", $increment);
            $stmt->bindParam(":b", $vid);
            $stmt->execute();
        }

        //for decrement or increment dislike counter
        private function updateDislikeCounter($vid, $increment) {
            $q = "UPDATE videos SET v_dislike = GREATEST(v_dislike + :a, 0) WHERE v_id = :b";
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(":a", $increment);
            $stmt->bindParam(":b", $vid);
            $stmt->execute();
        }

        //insert like and remove dislike
        public function insertLike($vid, $uid) {
            $this->initializeLikeDislikeEntry($vid);
        
            // Step 1: Retrieve current liked_by and disliked_by lists
            $q = 'SELECT liked_by, disliked_by FROM like_dislike WHERE v_id = :vid';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':vid', $vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $likedBy = $result['liked_by'] ? json_decode($result['liked_by'], true) : [];
            $dislikedBy = $result['disliked_by'] ? json_decode($result['disliked_by'], true) : [];
        
            // Step 2: Update lists and counters if necessary
            if (!in_array($uid, $likedBy)) {
                $likedBy[] = $uid;
                $dislikedBy = array_diff($dislikedBy, [$uid]); // Remove user from disliked_by if present
        
                // Step 3: Update database with new lists
                $q = "UPDATE like_dislike SET liked_by = :liked, disliked_by = :disliked WHERE v_id = :vid";
                $stmt = $this->con->prepare($q);
                $stmt->bindValue(':liked', json_encode(array_values($likedBy)));
                $stmt->bindValue(':disliked', json_encode(array_values($dislikedBy)));
                $stmt->bindParam(':vid', $vid);
                $stmt->execute();
        
                // Update counters in videos table
                $this->updateLikeCounter($vid, +1);
                $this->updateDislikeCounter($vid, -1);
            }
        }        

        //insert dislike and remove like
        public function insertDislike($vid, $uid) {
            $this->initializeLikeDislikeEntry($vid);
        
            // Step 1: Retrieve current liked_by and disliked_by lists
            $q = 'SELECT liked_by, disliked_by FROM like_dislike WHERE v_id = :vid';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':vid', $vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $likedBy = $result['liked_by'] ? json_decode($result['liked_by'], true) : [];
            $dislikedBy = $result['disliked_by'] ? json_decode($result['disliked_by'], true) : [];
        
            // Step 2: Update lists and counters if necessary
            if (!in_array($uid, $dislikedBy)) {
                $dislikedBy[] = $uid;
                $likedBy = array_diff($likedBy, [$uid]); // Remove user from liked_by if present
        
                // Step 3: Update database with new lists
                $q = "UPDATE like_dislike SET liked_by = :liked, disliked_by = :disliked WHERE v_id = :vid";
                $stmt = $this->con->prepare($q);
                $stmt->bindValue(':liked', json_encode(array_values($likedBy)));
                $stmt->bindValue(':disliked', json_encode(array_values($dislikedBy)));
                $stmt->bindParam(':vid', $vid);
                $stmt->execute();
        
                // Update counters in videos table
                $this->updateLikeCounter($vid, -1);
                $this->updateDislikeCounter($vid, +1);
            }
        }

        // Initialize entry in like_dislike if it doesn't exist
        private function initializeLikeDislikeEntry($vid) {
            $q = "INSERT INTO like_dislike (v_id, liked_by, disliked_by) 
                  SELECT :vid, '[]', '[]' 
                  WHERE NOT EXISTS (SELECT 1 FROM like_dislike WHERE v_id = :vid)";
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(":vid", $vid);
            $stmt->execute();
        }

        //get like count
        public function likeCounter($vid) {
            $q = 'select v_like from videos where v_id = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a',$vid);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    
        //get dislike count
        public function dislikeCounter($vid) {
            $q = 'select v_dislike from videos where v_id = :a';
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(':a',$vid);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
       
        //is liked by current user
        public function isLikedBy($vid, $uid) {
            $q = "SELECT liked_by FROM like_dislike WHERE v_id = :vid";
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(":vid", $vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if the result is valid (not false)
            if ($result) {
                // Check if user ID is in the liked_by list (comma-separated string)
                return (strpos($result['liked_by'], (string)$uid) !== false);
            }
        
            // If no result is found, return false (the video is not liked by the user)
            return false;
        }

        //is disliked by current user
        public function isDislikedBy($vid, $uid) {
            $q = "SELECT disliked_by FROM like_dislike WHERE v_id = :vid";
            $stmt = $this->con->prepare($q);
            $stmt->bindParam(":vid", $vid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if the result is valid (not false)
            if ($result) {
                // Check if user ID is in the disliked_by list (comma-separated string)
                return (strpos($result['disliked_by'], (string)$uid) !== false);
            }
        
            // If no result is found, return false (the video is not disliked by the user)
            return false;
        }
    }
?>