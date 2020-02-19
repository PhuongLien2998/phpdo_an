<?php
include_once "config/myConfig.php";
if (session_id() == ''){
    session_start();
}
$idcn = $_SESSION['chi_ql'] ;
$sql = "SELECT
   tbl_chinhanh.ten_chinhanh,
	tbl_nhanvien.id_nhanvien,
	tbl_nhanvien.ten_nhanvien,
	tbl_nhanvien.anh_nhanvien,
	tbl_nhanvien.thecancuoc,
	tbl_nhanvien.mota
FROM
    tbl_chinhanh,
    tbl_nhanvien,
    tbl_taikhoan
WHERE
    tbl_nhanvien.id_chinhanh = '$idcn' AND tbl_nhanvien.id_chinhanh = tbl_chinhanh.id_chinhanh AND tbl_nhanvien.id_nhanvien = tbl_taikhoan.id_nv AND tbl_taikhoan.status = 0 AND tbl_taikhoan.level = 2
					 
	LIMIT 10";
	// "SELECT tbl_chinhanh.ten_chinhanh, tbl_nhanvien.id_nhanvien, tbl_nhanvien.ten_nhanvien, tbl_nhanvien.anh_nhanvien FROM tbl_chinhanh, tbl_nhanvien, tbl_taikhoan WHERE tbl_nhanvien.id_chinhanh = '$idcn' AND tbl_nhanvien.id_chinhanh = tbl_chinhanh.id_chinhanh AND tbl_nhanvien.id_nhanvien = tbl_taikhoan.id_nv AND tbl_taikhoan.status = 1 AND tbl_taikhoan.level = 2 LIMIT 10"
   

	$query = mysqli_query($conn, $sql); // câu lênh truy vấn
	$count = mysqli_num_rows($query); // đếm xem có bao nhiêu bản ghi trả ra
	if ($count > 0) {
?>

			<div class="container" >
				<div class="row" style="margin-top: 20px">

					<br>
					
					<!-- search -->		
						<div class="form-group ">
          			<input type="text" id="search_block" class="form-control inp-day" placeholder="Nhập tên nhân viên!" >
            
                </div>	
					<!-- end search -->
				</div>
				<!-- result table -->
				<div class="col-md-12 list_block">
					<legend class="text-center"a>Danh sách nhân viên đã khóa</legend>	

					<table class="table table-striped">
						<thead class="table-primary">
							<th scope="col">STT</th>
							<th scope="col">Ảnh</th>
							<th scope="col">Tên</th>
							<th scope="col">Mã nhân viên</th>
							<th scope="col">Thẻ căn cước</th>
							<th scope="col">Chi nhánh</th>
							<th scope="col">Lí do</th>
							<th scope="col">Chức năng</th>
						</thead>
						<tbody>
							<?php 
							$dem = 0;
							while ($row = mysqli_fetch_array($query)) {
								$dem += 1;
								?>
								<tr>
									<td><?php echo $dem; ?></td>
									<td><img style="width: 100px; height: 100px" src="../images/anhnv/<?php echo $row['anh_nhanvien']; ?>" alt="<?php echo $row['anh_nhanvien']; ?>"></td>
									<td><?php echo $row['ten_nhanvien']; ?></td>
									<td><?php echo $row['id_nhanvien']; ?></td>
									<td><?php echo $row['thecancuoc']; ?></td>
									<td><?php echo $row['ten_chinhanh']; ?></td>	
									<td><?php echo $row['mota']; ?></td>	
									<td>
										<a  href="index.php?page=open_block&id=<?php echo $row['id_nhanvien'];?>">
											<button class="btn btn-primary">Mở Khóa</button>
										</a>
									</td>	
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	 <?php
              }else{
                ?>
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Danh sách trống!</strong>
                </div>
                <?php
              }
             ?>
	