<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php 
session_start();
include("vendor/autoload.php");
use admin\HTTP;
use MySql\UserTable;
use MySql\DBConnect;
$loginErr = "";
   if(isset($_POST['login_btn'])){
         $email = $_POST['email'];
         $password = $_POST['password'];
         $encryt = md5($password);
         $table = new UserTable(new DBConnect());
        
        $user = $table->findByEmailAndpassword($email,$encryt);
            if($user) {
               $_SESSION['user_array'] = $user;
                if($_SESSION['user_array']['role'] =='admin'){
                  HTTP::redirect("/dashboard/admin-dashboard.php");
                }else{
                  HTTP::redirect("/dashboard/user-dashboard.php");
               }
            }else { 
              $loginErr = "Invalid Email or password";
                  }
   }

?>
<script src="https://cdn.tailwindcss.com"></script>
<style>
.card {
   box-sizing:border-box;
}
</style>
    <div class="min-h-screen w-full">
       <div class="flex justify-center items-center p-10">
          <div class="bg-green-500 max-w-1/4 h-80 mt-5 rounded-md border-2 border-blue-500" id="card">
             <div class="bg-green-300 h-14 rounded-t-md p-3">
                <a href="login.php" class="text-2xl font-medium text-blue-600">Login</a>
             </div>
               <form action="login.php" method="post">
               <div class="p-4">
                  <span class="block text-red-600 text-lg font-medium"><?php echo $loginErr; ?></span>
                <label>
                  <span>Email</span>
                  <input type="text" name="email" class="w-full h-10 mb-5 rounded-md outline-none hover:border-2 border-blue-500 mt-1 p-3">
                </label>
                <label>
                  <span>Password</span>
                  <input type="text" name="password" class="w-full h-10 rounded-md outline-none hover:border-2 border-blue-500 mt-1 p-3">
                </label>
             </div>
             <div class="bg-green-300 p-4 h-14 mt-4 rounded-b-md shadow-xl">
                <button type="submit" name="login_btn" class="bg-blue-500 w-20 h-10 -mt-2 rounded-md font-medium text-lg hover:text-blue-500 hover:bg-transparent border-blue-500 hover:border-2">Login</button>
                <span class="float-end text-md font-medium -mt-3 sm:-mt-1">You don't have a account ?<br class="sm:hidden"><a href="register.php" class="text-blue-600"> Register Here</a></span>                  
            </div>
               </form>
          </div>
       </div>
    </div>
</body>
</html>