<?php  
session_start();
include("../vendor/autoload.php");
use admin\Auth;
use admin\HTTP;
use MySql\DBConnect;
use MySql\UserTable;
//logout
$home = "/index.php";
if(isset($_POST['logout_btn'])){
    session_destroy();
    HTTP::redirect($home);
}

Auth::check();
 $user_edit = false;
 $user_name="";
 $user_email="";
 $user_address="";

 if(isset($_POST['edit_profile_btn'])){
   $user_edit = true;
}

//Edit User Data
if(isset($_POST['update_btn'])){
   if(isset($_POST['id'])){
      $table = new UserTable(new DBConnect());
      $data = [
         'update_name' => $_POST['name'],
         'update_email' => $_POST['email'],
         'update_address' => $_POST['address'],
         'update_id' => $_POST['id']
      ];
      $table->updateData($data);
      $_SESSION['user_array']['name'] = $data['update_name'];
      $_SESSION['user_array']['email'] = $data['update_email'];
      $_SESSION['user_array']['address'] = $data['update_address'];
      header('location:user-dashboard.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
<script src="https://cdn.tailwindcss.com"></script>
<div class="relative min-h-screen min-w-full">
   <div class="flex justify-center items-center">
     <div class=" bg-gray-100 h-fit w-3/4 sm:w-2/4 mt-8 rounded-md border-2 border-blue-300 shadow-md">
         <div class="h-16 bg-green-500 p-5">
            <div class="float-start"><a href="admin-dashboard.php" class="text-xl font-sans font-semibold text-white">User-Dashboard</a>
         </div>
         <form action="user-dashboard.php" method="post" class="float-end -mt-2">
               <button class="hover:shadow-md text-lg font-sans font-md text-white bg-blue-500 w-20 h-10 rounded-md" name="logout_btn" type="submit" onClick="return confirm('Are You Sure To Logout ?')">Logout</button>
            </form>
         </div>
          <div class="ml-3 text-lg font-medium mt-3 -mb-3 text-green-700">Your Infomation</div>
          <p class="h-2"></p>
           <div class="p-2">
           <table class="w-full text-center mt-3 mb-3 table-auto border-collapse border-separate-1 border-blue-500">
              <img src="photo/profile.png" class="w-50 h-20 rounded-md ml-2">
              <form action="user-dashboard.php" method="post">
              <div class="ml-2">
                 <span class="block text-lg font-sans">Name - <?php print_r($_SESSION['user_array']['name']); ?></span>
                 <span class="block text-lg font-sans">Email - <?php print_r($_SESSION['user_array']['email']); ?></span>
                 <span class="block text-lg font-sans">Address - <?php print_r($_SESSION['user_array']['address']); ?></span>
                 <span class="block text-lg font-sans">Role - <?php print_r($_SESSION['user_array']['role']); ?></span>
                 <button class="block text-lg font-sans font-medium bg-green-500 mb-3 mt-2 rounded-md w-48 h-10" type="submit" name="edit_profile_btn">Edit Your Infomation</button>
              </div>
              </form>
              <form action="user-dashboard.php" method="post" enctype="multipart/form-data">
              <input type='file' name="photo" class="ml-2">
              <button type="submit" class="hover:shadow-md text-lg font-sans font-md text-white bg-blue-500 w-16 h-9 rounded-md">Send</button>
             </form>
             <?php 
             if(isset($_FILES['photo'])){
               $tmp = $_FILES['photo']['tmp_name'];
              $type = $_FILES['photo']['type'];
              if($type === "image/jpeg" or $type === "image/png") {
                move_uploaded_file($tmp,"photo/profile.png");
              }
            }
              ?>
           </table>
           </div>
     </div>
     <?php if($user_edit==true):?>
     <div id="display"  class="content-center shadow-md bg-green-500 mt-2 ml-2 mr-2 w-2/4 md:w-1/4 border-2 border-blue-500 rounded-md">
        <div class="w-full bg-green-100 h-14 p-4 rounded-t-md">
          <div class="ml-3 text-xl font-medium text-blue-500">Edit Your Infomation</div>
        </div>
          <p class="h-2"></p>
           <div class="p-2">
           <table class="w-full text-center mt-3 mb-3 table-auto border-collapse border-separate-1 border-blue-500">
          <form action="user-dashboard.php" method="post">   
           <div class="ml-2">
            <input type="text" name="id" class="hidden" value="<?php if(isset($_SESSION['user_array']['id'])){print_r($_SESSION['user_array']['id']);} ?>">
                  <label>
                  <span class="block text-lg">Name</span>
                  <input type="text" name="name" value="<?php if(isset($_SESSION['user_array']['name'])){print_r($_SESSION['user_array']['name']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
                  <label class="mb-3">
                  <span class="block text-lg font-sans">Email</span>
                  <input type="text" name="email" value="<?php if(isset($_SESSION['user_array']['name'])){print_r($_SESSION['user_array']['email']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
                  <label>
                  <span class="block text-lg font-sans">Address</span>
                  <input type="text" name="address" value="<?php if(isset($_SESSION['user_array']['name'])){print_r($_SESSION['user_array']['address']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
              </div>
              
             <div class="w-full h-7 mt-2 ml-2">
                     <button name="update_btn" type="submit" class="w-24 p-2 rounded-md h-10 bg-blue-500 text-white font-medium mb-2">Update</button>
                     <button name="cancel_btn" type="submit" class="w-24 p-2 rounded-md h-10 bg-red-500 mr-5 text-white font-medium float-end md:float-start mb-2" onClick="cancel(); return false;" >Cancel</button>
              </div>
              </form>
           </table>
          </div>
    </div>
     <?php endif?>
   </div>
</div>
    
</body>
</html>