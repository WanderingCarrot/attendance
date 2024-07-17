<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spydy</title>
    </head>

    <body>
    <?php include("inc_header.php"); ?>

    <?php
        if($level == 'visitor'){
            echo"<div class='notification-box'><div class='notification-left'>
                    <h1 class='notification-text'>HELLO!</h1>
                    <p>Welcome to Spydy Attendance System!</br> Don't have an account? Click the Sign Up button!</p></div>
                    <div class='notification-right'>
                    <button class= 'notification-button'><a href='signup.php'>Sign Up</a></button>
                    </div></div>
                    ";
                }
        if($level != 'visitor'){
            $name = $_SESSION['name']; # Fetching username
        echo"<div class='name'><p>Hi, $name ( $level )</p><br></div>";
        }
        ?> 
    <div class='content' id = 'printcontent'>
            <h2 class='Title'>Newest Activities</h2>
            <div class='cards'>
                <?php
                # Fetching the newest activities to display
                $sql = "SELECT * FROM activity
                        ORDER BY activityID DESC LIMIT 4";
                $result = mysqli_query($db, $sql) or die('<pre>$sql</pre>' . mysqli_error($db));

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['activityID'];
                        $title = $row['title'];
                        $image = $row['image'];
                        $detail = $row['details'];

                        if (!empty($image)) {
                            $img = "<img class = 'web-images' src = 'images/$image' >";
                            } else {
                            $img = "No image available";
                            }
                        echo "<div class='activity-card'>
                                <div class='image-holder'>$img</div>
                                <h3 class ='webpage-beautiful-title'>$title</h3>
                                <button class= 'card-button' type='button'><a class='webpage-beautiful-a' href='displayActivity.php?id=$id'>Learn More<a></button>
                            </div>
                            </div>"; # Displaying content

                        }
                    }
                    
                ?>
            </div>
            <div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
    </body>
</html>