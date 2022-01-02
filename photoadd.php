<?php
    include 'db_connect.php';
				
                $con = mysqli_connect("localhost", "root", "", "forum_db");
        
                if (isset($_POST['upload'])) {
                    $file = $_FILES['img']['name'];
        
                    $query = "INSERT INTO topics(img) VALUES(:img)";
        
                    $res = mysqli_query($con,$query);
        
                    if ($res)	{
                        move_uploaded_file($_FILES['img']['tmp_name'], "$file");
                    }
                }

        header('location: manage_topic.php');

        ?>