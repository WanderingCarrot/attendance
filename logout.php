<?php
# Continue user session
session_start();
# Remove all variables from the session
session_unset();
# Remove user session
session_destroy();

?>
<script>
    // Display message when user is logged out successfully.
    alert("You've successfully Log Out.");
    window.location.replace('index.php');
</script>