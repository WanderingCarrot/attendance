<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management</title>
        <script>
            function SuccessMsg1(){
                alert('Saved!');
                window.location.replace('manageUser.php');
            }
        </script>
    </head>

    <body>
        <div class="header">
            <?php include('inc_header.php'); ?>
        </div>
        <div class="content" id='printcontent'>
        <?php
        checklevel('admin');
        $userID = $password = $name = $groupID = "";

        if (isset($_POST["userID"])) {
            $userID = trim($_POST["userID"]);
            $password = trim($_POST["password"]);
            $name = trim($_POST["name"]);
            $groupID = $_POST["groupID"];

            $sql = "INSERT IGNORE INTO `user`(userID,`password`,`name`,groupID) VALUES('$userID','$password','$name','$groupID')";
            $result = mysqli_query($db,$sql)OR die("<pre>$sql</pre>". mysqli_error($db));
            echo'<script>',
                'SuccessMsg1();',
                '</script>';
            }
        ?>
        
        <h1 class='DamnTitle'>User Information</h1>
        <div class="manage-cards">
        <form method="POST" action="">
        <form class="form_contents" method = 'POST' action=''>
        <div class = "account-input">
        <label class='input-names'>Account ID</label>
        <input class = 'website-beautiful-input' type = "text" name = "userID" value="<?php echo $userID; ?>" required></div>
        <div class = "account-input"><label class='input-names'>Password</label>
        <input class = 'website-beautiful-input' type = "password" name = "password" value="<?php echo $password; ?>"required></div>
        <div class = "account-input"><label class='input-names'>Name</label>
        <input class = 'website-beautiful-input' type = "text" name = "name" value="<?php echo $name;?>" required></div>
        <div class= "department-selector"><label class='input-names'><?php echo $label_groups;?></label>
            <select class='webpage-selector' name= 'groupID' required>
            <option value = '' disabled selected>Please Choose</option>
            <?php 
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
            </select>
    </div>
    <input class='submit_button' type='submit' value="Save">
        </form></div>
        <button class="back-button" onclick='history.back()'>Back</button>
        </div>
        <div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
    </body>

</html>