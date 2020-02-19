<?php
	if(session_id() == ''){
		session_start();
	}
	$conn = mysqli_connect("localhost","thehuy_cskh","thehuy","thehuy_cskh");
    $id = $_GET["id"];
    $sql3 = "UPDATE tbl_taikhoan
            SET status = 1
            WHERE  id_nv = '$id' ";
    $query = mysqli_query($conn, $sql3);
     $sql1 = "UPDATE tbl_nhanvien
            SET mota = ''
            WHERE  id_nhanvien = '$id'";
    $query1 = mysqli_query($conn, $sql1);
    echo "<script>alert('Mở khóa thành công!');
                    window.location=\"index.php?page=list_staffblock \" ;
                    </script>";
	// header("Location: ../CODE/index.php?page=list_staffblock");
?>