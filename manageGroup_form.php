<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Group Management</title>
        <script>
            function ErrorMsg1(){
                alert("ID not found!");
            }
            function SuccessMsg1(){
                alert('Saved!');
                window.location.replace('manageGroups.php');
            }
        </script>
    </head>

    <body>
        <div class="header">
            <?php include('inc_header.php'); ?>
        </div>
        <?php
        checklevel('admin');
        $edit_data = 0;
        $name = "";

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $sql = "SELECT * FROM `group` WHERE groupID = $id LIMIT 1";
            $result = mysqli_query($db,$sql)OR die("<pre>$sql</pre>.". mysqli_error($db));

            if (mysqli_num_rows($result) > 0) {
                $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $name = $edit_data["name"];
            }else{
                echo'<script>',
                'ErrorMsg1();',
                '</script>';
            }
        }
        if (isset($_POST['name']) && !empty($_POST['name'])){
            $name = mysqli_real_escape_string($db, $_POST['name']);
            if($edit_data){
                $sql = "UPDATE IGNORE `group` SET `groupName`='$name' WHERE groupID=$id";
            }else{
                $sql = "INSERT IGNORE INTO `group`(groupName) VALUES('$name')";
            }
            $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>". mysqli_error($db));
            echo'<script>',
                'SuccessMsg1();',
                '</script>';
        }
        ?>
        <div class='content' id='printcontent'>
            <div class='manage-cards'>
        <form class='manage-form' method="POST" action="">
        <label class='label-edit' for='name'>Name of <?php echo $label_groups ?></label>
        <input  type='text' name='name' id='input-name' value='<?php echo $name?>'>
        <button class='upload-button' type='submit' name='submit'>Save</button>
    </form>
    </div>
    <button class="back-button" onclick='history.back()'>Back</button>
</div>
        <div class="footer">
            <?php include('inc_footer.php') ?>
        </div>
    </body>

</html>