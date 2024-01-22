<?php  
session_start(); 
$home = "/login.php";
include("../vendor/autoload.php");
use admin\Auth;
use admin\HTTP;
use MySql\DBConnect;
use MySql\UserTable;
Auth::check();


//logout
if(isset($_POST['logout_btn'])){
   session_destroy();
   HTTP::redirect($home);
}

//Delete User Data
if(isset($_GET['DeleteUserDataId'])){
   $table = new UserTable(new DBConnect());
   $table->deleteUser();
   //header('location:admin-dashboard.php');
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<script src="https://cdn.tailwindcss.com"></script>
<?php
$table = new UserTable(new DBConnect());
$result = $table->getAll();

//To Get Edit user Data From db 
$edit_form = false;
if(isset($_GET['editUserDataId'])){
   $edit = new UserTable(new DBConnect());
         $idk = $edit->edit();
         $edit_form = true;
}

 //apply update data to db
if(isset($_POST['update_btn'])){
      if(isset($_POST['id'])){
         $table = new UserTable(new DBConnect());
         $data = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'role' => $_POST['role']
         ];
         $table->updateDataAdmin($data);
         header('location:admin-dashboard.php');
      }
}

?>
<div class="relative min-h-screen min-w-full">
   <div class="flex justify-center items-start">
     <div class=" bg-gray-100 h-fit mt-8 rounded-md border-2 border-blue-300 shadow-md mr-2 w-2/4 md:w-2/3">
         <div class="h-16 bg-green-500 p-5"> 
            <div class="float-start"><a href="admin-dashboard.php" class="text-xl font-sans font-semibold text-white">Admin-Dashboard</a>
         </div>
         <form action="admin-dashboard.php" method="post" class="float-end -mt-2">
               <button class="text-lg font-sans font-md text-white bg-blue-500 w-20 h-10 rounded-md" name="logout_btn" type="submit" onClick="return confirm('Are You Sure To LogOut')">Logout</button>
            </form>
         </div>
         <div class="ml-3 text-lg font-medium mt-3 -mb-3 text-red-700 block md:hidden">Please use this admin-dashboard  in laptop</div>
          <div class="ml-3 text-lg font-medium mt-3 -mb-3 text-green-700">Users List</div>
          <p class="h-2"></p>
           <span class="ml-3 text-lg font-medium mt-3 mb-3 text-blue-600 ">Admin : <?php echo  $_SESSION['user_array']['name'];?></span>
           <div class="p-2">
           <table class="w-full text-center mt-3 mb-3 table-auto border-collapse border-separate-1 border-blue-500">
             <thead>
             <tr>
                <th class="border border-blue-300">ID</th>
                <th class="border border-blue-300">Name</th>
                <th class="border border-blue-300">Email</th>
                <th class="border border-blue-300">Address</th>
                <th class="border border-blue-300">Role</th>
                <th class="border border-blue-300">Action</th>
             </tr>
             </thead>
             <tr class="h-2"></tr>
             <tbody>
                 <?php
                   foreach($result as $rows){
                  ?>
                  <tr class="hover:bg-gray-200">
                    <td class="border border-blue-300"><?php  print_r($rows['id']); ?></td>
                    <td class="border border-blue-300"><?php  echo $rows['name']; ?></td>
                    <td class="border border-blue-300"><?php echo $rows['email']; ?></td>
                    <td class="border border-blue-300"><?php echo $rows['address']; ?></td>
                    <td class="border border-blue-300"><?php echo $rows['role']; ?></td>
                    <td class="border border-blue-300"><a href="admin-dashboard.php?editUserDataId=<?php echo $rows['id'] ?>" class="text-blue-500">Edit</a> | <a href="admin-dashboard.php?DeleteUserDataId=<?php echo $rows['id'] ?>" onClick=" return confirm('Are You Sure To Delete ?')" class="text-red-500">Delete</a></td>
                  </tr>
                  <?php }
                 ?>
              </tbody>
           </table>
           </div>
     </div>
     <?php if($edit_form == true):?>
     <div id="display"  class="content-center shadow-md bg-green-500 mt-2 ml-2 mr-2 w-2/4 md:w-1/4 border-2 border-blue-500 rounded-md">
        <div class="w-full bg-green-100 h-14 p-4 rounded-t-md">
          <div class="ml-3 text-xl font-medium text-blue-500">Edit User Infomation</div>
        </div>
          <p class="h-2"></p>
           <div class="p-2">
           <table class="w-full text-center mt-3 mb-3 table-auto border-collapse border-separate-1 border-blue-500">
          <form action="admin-dashboard.php" method="post">   
           <div class="ml-2">
            <input type="text" name="id" class="hidden" value="<?php if(isset($_GET['editUserDataId'])){echo $_GET['editUserDataId'];} ?>">
                  <label>
                  <span class="block text-lg">Name</span>
                  <input type="text" name="name" value="<?php if(isset($idk['name'])){print_r($idk['name']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
                  <label class="mb-3">
                  <span class="block text-lg font-sans">Email</span>
                  <input type="text" name="email" value="<?php if(isset($idk['email'])){print_r($idk['email']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
                  <label>
                  <span class="block text-lg font-sans">Address</span>
                  <input type="text" name="address" value="<?php if(isset($idk['address'])){print_r($idk['address']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
                  </label>
                  <label>
                  <span class="block text-lg font-sans">role</span>
                  <input type="text" name="role" value="<?php if(isset($idk['role'])){print_r($idk['role']);} ?>" class="w-full h-8 rounded-md mb-2 outline-none hover:border-2 border-blue-500 p-3">
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
<script> 
     let editbtn = document.querySelector("#display");
     function cancel(){
      editbtn.style.display = "none";
     } 
    </script>
</html>