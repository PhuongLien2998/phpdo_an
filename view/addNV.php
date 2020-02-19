<?php
include_once 'config/myConfig.php';
if (session_id() == ''){
    session_start();
}
 $sqlcn = 'SELECT DISTINCT ten_chinhanh, id_chinhanh
                FROM
                    tbl_chinhanh';
    $querycn = mysqli_query($conn, $sqlcn);

$querycn = mysqli_query($conn, $sqlcn); // câu lênh truy vấnz
if (isset($_POST['submit']) ) {

    $Name = $_POST['Name'];
    $Cmt = $_POST['Cmt'];
    $Birth = $_POST['Birth'];
    $Phone = $_POST['Phone'];
    $Energy = $_POST['Energy'];   
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $barnd = $_SESSION['chi_ql'];
    $date = date('Y-m-d');
    $error =0;
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
    //check Birrth
    if($Birth == ""){
            $eror_Birth = "Ngày sinh không được để trống!";
            $error ++;
    }
    // check phone
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
    // check energy
    if($Energy == Null){
            $eror_energy = "Giới tính không được để trống!";
            $error ++;
    }
    // check Email
    if($Email == ""){
            $eror_Email = "Email không được để trống!";
            $error ++;
    }
    else if (!preg_match($regexEmail, $Email)) {
            $eror_Email = "Email không hợp lệ!";
            $error ++;
            // $Email = "";
    }
    else if(check_email($Email)==1){
            $eror_Email = "Email đã tồn tại!";
            $error ++;
            // $Email = "";
    }

    // check Address
     if($Address == ""){
            $eror_Address = "Địa chỉ không được để trống!";
            $error ++;
    }
    
    // check barnd
  
    if($error == 0){
    	$sql = "INSERT INTO tbl_nhanvien(ten_nhanvien, thecancuoc, ngaysinh, gioitinh, email_nhanvien, sdt_nhanvien,diachi_nhanvien, id_chinhanh)
                    VALUES('$Name','$Cmt','$Birth','$Energy', '$Email', '$Phone','$Address', '$barnd')";
        $query = mysqli_query($conn, $sql);
        var_dump($query); 
        $sql_idnv = "SELECT id_nhanvien FROM tbl_nhanvien WHERE thecancuoc = '$Cmt' ";
        $id_nv = mysqli_query($conn, $sql_idnv);
        $id_kq = -1;
        while($row_nv = mysqli_fetch_array($id_nv) ) {
            $id_kq = $row_nv['id_nhanvien'];

        }
        $pass_nvm=md5($Cmt);

        $sql2 = "INSERT INTO tbl_taikhoan(username, password,`level`, status, thoigiantao, id_nv)
                    VALUES ('$Email', '$pass_nvm',2,1,'$date', '$id_kq')";
        $query2 = mysqli_query($conn, $sql2);
        var_dump($query2);
        if ($query && $query2) {
            echo "<script>alert('Thêm thành công!');
                    window.location=\"index.php?page=list_staff \" ;
                    </script>";
        }else{
            echo "<p style='color: red;'>Thêm mới không thành công!</p>";
        }

    }
}
        
    function check_phone($phone){
        global $conn;
        $sqlCheck = "SELECT  sdt_nhanvien FROM tbl_nhanvien WHERE
                  sdt_nhanvien = '$phone' ";
        $queryCheck = mysqli_query($conn, $sqlCheck);
        return mysqli_num_rows( $queryCheck);
    }
    
     function check_cmt($cmt){
        global $conn;
        $sqlCheck2 = "SELECT thecancuoc FROM tbl_nhanvien WHERE
                   thecancuoc = '$cmt' ";
        $queryCheck2 = mysqli_query($conn, $sqlCheck2);
        return mysqli_num_rows($queryCheck2);
    }

     function check_email($email){
        global $conn;
        $sqlCheck3 ="SELECT email_nhanvien FROM tbl_nhanvien WHERE
                   email_nhanvien = '$email' ";
        $queryCheck3 = mysqli_query($conn, $sqlCheck3);
        return mysqli_num_rows($queryCheck3);
    }

    
?>


<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-5"><br>
			<span style="color: red;"><?php if(isset($eror)){ echo $eror; } ?></span>
			<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action=""  >
				<legend class="text-center"a>Thêm nhân viên </legend>
				<div class="form-group">
					<label for="Name" class="col-sm-10 control-label">Họ và Tên <span style="color: red;"><?php if(isset($eror_Name)){ echo $eror_Name; } ?></span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Name" id="Name" value="<?php if (isset($Name)) {echo $Name; } ?>" placeholder="Nhập họ và tên!" >
					</div>
				</div>
				<div class="form-group">
					<label for="Cmt" class="col-sm-10 control-label">Chứng minh thư <span style="color: red;"><?php if(isset($eror_Cmt)){ echo $eror_Cmt; } ?></span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Cmt" id="Cmt" value="<?php if (isset($Cmt)) {echo $Cmt; } ?>" placeholder="Nhập chứng minh thư!" >
					</div>
				</div>
				<div class="form-group">
					<label for="Birth" class="col-sm-10 control-label">Ngày sinh <span style="color: red;"><?php if(isset($eror_Birth)){ echo $eror_Birth; } ?></span></label>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="Birth" id="Birth" value="<?php if (isset($Birth)) {echo $Birth; } ?>"  >
					</div>
				</div>

				<div class="form-group">
					<label for="Energy" class="col-sm-10 control-label">Giới tính <span style="color: red;"><?php if(isset($eror_energy)){ echo $eror_energy; } ?></span></label>
					<div class="col-sm-10">
						<input type="radio" name="Energy" id="Energy" value="1" checked="<?php if($Energy ==1){echo "checked";} ?>" >Nam
						<input type="radio" name="Energy" id="Energy" value="0" checked="<?php if($Energy ==0){echo "checked";} ?>" >Nữ
					</div>
				</div>
				<div class="form-group">
					<label for="Email" class="col-sm-10 control-label">Email <span style="color: red;"><?php if(isset($eror_Email)){ echo $eror_Email; } ?></span></label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="Email" id="Email" placeholder="Nhập Email!" value="<?php if (isset($Email)) {echo $Email; } ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="Phone" class="col-sm-10 control-label">Số điện thoại <span style="color: red;"><?php if(isset($eror_Phone)){ echo $eror_Phone; } ?></span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Phone" id="Phone" placeholder="Nhập số điện thoại" value="<?php if (isset($Phone)) {echo $Phone; } ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="Address" class="col-sm-10 control-label">Địa chỉ <span style="color: red;"><?php if(isset($eror_Address)){ echo $eror_Address; } ?></span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Address" id="Address" placeholder=" Nhập địa chỉ" value="<?php if (isset($Address)) {echo $Address; } ?>" >
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-primary" name="submit" value = "Thêm mới"></input>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
