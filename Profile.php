<?php
    require_once "db_code.php";

    session_start();

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $db_obj= new DB();
    $profile_info=$db_obj->getProfileInfo($_SESSION['uid']);

    $dir='profile_img/';

    $fullname=$profile_info['name'];
    $username=$profile_info['username'];
    $email=$profile_info['email'];
    $img=empty($profile_info['img_path']) ? "req_img//profile_icon.png" : $profile_info['img_path'];

    $fullname_err_msg = '';
    $email_err_msg = '';
    $username_err_msg='';
    $img_err_msg='';

    if(isset($_FILES['profile_img_upl']) && !empty($_FILES['profile_img_upl']['name'])){

        if($img !== "req_img//profile_icon.png" && file_exists($img)){
            unlink($img);
        }

        $img=$dir . basename($_FILES['profile_img_upl']['name']);
    }

    if(isset($_POST['save_btn']))
    {
        $fullname = isset($_POST['full_name']) ? $_POST['full_name'] : '';
        $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // check the emply feilds
        if(empty($_POST['full_name']) || empty($_POST['user_name']) || empty($_POST['email']))
        {
            
            if(empty($_POST['full_name'])){
                $fullname_err_msg='Enter Full Name';
            }

            if(empty($_POST['user_name'])){
                $username_err_msg='Enter UserName ';
            }

            if(empty($_POST['email'])){
                $email_err_msg='Enter Email';
            }

        }
        else if($img==="req_img//profile_icon.png"){
            $img_err_msg='Upload Profile Image';
        }
        else if($db_obj->isUserPresent($_POST['user_name'],$_SESSION['uid'])){
            $username_err_msg='UserName is aleady exist';
        }
        else if(!preg_match('/^[a-zA-Z0-9.]+@[a-zA-Z.]+\.[a-zA-Z]{2,}$/',$_POST['email'])){
            $email_err_msg='Enter mail in proper format';
        }
        else{

            $_SESSION['un']=$_POST['user_name'];
            
            if(!empty($_FILES['profile_img_upl']['name'])){
                $extenstion=pathinfo($_FILES['profile_img_upl']['name'],PATHINFO_EXTENSION);
                //new file name
                $new_file_name=$_SESSION['un'] . "_profile_img" . "." . $extenstion;
                $img=$dir . $new_file_name;

                if(move_uploaded_file($_FILES['profile_img_upl']['tmp_name'],$img)){
                    $db_obj->updateProfile($_POST['full_name'],$_POST['user_name'],$_POST['email'],$img,$_SESSION['uid']);
                    header('location: Dashboard.php');
                    exit;
                }
                else{
                    $img_err_msg='failed to upload :(';
                }
            }
            else{
                $db_obj->updateProfile($_POST['full_name'],$_POST['user_name'],$_POST['email'],$img,$_SESSION['uid']);
                header('location: Dashboard.php');
                exit;
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Profile Form -->
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Profile</h2>

        <form method="POST" enctype="multipart/form-data">
            <!-- Profile Image Upload -->
            <div class="flex items-center justify-center mb-6">
                <label for="profile_img_upl" class="relative cursor-pointer">
                    <img src="<?php echo $img;?>" id="img_preview" name="img_preview" alt="Profile Image" class="w-24 h-24 rounded-full border-4 border-yellow-400 object-cover">
                </label>
                <input type="file" id="profile_img_upl" name="profile_img_upl" accept="image/*" class="hidden">
                <label for="img_preview" class="block text-red-500 mb-2"> <?php echo $img_err_msg; ?> </label>
            </div>

            <!-- Profile Form Fields (same as registration) -->
            <div class="mb-4">
                <label for="full_name" class="block text-yellow-400">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo $fullname;?>" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="full_name" class="block text-red-500 mb-2"> <?php echo $fullname_err_msg; ?> </label>
            </div>

            <div class="mb-4">
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $username;?>" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="user_name" class="block text-red-500 mb-2"> <?php echo $username_err_msg; ?> </label>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="email" class="block text-red-500 mb-2"> <?php echo $email_err_msg; ?> </label>
            </div>

            <!-- Save Changes Button -->
            <button type="submit" name="save_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Save Changes</button>
        </form>
    </div>

    <script>
        // JavaScript to preview uploaded profile image
        const profileImageInput = document.getElementById('profile_img_upl');
        const profileImagePreview = document.getElementById('img_preview');

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });s
    </script>
</body>
</html>