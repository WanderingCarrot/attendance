
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<script type="text/javascript">
        function SignUpSuccess(){
            alert("You've successfully Sign Up. Please Log In with your ID");
            window.location.replace('login.php');
        }
    </script>
<body>
    
    <div><?php include('inc_header.php');?></div>
    <div class='content' id='printcontent'>
    
    <?php 
    $label_group = "Department";
    # Initialize variables
    $userID = $name = $password = $groupID = $image;
    # Empty string to keep error messages.
    $error = '';
    
    if(isset($_POST['userID'])){
        $userID = trim($_POST['userID']);
        $password = trim($_POST['password']);
        $name = trim($_POST['name']);
        $groupID = $_POST['groupID'];

        # Check if username has any unacceptable symbols
        if(preg_match('/[^a-zA-Z0-9]+/', $userID)){
            $error = "No symbols are allowed in user ID.";
        }

        # Check if all the columns are filled
        if(empty($name) || empty($userID) || empty($password)){
            $error = "Please fill all the spaces.";
        }
        # Get ID length
        $id_length = strlen($userID);
        # Maximum ID length
        if($id_length > 15){
            $error = "Your ID is too long. Maximum 15 characters.";
        }
        # Minimum ID length
        if($id_length < 6){
            $error = "Your ID is too short. Minimum 6 characters.";
        }
        # Get password length
        $password_length = strlen($password);

        # Minimum password length
        if($password_length < 6){
            $error = "Your password is too short. Minimum 6 characters.";
        }

        # Check if all the requirements are fulfilled
        $sql = "SELECT * FROM `user` WHERE userID = '$userID' LIMIT 1";
        $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));

        if(mysqli_num_rows($result) > 0){
            $error = "The ID($userID) has already been used, please choose a different ID.";
        }

        # Continue if there are no errors
        if(empty($error)){
            $sql = "INSERT INTO `user` (`userID`, `password`, `name`, `groupID`, `image`)
            VALUES('$userID', '$password', '$name', '$groupID', '$defaultImage')";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));

            # Calling the SignUpSuccess function
            echo'<script type="text/javascript">',
            "SignUpSuccess();",
            '</script>';
            die();
    }
    # Display the error message
    else{
        echo '<script type= "text/javascript">',
        "alert('$error')",
        '</script>';
        }
        
    }
    ?>
    <!--Sign Up Section-->
    <div class='signup_card'>
<div class='sign-up-title'><h3>Sign Up</h3></div>
    <form class="form_contents" method = 'POST' action=''>
        <div class = "account-input">
        <label class='input-names'>Account ID</label>
        <input class = 'website-beautiful-input' type = "text" name = "userID" value="<?php echo $userID; ?>" required></div>
        <div class = "account-input"><label class='input-names'>Password</label>
        <input class = 'website-beautiful-input' type = "password" name = "password" value="<?php echo $password; ?>"required></div>
        <div class = "account-input"><label class='input-names'>Name</label>
        <input class = 'website-beautiful-input' type = "text" name = "name" value="<?php echo $name;?>" required></div>
        <div class= "department-selector"><label class='input-names'><?php echo $label_groups;?></label>
    
        <select class='website-selector' name= 'groupID' required>
            <option value = '' disabled selected>Please Choose</option>
            <?php 
            # Get all groups to make dropdown options
            $sql = "SELECT * FROM `group` ORDER BY groupName";
            $result = mysqli_query($db, $sql);

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $groupRow = $row['groupID'];
                $groupName = $row['groupName'];

                if($groupID == $groupRow){
                    $selected = "selected";
                }
                else{
                    $selected = "";
                }
                echo "<option $selected value = '$groupRow'>$groupName</option>";
            }
            ?>
        </select></div>

    <input class='signup-button' type="submit" name = 'signup' value ="Sign Up">
            <!--Redirect back to Log In page if user have an account.-->
    <p class='signup-a'>Have an account? Log In <a href='login.php'>here</a> </p>
</div>
</form>
</div>
<div class = "footer"><?php include('inc_footer.php')?></div>


</body>
</html>