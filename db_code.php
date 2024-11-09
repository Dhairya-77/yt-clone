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
    }
?>