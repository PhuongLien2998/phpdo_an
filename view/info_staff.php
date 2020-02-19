<?php
include_once 'config/myConfig.php';
    if (session_id() == ''){
        session_start();
    }
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
        $_SESSION["idnv"] = $id;
        
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
    
        $_SESSION["cmtnv"] = $rowSelec['thecancuoc'];
        $_SESSION["sdtnv"] = $rowSelec['sdt_nhanvien'];
        $_SESSION["emailnv"] = $rowSelec['email_nhanvien'];
	}else{
		header("Location: index.php");
	}

	//anh
    $sqlcn = 'SELECT
        *
        FROM
        tbl_chinhanh ';
    
    $querycn = mysqli_query($conn, $sqlcn);
    // chức vụ
    // $sqllevel = 'SELECT
    //             level
                
    //             FROM
    //             tbl_taikhoan
    //             ';
    // $querylevel = mysqli_query($conn, $sqllevel);
    // $rowlevel = mysqli_fetch_row($querylevel);
    // if($rowlevel['level'] == 0) echo 1;
    // else echo $rowlevel['level'] ;
    //  echo "<pre>";
    // print_r($row1);
    // echo "</pre>";
         // câu lênh truy vấn

    
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
            <div><?php  
                if (isset($_SESSION['noti_update']) && $_SESSION['noti_update'] == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissable view_noti" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Update</strong> thành công!
                    </div>
                <?php }
                unset($_SESSION['noti_update']); ?></div>
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
               <!--  <div class="form-group">
                    <label for="Position" class="col-sm-3 control-label">Chức vụ </label>
                    
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Position" id="Position" value="<?php ?>" disabled>
                    </div>
                </div> -->                           
               
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

				<!-- <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-primary" >Sửa</button>
						
					</div>
				</div> -->
			</form>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a  href="index.php?page=update_staff&id=<?php echo $rowSelec['id_nhanvien']; ?>">
                        <button class="btn btn-primary">Sửa</button>
                    </a>
                    <buttontype="button" class="btn btn-danger"  data-toggle="modal" data-target="#delete">Khóa</button>
                </div>
            </div>
		</div>
	</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                	<h4 class="modal-title">Sửa thông tin nhân viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" action="view/update_staff.php" method="POST">
                        <legend class="text-center">Thông tin nhân viên</legend>
                        <div class="form-group">
                            <label for="Name" class="col-sm-10 control-label">Họ và Tên</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $rowSelec['ten_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Cmt" class="col-sm-10 control-label">Chứng minh thư</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Cmt" id="Cmt" value="<?php echo $rowSelec['thecancuoc']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Birth" class="col-sm-10 control-label">Ngày sinh</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="Birth" id="Birth" value="<?php echo $rowSelec['ngaysinh']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Energy" class="col-sm-10 control-label">Giới tính</label>
                            <div class="col-sm-10">
                                <input type="radio" name="energy" id="Energy" value="" <?php if ($rowSelec['gioitinh'] ==1) echo "checked"; {
                                    # code...
                                } ?> >Nam
                                <input type="radio" name="energy" id="Energy" value="" <?php if ($rowSelec['gioitinh'] ==0) echo "checked"; {
                                    # code...
                                } ?> >Nữ
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Email" class="col-sm-10 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $rowSelec['email_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Phone" class="col-sm-10 control-label">Số điện thoại</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Phone" id="Phone" value="<?php echo $rowSelec['sdt_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Address" class="col-sm-10 control-label">Địa chỉ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Address" id="Address" value="<?php echo $rowSelec['diachi_nhanvien']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Brand" class="col-sm-10 control-label">Chi nhánh</label>
                            <select name="barnd" class="browser-default custom-select custom-select-lg mb-3 select">
                                <option selected value="<?php echo $rowSelec['id_chinhanh']; ?>" >
                                    <?php echo $rowSelec['ten_chinhanh']; ?>
                                </option>
                                <?php while ($rowcn = mysqli_fetch_array($querycn)) {   ?>
                                    <option value="<?php  echo $rowcn['id_chinhanh']; ?>">
                                        <?php  echo $rowcn[1]; ?>
                                    </option>
                                        <?php } ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" name="saveUpdate">Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
</div>

<!-- khoa -->
<div id="delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" action="view/delete_nv.php" method="POST">
                        <legend class="text-center">LÍ DO</legend>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="lido" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="del">Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
</div>