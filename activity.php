<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
</head>
<body>
    <div><?php include('inc_header.php')?></div>
    <?php 
    # v Search Bar here v
        $input_a = '';
        $q = '';

        if(isset($_POST['search'])){
            $input_a = $_POST['input_a'];
            if(!empty($input_a)){
                $q .= "WHERE activity.title LIKE '%$input_a%'";
            }
        }
    ?>
    <!--Content-->
    <div class="activity-body" id='printcontent'>
    <h2 class ='DamnTitle'>All Activities</h2>
    <form method="POST" action="">
        <input class= 'searchbox' type='text' name='input_a' value = '<?php echo $input_a?>'placeholder = 'Activity Name'>
        <input class='submit_button' type="submit" name='search' value='Find'>
        <input class = 'submit_button' type="submit" name='reset' value='Reset'> 
    </form>
        <div class="beautiful-cards">
            <?php 
            # Get all activities or display the search of user.
            $sql = "SELECT * FROM `activity` $q ORDER BY activityID DESC";
            $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $id = $row['activityID'];
                    $title = $row['title'];
                    $location = $row['location'];
                    $points = $row['points'];
                    $time = date("j M Y, g:i A", strtotime($row['time']));
                    $image = $row['image'];

                    if(!empty($image)){
                        $img = "<img class = 'web-images' src = 'images/$image'>";
                    }
                    else{
                        $img = "No image available";
                    }
                echo "<div class='beautiful-activity-card'>
                    <div class = 'card-image'>$img</div>
                    <div class='informative'>
                    <div class = 'card-title'><h3>$title</h3></div>
                    <div class = 'card-time'>Time: $time</div>
                    <div class = 'card-location'>Location: $location</div>
                    <div class = 'card-points'>Points: $points $label_points</div>
                    </div>
                    <button class ='card-button'><a class ='beautiful-button'href='displayActivity.php?id=$id'>Learn More</a></button>
                </div>";
                }
        }
            ?>
        </div>
        
</div>
<div class='footer'>
            <?php include("inc_footer.php") ?>
        </div>
</body>
</html>
