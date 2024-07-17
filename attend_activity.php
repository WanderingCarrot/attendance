<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participate</title>
</head>
<body>
<div class="header"><?php include('inc_header.php');?></div>
<?php 
    checklevel('user');
    if(isset($_GET['id'])&& isset($_GET['action'])){
        $activityID = $_GET['id'];
        $action = $_GET['action'];
        $userID = $_SESSION['userID'];

        if($action== 'add'){
            $sql = "INSERT IGNORE INTO `attend`(userID,activityID) VALUES('$userID','$activityID')";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
            echo"<script>alert('You have successfully sign up for this activity.');</script>";

        }
        elseif($action== "remove"){
            $sql = "DELETE FROM `attend`(userID,activityID) VALUES('$userID','$activityID')";
            $result = mysqli_query($db, $sql) OR die("<pre></pre>". mysqli_error($db));
            echo "<script>alert('The activity has already been removed from your record.');</script>";            
    }
    
}
    else{
        echo"<script>alert('The activity was not found.');</script>";
    }
    echo"<script>window.location.replace('user_profile.php');</script>";
?>
<div class='footer'>
            <?php include("inc_footer.php")?>
        </div>
</body>
</html>