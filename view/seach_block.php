<?php 
		if (session_id() == ''){
    session_start();
} 
		include_once '../config/myConfig.php';

$idcn = $_SESSION['chi_ql'] ;
	$name = $_POST['key']; // số điện thoại muốn tìm
	$sql = "SELECT tbl_nhanvien.anh_nhanvien,tbl_nhanvien.ten_nhanvien,tbl_nhanvien.id_nhanvien,tbl_chinhanh.ten_chinhanh, tbl_nhanvien.mota, tbl_nhanvien.thecancuoc
    FROM tbl_nhanvien,tbl_taikhoan,tbl_chinhanh
    WHERE tbl_nhanvien.id_chinhanh = '$idcn' AND tbl_nhanvien.id_chinhanh = tbl_chinhanh.id_chinhanh AND tbl_nhanvien.id_nhanvien = tbl_taikhoan.id_nv AND tbl_taikhoan.status = 0 AND tbl_taikhoan.level = 2 AND  tbl_nhanvien.ten_nhanvien LIKE'%$name%' ";
	$query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($query);
if ($count > 0) {
?>
					<table class="table table-striped">
						<thead class="table-primary">
							<th scope="col">STT</th>
							<th scope="col">Ảnh</th>
							<th scope="col">Tên</th>
							<th scope="col">Mã nhân viên</th>
							<th scope="col">thecancuoc</th>
							<th scope="col">Chi nhánh</th>
							<th scope="col">Lí do</th>
							<th scope="col">chức năng</th>
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
										<a  href="index.php?page=info_staff&id=<?php echo $row['id_nhanvien']; ?>">
											<button class="btn btn-primary">xem</button>
										</a>
									</td>	
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<?php
	}else{
?>
	<div class="alert alert-danger">
		
		<strong>Không có tên nhân viên trong danh sách!</strong>
	</div>
<?php
	}
?>
