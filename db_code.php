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
    }
?>