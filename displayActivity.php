<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spydy</title>
        <script type="text/javascript">
            //FUNCTION: ERROR GETTING ACTIVITYID
            function CallActivity() {
                alert("An activity ID is needed ");
                window.location.replace('activity.php');
            }
        </script>
    </head>

    <body>
                <?php include("inc_header.php") ?>


        <div class='content' id='printcontent'>
            <?php

            # Getting the session ID
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                } else {
                echo '<script type="text/javascript">',
                    'CallActivity();',
                    '</script>';
                die();
                }
                
            $sql = "SELECT * FROM `activity` WHERE `activityID` = '$id' LIMIT 1";
            $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

            # If the activity is found, display the information of the activity
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $id = $row['activityID'];
                $title = $row['title'];
                $detail = $row['details'];
                $location = $row['location'];
                $time = date('j M Y,g:i A', strtotime($row['time']));
                }

            if (checktime($row['time'])) {
                $attend_button = "<button class = 'web-button' type='button'><a class= 'web-beautiful-button' href='attend_activity.php?id=$id&action=add'>Participate</a></button>";
                } else {
                $attend_button = "This activity has already ended";
                }

            $image = $row['image'];
            if (!empty($image)) {
                $image = "<img class='web-images' src='images/$image'>";
                } else {
                $image = "No image";
                }

                # Card section
            echo "<div class='display_card'>
                    <h1 class='display-title'>$title</h1>
                    <div class='image-holder'>$image<br></div>
                    <div class='display-info'>
                    <p class='details'>$detail</p>
                    <p class='time'><b>Time</b>: $time</p>
                    <p class='location'><b>Location</b>: $location</p>
                    </div>
                    <div class='display-button'>$attend_button</div>
                </div>";
            ?><button class="back-button" onclick='history.back()'>Back</button>
            
        </div>
    </body>
    <link rel="stylesheet" href="style.css">

</html>