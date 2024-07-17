<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management</title>
    <script type="text/javascript">
        function ErrorMsg1(){
            alert("Failed to find activity.");
            window.location.replace('manageActivity.php');
        }
        function SuccessMsg1(){
                alert('Saved!');
                window.location.replace('manageActivity.php');
            }
    </script>
</head>
<body>
    <div class="header"><?php include('inc_header.php');?></div>
        <div class="content" id='printcontent'>
        <?php
            # Check user level
            checklevel('admin');

            # Initialize variables
            $title = $details = $time = $location = $image = $adminID = "";
            $edit_data = 0;

            # Retrieve activity data for editing
            if (isset($_GET["activityID"])) {
                $id = $_GET["activityID"];
                $sql = "SELECT * FROM `activity` WHERE activityID = $id LIMIT 1";
                $result = mysqli_query($db,$sql)OR  die("<pre>$sql</pre>".mysqli_error($db));

                if(mysqli_num_rows($result)> 0){
                    $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $title = $edit_data["title"];
                    $details = $edit_data["details"];
                    $location = $edit_data["location"];
                    $points = $edit_data["points"];
                    $adminID = $edit_data["admin"];
                    $image = $edit_data["image"];
                    $time = date("Y-m-d H:i:s", strtotime($edit_data["time"]));
                }else{
                    # If activity not found, show error message
                    echo'<script>',
                        'ErrorMsg1();',
                        '</script>';
                }
            }
            if (isset($_POST['title'])&& !empty($_POST['title'])){
                $title = mysqli_real_escape_string($db, $_POST['title']);
                $details = mysqli_real_escape_string($db, $_POST['details']);
                $location = $_POST['location'];
                $points = $_POST['points'];
                $time = date("Y-m-d H:i:s", strtotime($edit_data["time"]));
                $adminID = $_SESSION['adminID'];

                # Upload image if provided
                if(isset($_FILES['image'])&& file_exists($_FILES['image']['tmp_name'])){

                    $i = $_FILES['image'];
                    $file_size = $i['size'];
                    $file_tmp = $i['tmp_name'];
                    $file_name = explode('.',$i['name']);
                    $file_ext = strtolower(end($file_name));

                    $ext = array('jpeg','jpg','png','bmp','gif');
                    if(in_array($file_ext,$ext)){
                        $file_location =__DIR__ .'/images/';
                        
                        if(!empty($image)&& file_exists($file_location.$image)){
                            unlink($file_location.$image);
                        }
                        $newname = strtotime('now').'.'.$file_ext;
                        if(move_uploaded_file($file_tmp,$file_location.$newname)){
                            $image = $newname;
                        }
                    }   
                }
                # Update or insert activity into database
                if($edit_data){
                    $sql = "UPDATE `activity` SET `title`='$title',`details`='$details',`time`='$time',`location`='$location',`image`='$image',`points`='$points' WHERE activityID = $id";
                }
                else{
                    $sql = "INSERT INTO `activity`(`title`,`details`,`time`,`location`,`image`,`points`,`adminID`)
                    VALUES ('$title','$details','$time','$location','$image','$points','$adminID')";
                }
                $result = mysqli_query($db, $sql)OR die("<pre>$sql</pre>".mysqli_error($db));
                # Show success message
                echo'<script>',
                'SuccessMsg1();',
                '</script>';
            }
        ?>
        
        <div class='beautiful-activity-card'>
            
    
        <?php
        # Display image if available
        if(!empty($image)){
            echo "<img class='web-images' src='images/$image'>
        <form class='form_content' method='POST' action='' enctype='multipart/form-data'>
        <div class='file-container'>
        <input type='file' id='file-input' name='image'>
        <label id='file-input-label' for='file-input'>Select a File</label>
        </div>";
        }
        else{
            echo "No image";
        }
        ?>
<div class='beautiful-cards'>        
    <div class="account-input">    
    <label class='input-names'>Title</label>
        <input class='website-beautiful-input' type="text" name="title" value="<?php echo $title ?>">
    </div>
    <div class="account-input">
        <label class="input-names">Details</label>
        <textarea type='text' name='details' row='4' cols='30'><?php echo $details?></textarea>
    </div>
    <div class="account-input">
        <label class='input-names'>Time</label>
        <input class='website-beautiful-input' type='datetime-local' name='time' value='<?php echo $time ?>'>
    </div>
    <div class="account-input">
        <label class='input-names'>Location</label>
        <input class='website-beautiful-input' type="text" name="location" value='<?php echo $location ?>'>
    </div>
    <div class="account-input">
        <label class='input-names'>Points</label>
        <input class='website-beautiful-input' type="number" name="points" value="<?php echo $points ?>">
</div>
    
    



</div>
<input class='back-button' type="submit" value="Save">    
</form>
        </div>
    <button class="back-button" onclick='history.back()'>Back</button>
    
    <div class='footer'>
                <?php include("inc_footer.php") ?>
    </div>
</body>
</html>
