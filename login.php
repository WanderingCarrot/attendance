<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<script type = "text/javascript">
    //When user is logged in, send them back to the index page.
    function LogInSuccess(){
        alert("You've successfully Log In.");
        window.location.replace("index.php");
    }
    //When user does not exist/wrong password or account ID, alert the user.
    function ErrorLogIn(){
        alert("You've entered the wrong password or account ID.");
    }
</script>
<body>

<div class="header"><?php include('inc_header.php');?></div>
    <div class='content' id='printcontent'>
<?php

if(isset($_POST['accID']) && isset($_POST['password'])){
    $accID = trim(strtolower($_POST['accID']));
    $password = trim($_POST['password']);
    $level = $_POST['level'];

    #Identify the account ID
    if($level == 'user'){
        $dbname = 'user';
        $medan_id = 'userID';
    }
    else{
        $dbname = 'admin';
        $medan_id = 'adminID';
        $level = 'admin';
    }

    $sql = "SELECT * FROM $dbname WHERE $medan_id ='$accID' AND password = '$password' LIMIT 1";
    $result = mysqli_query($db, $sql) OR die(mysqli_error($db));

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            # Keep the users information in session if they are logged in.
            $_SESSION['userID'] = $row[$medan_id];
            $_SESSION['name'] = $row['name'];
            $_SESSION['level'] = $level;
            
            echo'<script type="text/javascript">',
            'LogInSuccess();',
            '</script>'; # Calling the LogInSuccess function.

            die();
        }

    }
    else{
        echo "<script type='text/javascript'>ErrorLogIn();</script>"; # Calling Error
    }    
}
?>

<!-- User Log In Session -->
<div class='login_card'>
<div class='log-in-title'><h3>Log In</h3></div>
    <form class="form_contents" method = 'POST' action=''>
        <div class = "account-input">
        <label class='input-names'>Account ID</label>
        <input class = 'website-beautiful-input' type = "text" name = "accID" required></div>
        <div class = "account-input"><label class='input-names'>Password</label>
        <input class = 'website-beautiful-input' type = "password" name = "password" required></div>
        <div class= "level-selector"><label class='input-names'>Access Level</label>
        <select class='website-beautiful-selector' name = "level">
            <option value = 'user'>User</option>
            <option value = 'admin'>Admin</option>
        </select>
</div>
        <input class='Login-button' type="submit" name = "" value ="Log In">
        <p class='signup-a'>Don't have an account? Sign Up <a href='signup.php'>here</a> </p>
</form>
</div>
</div>
<div class="footer"><?php include('inc_footer.php')?></div>
</body>

</html>

                