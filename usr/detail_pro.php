<?php connect_db(); 
	$q=""; 
	$par="";
	$kb="";
	if(isset($_GET['KB'])){ $kb=$_GET['KB'];}else{?><script type="text/javascript">window.history.back();</script><?php }
	autocount_views($kb);
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-lg-12">
      <div class="panel panel-default navbar-default no-radius">
       	<div class="panel-heading">
					<h3><i class="fa fa-bookmark"></i> Data Barang</h3>
       	</div>
        <div class="panel-body">
        	<ul class="nav navbar-nav navbar-left">
        		<li class="navbar-form"><button type="button" id="kemb" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</button></li>
        	</ul>
        	<ul class="nav navbar-nav navbar-right">
				<?php 
					$q_1=mysql_query("SELECT * FROM tbbarang WHERE kd_barang = '".$kb."'");
					$r_1=mysql_fetch_row($q_1);
					if($_SESSION['username_usr']==$r_1[1]){
				?>
        		<li class="navbar-form"><button type="button" id="del" data-toggle="modal" data-target="#hapus" class="btn btn-success"><i class="fa fa-eraser"></i> Hapus</button></li>
        		<li class="navbar-form"><button type="button" data-target="#editbar" data-toggle="modal" id="bedit" class="btn btn-success"><i class="fa fa-edit"></i> Ubah</button></li>
        		<?php }else{ ?>
        		<li class="navbar-form"><button type="button" id="add" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Tambahkan ke Keranjang</button></li>
        		<?php } ?>
        	</ul>
        </div>
      </div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs 12">
			<div class="panel panel-default navbar-default no-radius">
				<div class="panel-body">
					<div class="col-lg-3 col-md-4 col-sm-4">
						<div class="pad-item btn-default">
							<img class="img-responsive img-zoom" src="../config/mythumbnail.php?KB=<?php echo $r_1[0]; ?>">
							<h4><?php echo $r_1[0]; ?></h4>
							<h4><?php echo $r_1[2]; ?></h4>
							<?php if($_SESSION['username_usr']==$r_1[1]){ ?>
								<h5><?php echo "Harga Awal : IDR ".number_format($r_1[3]); ?></h5>
								<h5><?php echo "Harga Jual : IDR ".number_format($r_1[4]); ?></h5>
								<h5><?php echo "Stok : ".$r_1[5]; ?></h5>
							<?php }else{ 
								$q_4 = mysql_query("SELECT nama, namatoko FROM tbuser WHERE username = '$r_1[1]'") or die(mysql_error());
								$r_4 = mysql_fetch_row($q_4);
							?>
								<h5><?php echo "Penjual : ".$r_4[0]; ?></h5>
								<h5><?php echo "Nama Toko : ".$r_4[1]; ?></h5>
								<h5><?php echo "Harga : IDR ".number_format($r_1[4]); ?></h5>
								<h5><?php echo "Stok : ".$r_1[5]; ?></h5>
							<?php } ?>
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-sm-4">
						<div class="well">
							<?php $cat = $r_1[6];
								$q_2=mysql_query("SELECT namakat FROM tbkat WHERE kodekat='$cat'");
								$r_2=mysql_fetch_row($q_2);
							?>
							<h4>Kategori : </h4>
							<p><?php echo $r_2[0]; ?></p>
							<h4>Deskripsi :</h4>
							<p><?php echo $r_1[7]; ?></p>
							<h4>Jumlah Views :</h4>
							<?php 
								if($r_1[8]=="0"){ ?>
								<p><?php echo "-"; ?></p>
								<?php }else{ ?>
							<p><?php echo $r_1[8]." Kali"; ?></p>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>	
<!-- Modal (edit data barang) -->
		<div class="modal fade" id="editbar" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="form-horizontal" enctype="multipart/form-data" action="../config/action.php" method="post">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-edit"></i> Ubah Barang</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="editbar-code" class="col-lg-2 control-label">Kode</label>
								<div class="col-lg-8">
									<input id="editbar-code" value="<?php echo $r_1[0]; ?>" readonly class="form-control" type="text" name="kode" placeholder="Kode Barang" maxlength="8">
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-name" class="col-lg-2 control-label">Nama</label>
								<div class="col-lg-8">
									<input id="editbar-name" value="<?php echo $r_1[2]; ?>" required class="form-control" type="text" name="nama" placeholder="Nama Barang" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-beli" class="col-lg-2 control-label">Beli</label>
								<div class="col-lg-8">
									<input id="editbar-beli" value="<?php echo $r_1[3]; ?>" required class="form-control" type="number" name="beli" placeholder="Harga Beli" maxlength="9">
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-jual" class="col-lg-2 control-label">Jual</label>
								<div class="col-lg-8">
									<input id="editbar-jual" value="<?php echo $r_1[4]; ?>" required class="form-control" type="number" name="jual" placeholder="Harga Jual" maxlength="9">
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-qty" class="col-lg-2 control-label">Stok</label>
								<div class="col-lg-8">
									<input id="editbar-qty" value="<?php echo $r_1[5]; ?>" required class="form-control" type="number" name="qty" placeholder="Jumlah Stok" maxlength="3">
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-kat" class="col-lg-2 control-label">Kategori</label>
								<div class="col-lg-8">
									<select id="editbar-kat" required class="form-control" name="kat">
										<?php 
											$q_3=mysql_query("SELECT * FROM tbkat ORDER BY namakat ASC") or die(mysql_error());
											echo "<option value=''>--Kategori--</option>";
											while ($r_3=mysql_fetch_array($q_3)){ ?>
											<option <?php if($r_3[0]==$r_1[6]){ echo " selected "; } ?> value="<?php echo $r_3[0]; ?>"><?php echo $r_3[1]; ?></option><?php
											} 
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-desc" class="col-lg-2 control-label">Deskripsi</label>
								<div class="col-lg-8">
									<textarea id="editbar-desc" required name="desc" class="form-control" rows="4"><?php echo $r_1[7]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="editbar-foto" class="col-lg-2 control-label">Foto</label>
								<div class="col-lg-8">
									<input id="editbar-foto" type="file" name="foto">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 control-label">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-success" id="editbar_btn" name="editbar_btn">Ubah</button>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="hapus" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-eraser"></i> Hapus Barang</h4>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-6">
											<p>Anda yakin ingin menghapus data barang ini?</p>
										</div>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="pull-right">
												<button class="btn btn-default" data-dismiss="modal">Batal</button>
												<button class="btn btn-success" id="accept">Ya</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
	$("#accept").click(function(){
		document.location="../config/action.php?act=delete_bar&kb=<?php echo $r_1[0]; ?>";
	});
	$("#kat").change(function(){
		var  url="?main=mystore";
		var q=$("#kat").val();
		if(q==""){
			url=url;
		}else{
			url=url+"&q="+q;
		}
		document.location=url;	
	});
	$("#kemb").click(function(){
		window.history.back();
	});
	$("#add").click(function(){
		var url="../config/action.php?cart=add&kb=<?php echo $r_1[0]; ?>";
		document.location=url;
	});
</script>