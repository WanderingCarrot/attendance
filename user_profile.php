<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
    </head>
    <script>
        //FUNCTION :Successfully Updated Profile Picture
        function uploadsuc() {
            alert("You've successfully uploaded the image!");
            window.location.replace('user_profile.php');
        }
        //FUNCTION :Successfully Removed Profile Picture
        function removalsuc() {
            alert("You've successfully removed the image!");
            window.location.replace('user_profile.php');
        }
        //FUNCTION :No image to be removed
        function ErrorMsg1() {
            alert("There are no image to remove!");
        }
        //FUNCTION :Invalid File
        function ErrorMsg2() {
            alert("Failed to upload file!");
        }
        //FUNCTION :Invalid File
        function ErrorMsg3() {
            alert("Invalid file format!");
        }
        //FUNCTION: Hovering the profile picture to make it a qr code.
        function hoverImg(elementId, defaultImage, hoverImage) {
            const image = document.getElementById(elementId);

            image.addEventListener("mouseenter", function () {
                image.src = hoverImage;
            });

            image.addEventListener("mouseleave", function () {
                image.src = defaultImage;
            });
        }</script>

    <body>
        <div class="header">
            <?php include('inc_header.php'); ?>
        </div>
        <div class="myprofile-container" id='printcontent'>
            <?php
            checklevel('user-admin');
            $edit_data = 0;

            # Get user ID
            if ($level == 'user') {
                $userID = $_SESSION['userID'];

                } elseif (isset($_GET['userID'])) {
                $userID = $_GET['userID'];
                
                } else {
                echo "<script>alert('Parameter for $level isn't complete.');
              window.location.replace('manage_user.php');
              </script>";
                }

            $sql = "SELECT `user`.*, `group`.`groupName` FROM `user` LEFT JOIN `group` ON `group`.groupID = `user`.groupID WHERE `user`.userID = '$userID' LIMIT 1";
            $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

            # Get all users participated activities
            $sqlAct = "SELECT * FROM  `attend` h LEFT JOIN `activity` a on a.activityID=h.activityID WHERE  h.userID='$userID'";
            $resultAct = mysqli_query($db, $sqlAct) or die("<pre>$sql</pre>" . mysqli_error($db));

            # If activity found, display activity
            $total = mysqli_num_rows($resultAct);

            # If user found, display user information
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $userID = $row["userID"];
                $name = $row['name'];
                $group = $row['groupName'];
                $image = $row['image'];

                if (isset($_FILES['file']) && file_exists($_FILES['file']['tmp_name'])) {
                    $file = $_FILES['file'];
                    $fileSize = $file['size'];
                    $fileTmp = $file['tmp_name'];
                    $fileName = explode('.', $file['name']);
                    $fileExt = strtolower(end($fileName));

                    # System will only accept these image files.
                    $ext = array('jpeg', 'jpg', 'png', 'pdf', 'gif');

                    if (in_array($fileExt, $ext)) {
                        $location = __DIR__ . '/images/';

                        if (!empty($image) && $image !== $defaultImage && file_exists($location . $image)) {
                            unlink($location . $image);
                            }
                        $newpname = strtotime('now') . '.' . $fileExt;

                        if (move_uploaded_file($fileTmp, $location . $newpname)) {
                            $image = $newpname;

                            $sql = "UPDATE `user` SET `image` = '$image' WHERE `userID` = '$userID'";
                            $result = mysqli_query($db, $sql);

                            if (!$result) {
                                die("Error updating image: " . mysqli_error($db));
                                } else {
                                echo '<script>',
                                    'uploadsuc();',
                                    '</script>';
                                }
                            } else {
                            echo '<script>',
                                'ErrorMsg2();',
                                '</script>';
                            }
                        } else {
                        echo '<script>',
                            'ErrorMsg3();',
                            '</script>';
                        }
                    }
                    # Remove Image
                if (isset($_POST['remove'])) {
                    $location = __DIR__ . '/images/';

                    if (!empty($image) && $image !== $defaultImage && file_exists($location . $image)) {
                        unlink($location . $image);

                        $sql = "UPDATE `user` SET `image` = '$defaultImage' WHERE userID = '$userID'";
                        $result = mysqli_query($db, $sql);

                        if (!$result) {
                            die("Error removing image: " . mysqli_error($db));
                            } else {
                            echo '<script>',
                                'removalsuc();',
                                '</script>';
                            }
                        } else {
                        echo '<script>',
                            'ErrorMsg1();',
                            '</script>';
                        }
                    }
                    # If theres no image for the user, it will be a default image
                if (empty($image)) {
                    $image = $defaultImage;
                    }
                echo "<div class='profile-content'>
                <div class='user-info'>
                <h1 class='profile-title'>My Profile</h1>
                <p id='name'>Name: $name</p>
                <p id='groups'>$label_groups: $group</p>
                </div>";
                echo "<div class='profile-func'>
            <img class='profile-pic' id='profile-pic' src ='images/$image' >";
                echo '<script>';
                echo 'hoverImg("profile-pic", "images/' . $image . '", "https://api.qrserver.com/v1/create-qr-code/?data=' . $userID . '");';
                echo '</script>';
                echo "<form method='post' enctype='multipart/form-data'>
                <div class='file-container'>
                <input type='file' id='file-input' name='file'>
                <label id='file-input-label' for='file-input'>Select a File</label>
                    <button class='upload-button' type='submit' name='submit'>UPLOAD</button>
                    <button class='upload-button' type='submit' name='remove'>REMOVE</button></div>
                </form>
                </div>
                </div>";
                } else {
                echo "User Not Found!";
                }
            echo "<div class='activity-user'><h2>All attended activities: </h2></div>";
            if ($total > 0) {
                echo "<div class='activity-user'><p>Activities participated: $total</p>";
                echo "<p>* Points are only assigned for confirmed attendance.</p></div>";
                echo "<table class='table-container' border='1' cellspacing='0'>
                <tr>
                <th width='20'>No.</th>
                <th>Activity</th>
                <th width='200'>Time</th>
                <th width='60'>$label_points</th>
                </tr>";
                $counter = 1;
                $totalpoints = 0;
                while ($row = mysqli_fetch_array($resultAct, MYSQLI_ASSOC)) {

                    $activityID = $row['activityID'];
                    $title = $row['title'];
                    $status = $row['status'];
                    $time = date('j M Y, g:i A', strtotime($row['time']));

                    if ($status == 'attend') {
                        $points = $row['points'];
                        $totalpoints = $totalpoints + $points;
                        } else {
                        $points = '-';
                        }
                    echo "<tr>
                    <td>$counter.</td>
                    <td><a href='displayActivity.php?id=$activityID'>$title</a></td>
                    <td>$time</td>
                    <td align='center'>$points</td>
                    </tr>";
                    $counter += 1;
                    }
                echo "<td colspan='3' align='right'><b>Total $label_points</b></td>
            <td>$totalpoints</td></table>";
                } else {
                echo "<p style='color: #d1e8e2; margin: 40px; font-size: 18px;'>No activity attended!</p>";
                }
            if ($level !== 'user') {
                echo "<button class='back-button' onclick='history.back()'>Back</button>";
                }
            ?>
            <script>
                function deletethis(val) {
                    //Asking the admin to confirm deletion
                    if (confirm("Confirm") == true) {
                        window.location.replace("manageActivity.php?delete=" + val);
                    }
                }

            </script>
        </div>

        <div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
    </body>

</html>