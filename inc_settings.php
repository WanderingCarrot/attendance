<?php
# Database informations
$dbname = 'projectSK';
$dbuser = 'root';
$dbpass = 'Wooijunlol1@'; #This should be empty string, but I have a password for MySQL.
$dbhost = 'localhost';

# Connect to database
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die(mysqli_connect_error());

$defaultImage = 'defpfp.png'; # Default image of the profile picture for user.
$label_groups = "Department"; # Group label
$label_points = 'points'; # Reward label

# Starting session
session_start();
# Session for user, identify the access of one page.
if (!isset($_SESSION['userID'])) {
    $_SESSION['level'] = 'visitor'; 
    }
$level = $_SESSION['level'];


$base_font_size_px = 16; // This is just an example, use your actual base font size in pixels

// Check if a font size preference is stored in the session
if (isset($_SESSION['fontsize'])) {
    $fontsize = $_SESSION['fontsize'];
} else {
    // If not stored in session, use the default font size
    $fontsize = $base_font_size_px; // Set default font size in pixels
}

// Adjust the font size based on the query parameter
if (isset($_GET['font'])) {
    if ($_GET['font'] == 'plus') {
        $fontsize += 2; // Increase font size by 2 pixels
    } elseif ($_GET['font'] == 'minus') {
        $fontsize -= 2; // Decrease font size by 2 pixels
    }
    else{
        $fontsize = $base_font_size_px;
    }
}

// Store the adjusted font size in the session
$_SESSION['fontsize'] = $fontsize;

# FUNCTION: Checking if the time is over for a specific event.
function checktime($time)
    {
    if (strtotime('now') < strtotime($time)) {
        return true;
        } else {
        return false;
        }
    }

    # FUNCTION: Checking the users level to access a specific session
    function checklevel($access){
        $level = $_SESSION['level'];
        $error = '';
        if($level == 'visitor'){
            $error = 'You need to Log In to access this page.';
        }
        elseif($level == 'user' && $access == 'admin'){
            $error = 'Only admin accounts can access this page.';
        }
        elseif($level == 'admin' && $access == 'user'){
            $error = 'Only normal users can access this page';
        }

        if(!empty($error)){
            echo "<script>alert('$error');
            window.location.replace('index.php');
            </script>";
            die();
        }
    }


