<?php
    include "inc/header.php";
    include "lib/user.php";
    session::checkSession();

    

    $loginmsg = session::get("loginmsg");
    if(isset($loginmsg)){
        echo $loginmsg;
    }
    session::set("loginmsg", null);
?>
<div class="card">

<div class="card-header py-3">
    User List 
        <span class="float-right">
            Welcome<strong style="font-size:2.5rem;">
             <?php 
             $name = session::get("username");
             if(isset($name)){
                echo $name;
             }
             ?> </strong>
        </span>
</div>

<div class="card-body">
    <table class="table table-striped text-center">
        <tr>
            <th width=20%>Serial</th>
            <th width=20%>Name</th>
            <th width=20%>Username</th>
            <th width=20%>Email Address</th>
            <th width=20%>Action</th>
        </tr>

    <?php
        $user = new user();
        $userdata = $user->getUserData();
        if($userdata){
            $i = 0;
            foreach($userdata as $sdata){
                $i++
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $sdata["name"];?></td>
            <td><?php echo $sdata["username"];?></td>
            <td><?php echo $sdata["email"];?></td>
            <td><a class="btn btn-primary" href="profile.php?id=<?php echo $sdata["id"];?>">View</a></td>
        </tr>

<?php } }else{?>
        
        <tr>
            <td colspan="5"><h2>NO Userdata Found!...</h2></td>
        </tr>


<?php } ?>
       
    </table>
</div>
</div>


<?php include "inc/footer.php";?>