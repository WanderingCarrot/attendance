<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Attendance</title>
    <script>
            function ErrorMsg1(){
                alert("ID needed!");
                window.location.replace('manageActivity.php');
            }
            function updatesuc(){
                alert("The Status has been updated!");
            }
            function removesuc(){
                alert("User Removed!");
    }
        </script>
</head>
<body>
<div class="header"><?php include('inc_header.php');?></div>
<?php
    checklevel('admin');
    if(isset($_GET['activityID'])){
        $activityID = $_GET['activityID'];
    }else{
        echo'<script>',
            'ErrorMsg1();',
            '</script>';
            die();
    }
    if(isset($_GET['action'])&& isset( $_GET['attendID'])){
        $attendID = $_GET['attendID'];
        $action = $_GET['action'];
        if($action== 'attend' || $action== 'absent'){
            $sql = "UPDATE `attend` SET  `status`='$action' WHERE attendID=$attendID";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            echo'<script>',
            'updatesuc();',
            '</script>';
        }elseif($action == 'delete'){
            $sql = "DELETE FROM `attend` WHERE attendID = $attendID";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            echo'<script>',
            'removesuc();',
            '</script>';
        }
        echo'<script>';
        echo"window.location.replace('manageAttendance.php?activityID=$activityID');";
        echo '</script>';
    }
?>
    <div class="myprofile-container" >
        <h1 class='DamnTitle'>Record Activity Attendance</h1>
    
        <?php
            $sql = "SELECT a.*,p.* FROM `activity` a LEFT JOIN `admin` p on a.adminID = p.adminID WHERE activityID = $activityID LIMIT 1";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            if(mysqli_num_rows( $result) > 0){
                $row = mysqli_fetch_array( $result, MYSQLI_ASSOC);
                $title = $row['title'];
                $details = $row['details'];
                $location = $row['location'];
                $points = $row['points'];
                $name = $row['name'];
                $time = date('j M Y, g:i A', strtotime($row['time']));
                $image = $row['image'];
                
                if(!empty($image)) {
                    $image = "<img class='web-images' src ='images/$image' >";
                    }
                else {
                    $image = "No image available";
                    }
                    echo"<div id='printcontent'><div class='attendance-body' >
                    <div class = 'card-image'>$image</div>
                    <div class='informative-attendance'>
                    <div class = 'card-title'><h3>$title</h3></div>
                    <div class = 'card-time'>Time: $time</div>
                    <div class = 'card-location'>Location: $location</div>
                    <div class = 'card-points'>Points: $points $label_points</div>
                    <div class = 'card-points'>Manager: $name</div>
                    <div class='button-attend'>
                    <button class ='manage-button'><a class ='beautiful-button'href='manageKiosk.php?activityID=$activityID' >Self-Checkin Kiosk</a></button>
                    <button class ='manage-button'><a class ='beautiful-button'href='javascript:void(0)' onclick='printcontent(&quot;printcontent&quot;)'>Print</a></button>
                    </div>    
                    </div>
                    </div>";
                    echo"<div class='activity-user'><h2>All Attendees: </h2></div>";
                    $sql = "SELECT h.*,u.*,a.* FROM `attend` h LEFT JOIN `user` u on u.userID = h.userID LEFT JOIN `activity` a on a.activityID = h.activityID WHERE h.activityID = $activityID ORDER BY attendID DESC";
                    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));
                    $total = mysqli_num_rows($result);

                    if($total > 0){
                        echo"<div class='activity-user'><p>Total: $total</p>";
                        echo "<table class='table-container' border='1' cellspacing='0'>
                                <tr>
                                <th width='20'>No.</th>
                                <th>Name</th>
                                <th width='200'>Time Checked In</th>
                                <th width='100'>Attendance status</th>
                                <th width='200'>Action</th>
                                </tr>";
                        $counter = 1;
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            $attendID = $row['attendID'];
                            $userID = $row['userID'];
                            $Username = $row['name'];
                            $time = date('j M Y, g:i A', strtotime($row['time']));
                            $status = $row['status'];

                            if($status == 'attend'){
                                $status_text = 'Attended';
                            }
                            elseif($status == 'absent'){
                                $status_text = 'Absent';
                            }
                            else{
                                $status_text = 'Not Confirm';
                            }
                            echo "<tr><td>$counter</td>
                                    <td>$Username ($userID)</td>
                                    <td>$time</td>
                                    <td>$status_text</td>
                                    <td><a href='?activityID=$activityID&attendID=$attendID&action=attend'>Attend</a>
                                        <a href='?activityID=$activityID&attendID=$attendID&action=absent'>Absent</a>
                                        <a href='javascript:void(0)' onclick='deletethis($attendID)'>Delete</a>
                                        </td></tr>";
                                    $counter++;
                                 
                        }
                        echo"</table></div>";
                    }
                    else{
                        echo "No attendees yet";
                    }
                    
            }
            else{
                        echo "There's no such activity.";
                    }
        ?>
</div>
<script>
            function deletethis(val) {
    if (confirm("Confirm") == true) {
        window.location.replace(window.location.href + '&action=delete&attendID=' + val);
    }
}

        </script>


<div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
</body>
</html>