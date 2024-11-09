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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $q="select name,username,email,img_path from users uid=:a";
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
            $stmt->bindparam(':a',$pw);
            $stmt->bindparam(':e',$uid);

            $stmt->execute();
        }
    }
?>