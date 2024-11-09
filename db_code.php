<?php
    class DB{
        private $con;

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

        public function uploadVideo($vpath,$vtitle,$uid){
            $q="insert into videos (v_path,v_title,uid) values(:a,:b,:c)";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vpath);
            $stmt->bindParam(":b",$vtitle);
            $stmt->bindParam(":c",$uid);
            $stmt->execute();
        }

        public function getVideoInHome(){
            $q="select v_path,v_title from videos";
            $stmt=$this->con->prepare($q);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getVideoInWatchArea($vid){
            $q="select * from videos where v_id=:a";
            $stmt=$this->con->prepare($q);
            $stmt->bindParam(":a",$vid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function userRecordInsert($UFullName,$UserName,$UEmail,$UPassword)
        {
            $qry='Insert Into User_Information(UFullname,UserName,UEmail,UPassword) values(:a,:b,:c,:d)';
            $stmt=$this->con->prepare($qry);
           
            $stmt->bindParam(':a',$UFullName);
            $stmt->bindParam(':b',$UserName);
            $stmt->bindParam(':c',$UEmail);
            $stmt->bindParam(':d',$UPassword);
            
            $stmt->execute();
        }


        function userPasswordUpdate($UPassword,$UserName) // Forgot Password
        {
            $qry="update  User_Information set UPassword=:a where UserName=:b";
            $stmt=$this->con->prepare($qry);
            $stmt->bindparam(':a',$UPassword);
            $stmt->bindparam(':b',$UserName);
            $stmt->execute();
            echo "<script>alert('Password Change Succesfully');</script>";
        }


        function userlogin($username,$UPassword) // user login
        {
            $qry="select UserName,UPassword from User_Information where UserName=:a";
            $stmt=$this->con->prepare($qry);
            $stmt->bindparam(':a',$username);

            $stmt->execute();

            $password=$stmt->fetch(PDO::FETCH_ASSOC);

            if($password)
            {
                if($UPassword == $password['UPassword'])
                {
                    echo "<script>alert('Login Succesfully');</script>";
                    header('Location:Dashboard.php');
                }
                else{
                    echo "<script>alert('Invalid Password');</script>";
                }
            }else{
                echo "<script>alert('User Not Found');</script>";
            }
            

        }
    }
?>