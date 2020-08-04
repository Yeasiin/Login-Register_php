<?php 
    include "lib/user.php";
    include "inc/header.php";
    session::checkSession();


    if(isset($_GET["id"])){
        $userid = (int)$_GET["id"];
    }
    
    $user = new user();
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])){
        $updateusr = $user->updateUserData($userid, $_POST);
    }


?>

<div class="card">
<div class="card-header py-3">
    User Profile
        <span class="float-right">
            <a class="btn btn-lg btn-danger" href="index.php"> &times; Back</a>
        </span>
</div>
<div class="card-body">

<?php
    if(isset($updateusr)){
        echo $updateusr;
    }
?>

<?php
    $userdata = $user->getUserById($userid);
    if(isset($userdata)){
?>
    <form action="" method="POST">
        <div class="form-group form-custom">

            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $userdata->name;?>">

            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $userdata->username;?>">

            <label for="email" class="form-label">Email Address</label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo $userdata->email;?>">
        <?php 
            // $sasid = session::get("id");
            if($userid == $id){
        ?>
            <input type="submit" name="update" Value="Update" class="btn btn-success btn-lg mt-4">
            <a class="btn btn-info btn-lg inline-block mt-4" href="passchange.php?id=<?php echo  $userid ?>">Change Password</a>
        <?php } ?>
        </div>

    </form>
    <?php } ?>
</div>
</div>


<?php include "inc/footer.php";?>