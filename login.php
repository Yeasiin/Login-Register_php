<?php
    include "inc/header.php";
    include "lib/user.php";
    session::checkLogin();

    $user = new user();
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
        $userLogin = $user->userLogin($_POST);
    } 


?> 

<div class="card">
<div class="card-header py-3">
    User Login
</div>
<div class="card-body">
    <?php
        if(isset($userLogin)){
            echo $userLogin;
        }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="form-group form-custom">
            <label for="email" class="form-label">Email Address</label>
            <input type="text" name="email" class="form-control" id="email">
            <label for="pass" class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" id="pass">
            <input type="submit" name="login" Value="submit" class="btn btn-success btn-lg mt-4">
        </div>

    </form>
</div>
</div>


<?php include "inc/footer.php";?>