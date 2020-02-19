<?php
if (session_id() == ''){
        session_start();
    }
include_once 'config/myConfig.php';
if (isset($_GET['id'])) {
        $id = $_GET['id'];  
        $sqlSelec = "SELECT
                        *
                    FROM
                        tbl_nhanvien,tbl_chinhanh
                    WHERE
                    tbl_nhanvien.id_chinhanh = tbl_chinhanh.id_chinhanh
                    AND
                       id_nhanvien = '$id' ";
        $querySelec = mysqli_query($conn, $sqlSelec);
        $rowSelec = mysqli_fetch_array($querySelec);
    
        $tcc = $rowSelec['thecancuoc'];
        $sdt = $rowSelec['sdt_nhanvien'];
        $email = $rowSelec['email_nhanvien'];

        $sqlcn = 'SELECT
        *
        FROM
        tbl_chinhanh ';
    
    $querycn = mysqli_query($conn, $sqlcn);
    }
if (isset($_POST['edit_staff']) ) { 
    $Name = $_POST['Name'];
    $Cmt = $_POST['Cmt'];
    $Birth = $_POST['Birth'];
    $Phone = $_POST['Phone'];
    $energy = $_POST['energy'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];

    $error = 0;
    $date = date('Y-m-d');
     $regexName = '/^[^\d+]*[\d+]{0}[^\d+]*$/';
    $regexCmt = '/^\d+$/';
    $regexPhone = '/^\d+$/';
    $regexEmail = '/\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,6}\b/i';
   // check ten
    if($Name == ""){
            $eror_Name = "Họ tên không được để trống!";
            $error ++;
            //echo "ht k dc de trong";
    }
    else if (preg_match($regexName, $Name) == 0) {
            $eror_Name = "Họ tên không hợp lệ!";
            $error ++;
            //echo "ko hop le ten";
            // $Name = "";
    }
    //check cmt
    if($tcc!= $Cmt){
        if($Cmt == ""){
            $eror_Cmt = "Chứng minh thư không được để trống!";
            $error ++;
        }
        else if (preg_match($regexCmt, $Cmt) == 0) {
            $eror_Cmt = "Chứng minh thư không hợp lệ!";
            $error ++;
            // $Cmt = "";
        }
        else if(check_cmt($Cmt)==1){
            $eror_Cmt = "Chứng minh thư Đã tồn tại!";
            $error ++;
            // $Cmt = "";
        }
    }else if($Cmt == ""){
            $eror_Cmt = "Chứng minh thư không được để trống!";
            $error ++;
        }
    
    //check Birrth
    if($Birth == ""){
            $eror_Birth = "Ngày sinh không được để trống!";
            $error ++;
    }
    // check phone
    if($sdt!=$Phone){
        if($Phone == ""){
            $eror_Phone = "Số điện thoại không được để trống!";
            $error ++;
        }
        else if (!preg_match($regexPhone, $Phone)) {
            $eror_Phone = "Số điện thoại không hợp lệ!";
            $error ++;
            // $Phone = "";
        }
        else if(check_phone($Phone)==1){
            $eror_Phone = "Số điện thoại đã tồn tại!";
            $error ++;
            // $Phone = "";
        }
    }else if($Phone == ""){
            $eror_Phone = "Số điện thoại không được để trống!";
            $error ++;
        }
   
    // check energy
    // check Email
     if($email!= $Email){
        if($Email == ""){
            $eror_Email = "Email không được để trống!";
            $error ++;
        }
        else if (preg_match($regexCmt, $Email) == 0) {
            $eror_Email = "Email không hợp lệ!";
            $error ++;
            // $Email = "";
        }
        else if(check_cmt($Email)==1){
            $eror_Email = "Email Đã tồn tại!";
            $error ++;
            // $Cmt = "";
        }
    }else if($Email == ""){
            $eror_Email = "Email không được để trống!";
            $error ++;
        }
 
    
       
    if($error == 0){
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
        window.location=\"index.php?page=info_staff&id=$id\" ;
        </script>";
    }else{
        echo "<p style='color: red;'>Sửa không thành công!</p>";
    }
}

}

   function check_phone($phone){
     global $conn;
        $sqlCheck = "SELECT sdt_nhanvien FROM tbl_nhanvien WHERE
                  sdt_khachhang = '$phone'";
    $queryCheck = mysqli_query($conn, $sqlCheck);
    return mysqli_num_rows( $queryCheck);
    }

    function check_tcc($cmt){
         global $conn;
       $sqlCheck2 = "SELECT thecancuoc FROM tbl_nhanvien WHERE
                   thecancuoc = '$cmt' ";
    $queryCheck2 = mysqli_query($conn, $sqlCheck2);
    return mysqli_num_rows($queryCheck2);
    }
    function check_mail($email){
         global $conn;
       $sqlCheck3 = "SELECT email_nhanvien FROM tbl_nhanvien WHERE
                   thecancuoc = '$email' ";
    $queryCheck3 = mysqli_query($conn, $sqlCheck3);
    return mysqli_num_rows($queryCheck3);
    }

    
?> 


<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top: 10px"> <h3>THÔNG TIN NHÂN VIÊN</h3></div>
        
        <div class="col-md-3">
            <img style="width: 150px; height: 150px" src="../images/anhnv/<?php echo $rowSelec['anh_nhanvien'] ?> ">
            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="view/update_img.php" >
                <label for="img" class=" control-label">Sửa Ảnh đại diện</label>
                <input type="file" class="" name="img" id="img" placeholder="Ảnh">
                <input type="submit" class="" name="submit" >
            </form>
        </div>
        <div class="col-md-9">
             <form class="form-horizontal" role="form" method="POST" action="">
                <div class="form-group">
                    <label for="Name" class="col-sm-10 control-label">Mã nhân viên : <?php echo $rowSelec['id_nhanvien']; ?></label>
                </div>
               
                <div class="form-group">
                    <label for="Name" class="col-sm-10 control-label">Họ và Tên <span style="color: red;"><?php if(isset($eror_Name)){ echo $eror_Name; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $rowSelec['ten_nhanvien']; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="Cmt" class="col-sm-10 control-label">Thẻ căn cước <span style="color: red;"><?php if(isset($eror_Cmt)){ echo $eror_Cmt; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Cmt" id="Cmt" value="<?php echo $rowSelec['thecancuoc']; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="Birth" class="col-sm-10 control-label">Ngày sinh <span style="color: red;"><?php if(isset($eror_Birth)){ echo $eror_Birth; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="Birth" id="Birth" value="<?php echo $rowSelec['ngaysinh']; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="Energy" class="col-sm-10 control-label">Giới tính <span style="color: red;"><?php if(isset($eror_energy)){ echo $eror_energy; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="radio" name="energy" id="Energy" value="1" <?php if ($rowSelec['gioitinh'] ==1) echo "checked"; {
                            # code...
                        } ?> >Nam
                        <input type="radio" name="energy" id="Energy" value="0" <?php if ($rowSelec['gioitinh'] ==0) echo "checked"; {
                            # code...
                        } ?> >Nữ 
                    </div>
                </div>
                <div class="form-group">
                    <label for="Email" class="col-sm-10 control-label">Email <span style="color: red;"><?php if(isset($eror_Email)){ echo $eror_Email; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $rowSelec['email_nhanvien']; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="Phone" class="col-sm-10 control-label">Số điện thoại  <span style="color: red;"><?php if(isset($eror_Phone)){ echo $eror_Phone; } ?></span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Phone" id="Phone" value="<?php echo $rowSelec['sdt_nhanvien']; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="Address" class="col-sm-10 control-label">Địa chỉ <span style="color: red;"><?php if(isset($eror_Address)){ echo $eror_Address; } ?></span> </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Address" id="AddremyModalss" value="<?php echo $rowSelec['diachi_nhanvien']; ?>" >
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" name="edit_staff" >Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>