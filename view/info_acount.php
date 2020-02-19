<?php
include_once 'config/myConfig.php';
    if (session_id() == ''){
        session_start();
    }
        $id=$_SESSION["id_ql"];
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
                //thong báo sửa thành công

                if (isset($_SESSION['up_acc']) && $_SESSION['up_acc'] == 1) {

                    ?>
              
                    <div class="alert alert-success alert-dismissable view_noti col-md-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Cập nhật thông tin</strong> thành công!
                    </div>
                <?php 
                unset($_SESSION['up_acc']);}
    if (isset($_POST['submit']) ) {
        //xu ly upload img
        
        $target_dir = "../images/anhnv/new";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        $nameimg = basename( $_FILES["img"]["name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;

    // Check file size
            if ($_FILES["img"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
    // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
    // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["img"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    //        echo $nameimg;

        $sql = "UPDATE tbl_nhanvien SET anh_nhanvien = '$nameimg' WHERE  id_nhanvien = '$id'";
        $query = mysqli_query($conn, $sql);
    }
    // xu lí sưa

    if (isset($_POST['Update_acount']) ) {
    $Name = $_POST['Name'];
    $Cmt = $_POST['Cmt'];
    $Birth = $_POST['Birth'];
    $Phone = $_POST['Phone'];
    $energy = $_POST['energy'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];    $error = '';
    $date = date('Y-m-d');
    $id = $_SESSION["id_ql"];

    $error = 0;
    $date = date('Y-m-d');
     $regexName = '/^[^\d+]*[\d+]{0}[^\d+]*$/';
    $regexCmt = '/^\d+$/';
    $regexPhone = '/^\d+$/';
    $regexEmail = '/\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,6}\b/i';
   // check ten
    if($Name == ""){
         echo "<p style='color: red;'>Họ tên không được để trống</p>";
            $error ++;
            //echo "ht k dc de trong";
    }
    else if (preg_match($regexName, $Name) == 0) {
            echo "<p style='color: red;'>Họ tên không hợp lệ</p>";
            $error ++;
            //echo "ko hop le ten";
            // $Name = "";
    }
    //check cmt
    if($tcc!= $Cmt){
        if($Cmt == ""){
            echo "<p style='color: red;'>Chứng minh thư không được để trống!</p>";
            $error ++;
        }
        else if (preg_match($regexCmt, $Cmt) == 0) {
            echo "<p style='color: red;'>Chứng minh thư không hợp lệ!</p>";
            $error ++;
            // $Cmt = "";
        }
        else if(check_cmt($Cmt)==1){
            echo "<p style='color: red;'>Chứng minh thư Đã tồn tại!</p>";
            $error ++;
            // $Cmt = "";
        }
    }else if($Cmt == ""){
        echo "<p style='color: red;'>Chứng minh thư không được để trống!</p>";
            $error ++;
        }
    
    //check Birrth
    if($Birth == ""){
        echo "<p style='color: red;'>Ngày sinh không được để trống!</p>";
            $error ++;
    }
    // check phone
    if($sdt!=$Phone){
        if($Phone == ""){
            echo "<p style='color: red;'>Số điện thoại không được để trống!</p>";
            $error ++;
        }
        else if (!preg_match($regexPhone, $Phone)) {
            echo "<p style='color: red;'>Số điện thoại không hợp lệ!</p>";;
            $error ++;
            // $Phone = "";
        }
        else if(check_phone($Phone)==1){
            echo "<p style='color: red;'>Số điện thoại đã tồn tại!</p>";
            $error ++;
            // $Phone = "";
        }
    }else if($Phone == ""){
        echo "<p style='color: red;'>Số điện thoại không được để trống!</p>";
            $error ++;
        }
   
    // check energy
    // check Email
     if($email!= $Email){
        if($Email == ""){
            echo "<p style='color: red;'>Email không được để trống!</p>";

            $error ++;
        }
        else if (preg_match($regexCmt, $Email) == 0) {
            echo "<p style='color: red;'>Email không hợp lệ</p>";
            $error ++;
            // $Email = "";
        }
        else if(check_cmt($Email)==1){
            echo "<p style='color: red;'>Email Đã tồn tại!</p>";
            $error ++;
            // $Cmt = "";
        }
    }else if($Email == ""){
        echo "<p style='color: red;'>Email không được để trống!</p>";
            $error ++;
        }
    // check Address
     if($Address == ""){
        echo "<p style='color: red;'>Địa chỉ không được để trống!</p>";
            $error ++;
    }

    //xu ly them
    if($error==0){
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
          echo $_SESSION['up_acc']=1;
           echo "<script>window.location='index.php?page=info_acount' </script>";
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
		<div class="col-md-12" style="margin-top: 10px"> <h3>THÔNG TIN CÁ NHÂN</h3></div>
		
		<div class="col-md-3">
            <img style="width: 150px; height: 150px" src="../images/anhnv/<?php echo $rowSelec['anh_nhanvien'] ?> ">
            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="view/update_im.php" >
                <label for="img" class=" control-label">Sửa Ảnh đại diện</label>
                <input type="file" class="" name="img" id="img" placeholder="Ảnh">
                <input type="submit" class="btn btn-primary" name="submit" value="Cập nhật" >
            </form>
        </div>
		<div class="col-md-9">
			 <form class="form-horizontal" role="form" method="POST" action="">
			 	<div class="form-group">
					<label for="Name" class="col-sm-3 control-label">Mã nhân viên : <?php echo $rowSelec['id_nhanvien']; ?></label>
				</div>
				<div class="form-group">
					<label for="Brand" class="col-sm-3 control-label">Chi nhánh</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Brand" id="Brand" value="<?php echo $rowSelec['ten_chinhanh']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Name" class="col-sm-3 control-label">Họ và Tên</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Name" id="Name" value="<?php echo $rowSelec['ten_nhanvien']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Cmt" class="col-sm-3 control-label">Thẻ căn cước</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Cmt" id="Cmt" value="<?php echo $rowSelec['thecancuoc']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Birth" class="col-sm-3 control-label">Ngày sinh</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="Birth" id="Birth" value="<?php echo $rowSelec['ngaysinh']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Energy" class="col-sm-3 control-label">Giới tính</label>
					<div class="col-sm-10">
						<input type="radio" name="energy" id="Energy" value="" <?php if ($rowSelec['gioitinh'] ==1) echo "checked"; {
							# code...
						} ?> disabled>Nam
						<input type="radio" name="energy" id="Energy" value="" <?php if ($rowSelec['gioitinh'] ==0) echo "checked"; {
							# code...
						} ?> disabled>Nữ 
					</div>
				</div>
				<div class="form-group">
					<label for="Email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="Email" id="Email" value="<?php echo $rowSelec['email_nhanvien']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Phone" class="col-sm-3 control-label">Số điện thoại</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Phone" id="Phone" value="<?php echo $rowSelec['sdt_nhanvien']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="Address" class="col-sm-3 control-label">Địa chỉ</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="Address" id="AddremyModalss" value="<?php echo $rowSelec['diachi_nhanvien']; ?>" disabled>
					</div>
				</div>	
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#myModal">Sửa</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>




<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                	<h4 class="modal-title">Sửa thông tin </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" action=""method="POST">
                        <legend class="text-center">Thông tin </legend>
                        <div class="form-group">
                            <label for="Name" class="col-sm-3 control-label">Họ và Tên</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $rowSelec['ten_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Cmt" class="col-sm-3 control-label">Chứng minh thư</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Cmt" id="Cmt" value="<?php echo $rowSelec['thecancuoc']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Birth" class="col-sm-3 control-label">Ngày sinh</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="Birth" id="Birth" value="<?php echo $rowSelec['ngaysinh']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Energy" class="col-sm-3 control-label">Giới tính</label>
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
                            <label for="Email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $rowSelec['email_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Phone" class="col-sm-3 control-label">Số điện thoại</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Phone" id="Phone" value="<?php echo $rowSelec['sdt_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Address" class="col-sm-3 control-label">Địa chỉ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Address" id="Address" value="<?php echo $rowSelec['diachi_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="Update_acount">Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
<?php 

 ?>