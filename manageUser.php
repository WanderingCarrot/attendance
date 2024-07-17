<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
</head>
<script>
    function removesuc(){
        alert("User Removed!");
        window.location.replace("manageUser.php");
    }
    function attendsuc(){
        alert("Selected User has been registered!");
        window.location.replace("manageUser.php");
    }
</script>
<body>
    <div class="header"><?php include('inc_header.php');?></div>
        <?php
            checklevel('admin');
            if(isset($_GET['delete'])){
                $userID = $_GET['delete'];
                $sql = "DELETE FROM `user` WHERE userID = '$userID'";
                $result = mysqli_query($db,$sql)OR die("<pre>$sql</pre>". mysqli_error($db));
                echo'<script>',
            'removesuc();',
            '</script>';
            die();
            }
            if(isset($_POST['activityID']) && isset($_POST['attend'])){
                $activityID = $_POST['activityID'];
                foreach($_POST['attend'] as $userID){
                    $sql = "INSERT IGNORE INTO `attend`(userID,activityID) VALUES ('$userID','$activityID')";
                    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
                }
                echo '<script>',
                'attendsuc();',
                '</script>';
            }
            $input_a = '';
            $q = '';

        if(isset($_POST['search'])){
            $input_a = $_POST['input_a'];
            if(!empty($input_a)){
                $q .= "WHERE `user`.userID LIKE '%$input_a%'";
            }
        }
        ?>
        <div class="content" id='printcontent'>
            <h1 class='DamnTitle'>Manage Users</h1>
            <form method="POST" action="">
                <div class='search-container'>
                <input class= 'searchbox' type='text' name='input_a' value = '<?php echo $input_a?>'placeholder = 'User ID'>
                <input class='submit_button' type="submit" name='search' value='Find'>
                <input class = 'submit_button' type="submit" name='reset' value='Reset'> 
    </div>
    <div class='add-button'>
                <button type='button' class='web-button'><a class='webpage-beautiful-a' href='manageUser_form.php'>Add New Users</a></button></div>
                <?php
                    $sql = "SELECT `user`.*,COUNT(`attend`.userID) as totalactivities FROM  `user` LEFT JOIN `attend` ON `user`.userID = `attend`.userID $q GROUP BY userID ORDER BY `user`.`name` ASC";
                    $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>". mysqli_error($db));
                    $total = mysqli_num_rows($result);
                    if($total> 0){
                        echo"<h4 class='manage-total'>Total: $total</h4>";
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                            $userID = $row['userID'];
                            $name = $row['name'];
                            $image = $row['image'];
                            $totalactivities = $row['totalactivities'];
                            if(empty($image)){
                                $image = $defaultImage;
                            }
                            echo"<div class='user-cards'><input class='webpage-checkbox' type='checkbox' name='attend[]' value='$userID'></br>
                            <div class='profile-holder'><img class='manage-pfp' src='./images/$image'></div>
                            <div class='user-content'>
                            <p>ID: $userID</p>
                            <p>Name: $name</p>
                            <p>Total Activities Attended: $totalactivities</p></div>
                            <div class='button-profile'>
                            <button class='manage-button' type='button'><a class='manage-a' href='user_profile.php?userID=$userID'>Profile</a></button>
                            <button class= 'manage-button' type='button'><a class='manage-a' href='javascript:void(0);'onclick='deletethis(\"$userID\")'>Delete</a></button>
                            </div>
                            </div>";
                        }
                    
                
                ?>
                
            <div class='selector-container'>
            <label class='label-user'>Assign user to activities</label>
            <select name='activityID' required>
                <option value="disabled selected">Please choose a activity</option>
            <?php
                $sql="SELECT * FROM `activity` ORDER BY title";
                $result = mysqli_query($db,$sql);
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    $activityID = $row['activityID'];
                    $title = $row['title'];
                    echo"<option value='$activityID'>$title</option>";
                }
                ?>            
                </select>
                <input class="assign-button" type="submit" value="Assign User">
                </div>
            </form>

        </div>
    <?php
        }else{
            echo "No users!";
        }
    ?>
        <script>
    function deletethis(val){
        if(confirm("Confirm?") == true){
            window.location.replace("manageUser.php?delete="+val);
        }
    }
</script>

        <div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
</body>
</html>