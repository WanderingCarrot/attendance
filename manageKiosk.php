<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Self-CheckIn</title>
    </head>

    <body>
        <div class="header">
            <?php include('inc_header.php'); ?>
        </div>
        <script>
            function ErrorMsg1() {
                alert("ID needed!");
                window.location.replace('manageActivity.php');
            }
            function ErrorMsg2() {
                alert("Failed to find activity.");
                window.location.replace('manageActivity.php');
            }
        </script>
        <?php
        checklevel("admin");

        $refresh = "";
        if (isset($_GET['activityID'])) {
            $activityID = $_GET['activityID'];
            } else {
            echo '<script>',
                'ErrorMsg1();',
                '</script>';
            }
        if (isset($_POST['userID'])) {
            $userID = $_POST['userID'];
            $message = "";
            $sql = "SELECT * FROM `attend` WHERE activityID = '$activityID' AND userID = '$userID' LIMIT 1";
            $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $attendID = $row['attendID'];

                if ($row['status'] == 'attend') {
                    $message = 'Attendance has been approved.';
                    } else {
                    $sql = "UPDATE `attend` SET `status` = 'attend' WHERE attendID = $attendID";
                    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
                    $message = 'Welcome! Your attendance has successfully been approved!';
                    }
                } else {
                $message = 'Your record was not found!';
                }
            $refresh = '<meta http-equiv="refresh" content="3">';
            }
        $sql = "SELECT * FROM `activity` WHERE activityID = $activityID LIMIT 1";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $title = $row['title'];
            $time = date('j M Y,g:i A', strtotime($row['time']));
            $image = $row['image'];
            if (!empty($image)) {
                $image = "<img  src ='images/$image' style='border-radius: 24px; margin-block: 40px;'>";
                } else {
                $image = "";
                }
            } else {
            echo '<script>',
                'ErrorMsg1();',
                '</script>';
            }

        ?>
        <div align='center' id='printcontent'>
            <h2 class='DamnTitle' style="text-align: center; margin-block: 20px;">Self-CheckIn-Kiosk</h2>
            <hr>
            <?php echo $image ?>
            <p style='font-size: 30px; color: #d1e8e2; margin: 20px;'>
                <b style='font-size: 50px;  font-weight: bolder;'>
                    <?php echo $title ?>
                </b></br>
                Starting Time:
                <?php echo $time ?>
            </p>
            <hr>
            <p>Key-In your ID to CHECK-IN</p>
            <form method='POST' action="">
                <input type="text" name="userID" value='' placeholder='User ID' autofocus autocomplete="off"
                       style="width: 300px; height: auto; font-size: 24px;"></br></br>
                <input class='manage-button' type="submit" name="submit" value="Check In" style="color: #d1e8e2; font-size: 24px;">
            </form>

            <?php
            if(!empty($message)) {
                echo "<h1 style='font-size: 24px; color: #38a154;'>$message</h1>";
            }
            ?>
        </div>
    </body>
    <div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
</html>