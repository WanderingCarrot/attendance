<?php include("inc_settings.php") ?>
        <link rel="stylesheet" href="style.css">
        <style>
    * {
        font-size: <?php echo $fontsize; ?>px;
    }
    .navbar li a{
    font-size: <?php echo $fontsize + 4; ?>px;
    }

    .webpage-beautiful-title {
        font-size: <?php echo $fontsize + 2; ?>px;
    }

    .webpage-beautiful-a {
        font-size: <?php echo $fontsize +1; ?>px;
    }

    .login_card .log-in-title,
    .input-names,
    .Login-button,
    .webpage-beautiful-selector,
    .signup-button,
    .beautiful-activity-card,
    #input-name,
    .manage-button a,
    .manage-pfp {
        font-size: <?php echo $fontsize; ?>px;
    }

    .signup_card .sign-up-title,
    .web-beautiful-button,
    .notification-box h1,
    .activity-user h2,
    .user-info #name,
    .user-info #groups{
        font-size: <?php echo $fontsize + 4; ?>px;
    }

    .display-title,
    .details,
    .name p,
    .profile-title {
        font-size: <?php echo $fontsize + 8; ?>px;
    }

    .time {
        font-size: <?php echo $fontsize - 3; ?>px;
    }

    .location {
        font-size: <?php echo $fontsize - 2; ?>px;
    }

    .back-button,
    .label-edit,
    .notification-box p,
    .notification-button a,
    .activity-user p{
        font-size: <?php echo $fontsize - 1; ?>px;
    }

    .informative,
    .manage-cards,
    .total-manage{
        font-size: <?php echo $fontsize - 4; ?>px;
    }
    footer p{
        font-size: <?php echo $fontsize - 1; ?>px;
    }

</style>

        <div class="header">
            <!-- Navbar for the website -->
            <ul class='navbar'>
                <div class="left-nav">
                <li class='logo'><a href='index.php'><img src='./images/insect spider (2).png' alt='logoimg'></a></li>
                </div>
                <div class="right-nav">
                <li class='button'><a href='index.php'>Home</a></li>

                <?php
                # The following if statements will be executed after the requirements are fulfilled
                if ($level == 'visitor') {
                    echo "
                <li class ='button'><a href='activity.php'>All Activities</a></li>
                <li class ='button'><a href='login.php'>Log In</a></li>
                <li class ='button'><a href='signup.php'>Sign Up</a></li>
            ";
                    }
                if ($level == 'user') {
                    echo "
                <li class ='button'><a href='activity.php'>All Activities</a></li>
                <li class ='button'><a href='user_profile.php'>My Profile</a></li>
            ";
                    }
                if ($level == 'admin') {
                    echo "
                <li class ='button'><a href='manageActivity.php'>Manage Activities</a></li>
                <li class ='button'><a href='manageUser.php'>Manage Users</a></li>
                <li class ='button'><a href='manageGroups.php'>Manage $label_groups</a></li>
                <li class ='button'><a href='manageData.php'>Import Data</a></li>
            ";
                    }
                    # The Log Out button will be displayed after the user/admin logs in
                if($level != 'visitor'){
                    echo"<li class = 'button'><p><a href='logout.php'>Log Out</a>
                    </p></li>";
                }
                ?>
                </div>
                </ul>
            </div>
    

