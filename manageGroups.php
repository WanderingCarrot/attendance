<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Management</title>
</head>
<script>
    function removesuc(){
        alert("You have successfully removed a group!");
        window.location.replace("manageGroups.php");
    }
</script>
<body>
    <div class="header"><?php include('inc_header.php');?></div>
    <div class="content" id='printcontent'>
    <?php
        checklevel('admin');
        if(isset($_GET['delete'])){
            $groupID = $_GET['delete'];
            $sql = "DELETE FROM `group` WHERE  groupID = '$groupID'";
            $result = mysqli_query($db,$sql)OR die("<pre>$sql</pre>" . mysqli_error($db));
            echo'<script>',
            'removesuc();',
            '</script>';
            die();
        }    
    ?>
    <h1 class="DamnTitle">Manage <?php echo $label_groups?></h1>
    
    <?php
        $sql = "SELECT `group`.*, COUNT(`user`.userID) as totaluser FROM  `group` LEFT JOIN `user` ON `user`.groupID = `group`.groupID GROUP BY  `group`.groupID ORDER BY `group`.groupName";
        $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>". mysqli_error($db));
        $total = mysqli_num_rows($result);

        if($total> 0){
            echo"<h2 class='total-manage'>Total: $total</h2>";
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $id = $row['groupID'];
                $name = $row['groupName'];
                $totaluser = $row['totaluser'];

                echo"<div class='managing-group-cards' ><div class='manage-cards'>
                <div class='information'>$label_groups Name: $name ( $totaluser Users )</div>
                <button class='manage-button'><a href='manageGroup_form.php?id=$id'>Edit</a></button>
                <button class='manage-button'><a href='javascript:void(0);' onclick='deletethis($id)'>Delete</a></button>
                </div></div>";
            }
        }else{
            echo "No records of $label_groups.";
        }
        
        ?>
        <script>
            function deletethis(val){
                if(confirm('Confirm') == true){
                    window.location.replace('manageGroups.php?delete='+val)
                }
            }
        </script>
    
<button class='web-button'><a class='web-beautiful-button' href='manageGroup_form.php'>Add <?php echo $label_groups?></a></button></div>
<div class = "footer"><?php include('inc_footer.php')?></div>
</body>
</html>