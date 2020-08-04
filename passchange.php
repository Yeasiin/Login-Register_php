<?php 
    include "inc/header.php";
    include "lib/user.php";
    session::checkSession();


    if(isset($_GET["id"])){
        $userid = (int)$_GET["id"];
        $sasid = session::get("id");
        if($userid != $sasid){
            header("Location: index.php");
        }
    }
    $user = new user();
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updatepass"])){
        $updatepass = $user->updatePassword($id, $_POST);

    }

?>

<div class="card">
<div class="card-header py-3">
    Change Password
        <span class="float-right">
            <a class="btn btn-lg btn-danger" href="profile.php?id=<?php echo $userid;?>"> &times; Back</a>
        </span>
</div>
<div class="card-body">

<?php
    if(isset($updatepass)){
        echo $updatepass;
    }
?>
    <form action="" method="POST">
        <div class="form-group form-custom">

            <label for="old_pass" class="form-label">Old Password</label>
            <input type="text" name="old_password" class="form-control" id="old_pass" value="">

            <label for="password" class="form-label">New Password</label>
            <input type="text" name="password" class="form-control" id="password" value="">


            <input type="submit" name="updatepass" Value="Update" class="btn btn-success btn-lg mt-4">
        </div>

    </form>
</div>
</div>


<?php include "inc/footer.php";?>