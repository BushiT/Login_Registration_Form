<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta  name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<?php 
include("vendor/autoload.php");
use MySql\UserTable;
use MySql\DBConnect;
$nameErr = "";
$emailErr = "";
$addressErr = "";
$passwordErr = "";
$confirm_passwordErr = "";
$name = "";
$email = "";
$password = "";
$address = "";
$confirm_password = "";
if(isset($_POST['register_btn'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $confirm_password = $_POST['Confirm_password'];

  if(empty($name)){
    $nameErr = "The name filed are require";
  }
  if(empty($email)){
    $emailErr = "The email filed are require";
  }
  if(empty($address)){
    $addressErr = "The address filed are require";
  }
  if(empty($password)){
    $passwordErr = "The password filed are require";
  }
  if($password != $confirm_password){
    $confirm_passwordErr = "The password does not match";
  }
  if(empty($confirm_password)){
    $confirm_passwordErr = "The confirm password filed are require";
  }

  if(!empty($name) and !empty($email) and  !empty($address) and !empty($password) and !empty($confirm_password) and $password = $confirm_password){
   
    $enCrpt = md5($password);

    $table = new UserTable(new DBConnect());
    $data = [
      'name' => $_POST['name'] ?? 'Unknown',
      'email' => $_POST['email'] ?? 'Unknown',
      'enCrpt' => md5($_POST['password']) ?? 'Unknwon',
      'address' => $_POST['address'] ?? 'Unknown',
    ];
     if($table){
      $table->insert($data);
     }else {
      HTTP::redirect("/register");
     }
    header('location:login.php');
  }

}
?>

<script src="https://cdn.tailwindcss.com"></script>
  <div class="relative min-h-full w-full">
     <div class="flex justify-center items-center">
        <form action="register.php" method="post" class="bg-green-400 h-fit rounded-md min-1/4 mt-5 border-2 border-blue-500">
            <div class="bg-gray-200 h-14 w-full p-2 pt-3 rounded-t-md">
              <a href="#" class="text-xl font-bold text-blue-500">Register</a>
              <a href="index.php" class="bg-green-500 w-14 h-8 p-1 float-end text-center rounded-md hover:bg-transparent border-green-600 hover:border-2">Back</a>
            </div>
            <div class="mt-1 p-3 rounded-md">
                <label>Name</label>
                <input name="name" type="text" value="<?php echo $name;?>" class="<?php  if($nameErr != "") {?> border-2 border-red-500  <?php }?> w-full h-10 rounded-md p-2 outline-none hover:shadow-md hover:border-2 border-blue-400">
                    <span class="mb-3 text-red-600 font-serif font-medium block">
                       <?php echo $nameErr; ?>
                    </span>
                <label>Email</label>
                <input name="email" type="text" value="<?php echo $email; ?>" class="<?php  if($emailErr != "") {?> border-2 border-red-500  <?php }?> w-full h-10 rounded-md p-2 outline-none hover:shadow-md hover:border-2 border-blue-400">
                   <span class="mb-3 text-red-600 font-serif font-medium block">
                       <?php echo $emailErr; ?>
                    </span>
                <label>Address</label>
                <textarea name="address"  class="<?php  if($addressErr != "") {?> border-2 border-red-500  <?php }?> w-full h-20 rounded-md p-2 outline-none hover:shadow-md hover:border-2 border-blue-400"><?php echo $address; ?></textarea>
                   <span class="mb-3 -mt-1 text-red-600 font-serif font-medium block">
                       <?php echo $addressErr; ?>
                    </span>
                <label>Password</label>
                <input name="password" type="text" value="<?php echo $password; ?>" class="<?php  if($passwordErr != "") {?> border-2 border-red-500  <?php }?>  w-full h-10 rounded-md p-2 outline-none hover:shadow-md hover:border-2 border-blue-400">
                   <span class="mb-3 text-red-600 font-serif font-medium block">
                       <?php echo $passwordErr; ?>
                    </span>
                <label>Confirm Password</label>
                <input name="Confirm_password" type="text" value="<?php echo $confirm_password; ?>" class="<?php  if($confirm_passwordErr != "") {?> border-2 border-red-500  <?php }?> w-full h-10 rounded-md p-2 outline-none hover:shadow-md hover:border-2 border-blue-400">
                    <span class="mb-3 text-red-600 font-serif font-medium block">
                       <?php echo $confirm_passwordErr; ?>
                    </span>
              </div>
            <div class="bg-green-200 h-20 p-4 rounded-b-md">
                <button name="register_btn" type="submit" class="h-10 rounded-md w-20 bg-blue-500 text-md font-medium hover:text-black shadow-md hover:bg-transparent hover:border-2 text-white border-blue-500 ">Register</button>
                <span class="float-end font-medium hover:shadow-md">You already has a account ?</span><br>
                <a href="login.php" class="float-end -mt-5 text-blue-600 font-medium hover:shadow-md block" onClick="return Confirm('Your Account Is Sucessfully Created.')">Login Here</a>
              </div>
        </form>
     </div>
  </div>

</body>
</html>