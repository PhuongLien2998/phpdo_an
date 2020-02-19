<?php
session_start();
include_once '../config/myConfig.php';
if (isset($_POST['Update_acount']) ) {
    $Name = $_POST['Name'];
    $Cmt = $_POST['Cmt'];
    $Birth = $_POST['Birth'];
    $Phone = $_POST['Phone'];
    $energy = $_POST['energy'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $error = '';
    $date = date('Y-m-d');
    $id = $_SESSION["id_ql"];

    //xu ly them

    $sql = "UPDATE tbl_nhanvien 
            SET sdt_nhanvien = '$Phone', email_nhanvien = '$Email', thecancuoc = '$Cmt', gioitinh = $energy,
                diachi_nhanvien = '$Address', ten_nhanvien = '$Name', ngaysinh = '$Birth'
            WHERE  id_nhanvien = '$id'";
    $query = mysqli_query($conn, $sql);

    $sql2 = "UPDATE tbl_taikhoan
            SET username = '$Email'
            WHERE  id_nv = '$id' ";
    $query2 = mysqli_query($conn, $sql2);
     if($query2!==false&&$query!==false){
        echo "<script>alert('Sửa thông tin thành công!');
        window.location=\"../index.php?page=info_acount&id=$id\" ;
        </script>";
    }else{
        echo "<p style='color: red;'>Sửa không thành công!</p>";
    }

}
?>