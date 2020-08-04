<?php
    include "inc/header.php";
    include "lib/user.php";
    session::checkLogin();

    $user = new user();
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])){
        $usrRegi = $user->registration($_POST);
    }


?>

<div class="card">
<div class="card-header py-3">
    User Registration
</div>
<div class="card-body">
    <?php
        if(isset($usrRegi)){
            echo $usrRegi;
        }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="form-group form-custom">

            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" >

            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" >

            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" >


            <label for="pass" class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" id="pass" >
            <input type="submit" name="register" Value="Registration" class="btn btn-success btn-lg mt-4">
        </div>

    </form>
</div>
</div>


<?php include "inc/footer.php";?>