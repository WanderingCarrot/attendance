<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Import Data</title>
        <script>
            function PlsChooseAFile() {
                alert("Please choose a file for import");
                window.location.replace("manageData.php");
            }
        </script>
    </head>

    <body>
        <div class="header">
            <?php include ('inc_header.php'); ?>
        </div>
        <div class='content' id='printcontent'>
            <?php
            checklevel('admin');

            if (isset ($_FILES['import'])) {
                if (!file_exists($_FILES['import']['tmp_name'])) {
                    echo '<script>',
                        'PlsChooseAFile();',
                        '</script>';
                    }
                $counter = 0;
                $file = fopen($_FILES['import']['tmp_name'], 'rb');
                if ($_POST['type'] == 'user') {
                    while (($line = fgetcsv($file, 50, ",")) !== FALSE) {
                        if (count($line) == 4) {
                            $userID = trim($line[0]);
                            $password = trim($line[1]);
                            $name = trim($line[2]);
                            $groupID = trim($line[3]);

                            $sql = "INSERT IGNORE INTO `user`(`userID`,`password`,`name`,`groupID`) VALUES ('$userID','$password','$name','$groupID')";
                            $result = mysqli_query($db, $sql) or die ("<pre>$sql</pre>" . mysqli_error($db));
                            $counter += 1;
                            }
                        }
                    } else {
                    while (($line = fgetcsv($file, 50, ",")) !== FALSE) {
                        $groupName = trim($line[0]);
                        if (!empty ($groupName) && count($line) == 1) {
                            $sql = "INSERT IGNORE INTO `group`(`groupName`) VALUES ('$groupName')";
                            $result = mysqli_query($db, $sql) or die ("<pre>$sql</pre>" . mysqli_error($db));
                            $counter += 1;
                            }
                        }
                    }

                fclose($file);
                echo "<script>alert('Creating $counter record files.');
                        window.location.replace('manageData.php');</script>";
                }
            ?>

            <h2 class='DamnTitle' style="text-align: center; margin-block: 20px;">Import Data</h2>
            <div class='cards'>
                <div class='manage-cards'>
                    <div class='information' style="font-size: 20px;">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="radio" id="user" name="type" value="user" required>
                            <label for="user">User</label></br></br>
                            <input type="radio" id="group" name="type" value="group" required>
                            <label for="group">Group</label></br></br>
                            <label for="import">Please Choose a file for import(.csv only)</label></br></br>
                            <label id='file-input-label' for='file-input'>Select a File</label>
                            <input type='file' id='file-input' name='import'><br><br>

                            <input class="manage-button" type="submit" value="Import Data"
                                   style="color:#d1e8e2; font-size: 20px;">

                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class='footer'>
                <?php include ("inc_footer.php") ?>
            </div>
    </body>

</html>