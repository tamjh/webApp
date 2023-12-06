<?php

function update_info($conn){
    if(isset($_POST['edit_stock'])){
        $id = $_POST['edit_id'];
        $inventory = $_POST['stock'];
    
        $query = "UPDATE books SET inventory='$inventory' WHERE id=$id";
        $query_run = mysqli_query($conn, $query);
    
        if($query_run){
            echo "<script>alert('Stock updated successfully!')</script>";
            header('Location: inventory.php');
        }
        else{
            echo "<script>alert('Stock updated failure!')</script>";
            header('Location: inventory.php');
        }
    }
}




?>