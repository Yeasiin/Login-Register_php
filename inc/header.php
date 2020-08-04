<?php
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath."/../lib/session.php";
    session::init();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login & Register </title>
    <link rel="stylesheet" href="inc/boostrap5.min.css">
    <link rel="stylesheet" href="style.css">
    
</head>

<?php
    if(isset($_GET["action"]) && $_GET["action"] == "logout"){
        session::distroy();
    }
?>
<body>
<div class="container">
    <div class="row">
<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <a href="index.php" class="navbar-brand mr-auto">Login & Register System</a>
        <ul class="navbar-nav">
        
        <?php
            $id = session::get("id");
            $userlogin = session::get("login");
            if($userlogin == true){
        ?>

            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php?id=<?php echo $id; ?>">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="?action=logout">Log out</a></li>
        <?php }else{ ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <?php
            }
        ?>
        
        </ul>
</nav>