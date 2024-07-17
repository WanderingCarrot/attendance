<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management</title>
    <script>
        // JavaScript function to show removal success message and redirect
        function removesuc(){ 
            alert("Activity Removed!");
            window.location.replace("manageUser.php");
        }
    </script>
</head>
<body>

    <div class="header"><?php include('inc_header.php');?></div>
    <?php
        # Check user level
        checklevel('admin');

        # Handle activity deletion 
        if(isset($_GET['delete'])){
            $activityID = $_GET['delete'];
            $sql = "SELECT * FROM `activity` WHERE activityID = '$activityID' LIMIT 1";
            $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $image = $row['image'];
                    $file = __DIR__.'/images/'.$image;

                    if(!empty($image) && file_exists($file)){
                        unlink($file); # Delete associated image file if exists
                    }
                }
                # Delete activity from database
                $sql = "DELETE FROM `activity` WHERE  activityID = '$activityID'";
                $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
                echo'<script>',
                'removesuc();', # Call JavaScript function 
                '</script>';
                die();
            }
        }

        # Initialize variables for search functionality
        $input_a = '';
        $q = '';

        # Handle search form submission
        if(isset($_POST['search'])){
            $input_a = $_POST['input_a'];
            if(!empty($input_a)){
                $q .= "WHERE activity.title LIKE '%$input_a%'";
            }
        }
    ?>
    <!-- Activity management form -->
    <div class="activity-body" id='printcontent'>
        <h2 class ='DamnTitle'>Manage Activities</h2>
        <form method="POST" action="">
            <!-- Search input -->
            <input class= 'searchbox' type='text' name='input_a' value='<?php echo $input_a?>' placeholder='Activity Name'>
            <input class='submit_button' type="submit" name='search' value='Find'>
            <input class='submit_button' type="submit" name='reset' value='Reset'> 
        </form>
        <?php
            # Activity Query Form
            $sql = "SELECT `activity`.activityID, `activity`.*, `admin`.`name`, COUNT(`attend`.attendID) as totalattendees 
            FROM `activity` 
            LEFT JOIN `attend` ON `attend`.activityID = `activity`.activityID 
            LEFT JOIN `admin` ON `admin`.adminID = `activity`.`adminID`
            $q
            GROUP BY `activity`.activityID 
            ORDER BY `activity`.activityID DESC";    
            $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            $total = mysqli_num_rows($result);

            # Display activity cards
            if($total > 0){
                echo "<h2 class='total-manage'>Total: $total</h2><div class='beautiful-cards'>";
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $activityID = $row['activityID'];
                    $title = $row['title'];
                    $image = $row['image'];
                    $location = $row['location'];
                    $name = $row['name'];
                    $points = $row['points'];
                    $totalattendees = $row['totalattendees'];
                    $time = date("j M Y, g:i A", strtotime($row['time']));

                    # Add "(Ended)" to time if activity has ended
                    if(!checktime($time)){
                        $time = $time. "(Ended)";
                    }
                    if(!empty($image)){
                        $img = "<img class='web-images' src=./images/$image>";
                    }
                    # Content
                    echo "<div class='beautiful-activity-card'>
                            <div class='card-image'>$img</div>
                            <div class='informative'>
                                <div class='card-title'><h3>$title</h3></div>
                                <div class='card-time'>Time: $time</div>
                                <div class='card-location'>Location: $location</div>
                                <div class='card-points'>Points: $points $label_points</div>
                                <div class='card-points'>Manager: $name</div>
                            </div>
                            <button class='manage-button'><a class='beautiful-button' href='manageAttendance.php?activityID=$activityID'>Record Attendance</a></button>
                            <button class='manage-button'><a class='beautiful-button' href='manageActivity_form.php?activityID=$activityID'>Edit</a></button>
                            <button class='manage-button'><a class='beautiful-button' href='javascript:void(0)' onclick='deletethis($activityID)'>Delete</a></button>
                        </div>";
                }
                echo "</div>";
            } else {
                echo "No data.";
            }
        ?>

        <script>
            function deletethis(val){
                if(confirm('Confirm') == true){
                    window.location.replace('manageActivity.php?delete='+val)
                }
            }
        </script>
    </div>

    <div class='footer'>
        <?php include("inc_footer.php") ?>
    </div>
</body>
</html>
