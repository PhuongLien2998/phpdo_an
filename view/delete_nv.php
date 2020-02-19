<?php
session_start();

include_once '../config/myConfig.php';
if (isset($_POST['del']) ) {
    $id = $_SESSION["idnv"];
    
    $lido =$_POST['lido'];
    $sql1 = "UPDATE tbl_nhanvien
            SET mota = '$lido'
            WHERE  id_nhanvien = '$id'";
    $query1 = mysqli_query($conn, $sql1);
    $sql2 = "UPDATE tbl_taikhoan
            SET status = 0
            WHERE  id_nv = '$id'";
    $query = mysqli_query($conn, $sql2);
    
    header("Location: ../index.php?page=list_staff");
}
?>