<?php connect_db(); 
	$q=""; 
	$par="";
	$q=mysql_query("select tbuser.nama,tbuser.namatoko,kabupaten.nama,provinsi.nama from tbuser,kabupaten,provinsi where username='".$_SESSION['username_usr']."' and tbuser.IDKabupaten=kabupaten.IDKabupaten and tbuser.IDProvinsi=provinsi.IDProvinsi");
	$r=mysql_fetch_row($q);
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-lg-12">
	    	<div class="jumbotron no-radius no-bottom">
					<h2><i class="fa fa-user"></i> <?php echo $r[1]." | ".$r[0]; ?></h2>
					<p><?php echo $r[2].", ".$r[3]; ?></p>
					<p><a href="#detail" class="btn btn-success" data-toggle="modal">Update Profil <i class="fa fa-link"></i></a></p>
	    	</div>
		    <div class="panel panel-default bg-gray no-radius">
		        <div class="panel-body">
		        	<ul class="nav navbar-nav navbar-left">
		        		<li class="navbar-form"><button class="btn btn-default" data-target="#addbar" data-toggle="modal"><i class="fa fa-plus-circle"></i> Tambah Barang</button></li>
		        	</ul>
		        	<ul class="nav navbar-nav navbar-right">
		        		<li class="navbar-form">
									<div class="input-group">
										<span class="input-group-addon">
											Filter
										</span>
										<select class="form-control" name="kat" id="kat">
											<?php 
												if(isset($_GET['q'])){$q=$_GET['q']; $par="AND kodekat='$q'";}
												$q_1=mysql_query("SELECT * FROM tbkat ORDER BY namakat ASC") or die(mysql_error());
												echo "<option value=''>Semua Kategori</option>";
												while ($r_1=mysql_fetch_array($q_1)){ ?>
												<option <?php if($r_1[0]==$q){echo ' selected="selected" ';} ?> value="<?php echo $r_1[0]; ?>"><?php echo $r_1[1]; ?></option><?php
												} 
											?>
										</select>
									</div>
								</li>
		        	</ul>
		        </div>
		    </div>
		</div>
	</div>
	<!-- Bagian Tampil data -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs 12">
			<div class="panel panel-default navbar-default no-radius">
				<div class="panel-body">
					<?php 
						$dataPerPage = 4;
						if (isset($_GET['page']))
							{
								$noPage = $_GET['page'];
						}else $noPage = 1;
						$offset = ($noPage - 1) * $dataPerPage;
						$q_1 = mysql_query("SELECT * FROM tbbarang WHERE username = '".$_SESSION['username_usr']."' $par LIMIT $offset,$dataPerPage") or die(mysql_error());
						if(mysql_num_rows($q_1)==0){
								?><div class="min-hi" style="margin-top:30px"><h4 class="text-center"><em>Tidak Ada barang</em></h4></div><?php
						}else{
							while($r_1=mysql_fetch_array($q_1)){
					?>
						<div class="col-lg-3 col-md-4 col-sm-4">
							<div class="pad-item btn-default">
								<img class="img-responsive img-zoom" src="../config/mythumbnail.php?KB=<?php echo $r_1[0]; ?>">
								<h4><?php echo $r_1[0]; ?></h4>
								<h4><?php echo $r_1[2]; ?></h4>
								<a href="?main=detail_pro&amp;KB=<?php echo $r_1[0] ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Rincian</a>
							</div>
						</div>
					<?php
							}
								$query = "SELECT COUNT(*) AS jumData FROM tbbarang WHERE username ='".$_SESSION['username_usr']."' $par";
								$hasil = mysql_query($query);
								$hasilx = mysql_fetch_array($hasil);
								$jumData = $hasilx['jumData'];
								$showPage = 0;

						// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
						$jumPage = ceil($jumData/$dataPerPage); ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="col-lg-4 pull-right">
											<div class="bs-example pull-right">
												<ul class="pagination">
												<?php if ($noPage > 1){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".($noPage-1)?>">Prev</a></li><?php }
					// memunculkan nomor halaman dan linknya
													for($page = 1; $page <= $jumPage; $page++){
															if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
																	if (($showPage == 1) && ($page != 2))  echo "";
																			if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "";
																					if ($page == $noPage){ ?><li class="active" ><a href="#"><?php echo $page; ?></a></li><?php
																					}else { ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".$page ?>"><?php echo $page ?></a></li><?php
																							$showPage = $page; 
																					}
																	}
													}
					// menampilkan link next
													if ($noPage < $jumPage){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".($noPage+1) ?>">Next</a></li><?php } ?>
												</ul>
											</div>
									</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
  </div>
</div>
		<!-- Modal (Tambah data barang) -->
		<div class="modal fade" id="addbar" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="form-horizontal" enctype="multipart/form-data" action="../config/action.php" method="post">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-plus-circle"></i> Tambah Barang</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="addbar-code" class="col-lg-2 control-label">Kode</label>
								<div class="col-lg-8">
									<input id="addbar-code" required class="form-control" type="text" name="kode" placeholder="Kode Barang" maxlength="8">
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-name" class="col-lg-2 control-label">Nama</label>
								<div class="col-lg-8">
									<input id="addbar-name" required class="form-control" type="text" name="nama" placeholder="Nama Barang" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-beli" class="col-lg-2 control-label">Beli</label>
								<div class="col-lg-8">
									<input id="addbar-beli" required class="form-control" type="number" name="beli" placeholder="Harga Beli" maxlength="9">
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-jual" class="col-lg-2 control-label">Jual</label>
								<div class="col-lg-8">
									<input id="addbar-jual" required class="form-control" type="number" name="jual" placeholder="Harga Jual" maxlength="9">
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-qty" class="col-lg-2 control-label">Stok</label>
								<div class="col-lg-8">
									<input id="addbar-qty" required class="form-control" type="number" name="qty" placeholder="Jumlah Stok" maxlength="3">
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-kat" class="col-lg-2 control-label">Kategori</label>
								<div class="col-lg-8">
									<select id="addbar-kat" required class="form-control" name="kat">
										<?php 
											$q_3=mysql_query("SELECT * FROM tbkat ORDER BY namakat ASC") or die(mysql_error());
											echo "<option value=''>--Kategori--</option>";
											while ($r_3=mysql_fetch_array($q_3)){ ?>
											<option value="<?php echo $r_3[0]; ?>"><?php echo $r_3[1]; ?></option><?php
											} 
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-desc" class="col-lg-2 control-label">Deskripsi</label>
								<div class="col-lg-8">
									<textarea id="addbar-desc" required name="desc" class="form-control" rows="4"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="addbar-foto" class="col-lg-2 control-label">Foto</label>
								<div class="col-lg-8">
									<input id="addbar-foto" required type="file" name="foto">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 control-label">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-success" id="addbar_btn" name="addbar_btn">Tambah</button>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="alert alert-warning alert-dismissable" id="alert">
								<button type="button" class="close" onclick="hiding()">&times;</button>
								<span id="status"></span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>	
<!-- Modal (Update Profile) -->
		<div class="modal fade" id="detail" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header bg-green">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-user"></i> Informasi Toko</h4>
						</div>
						<div class="modal-body">
							<div class="row" style="margin-bottom:20px;margin-top:-17px;background-image: url(../img/topper.jpg);padding:15px;">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
									<img src="../config/usrthumbnail.php?KB=<?php echo $_SESSION['username_usr']; ?>" class="img-responsive img-circle">
									<?php 
										$qq = mysql_query("select * from tbuser where username='".$_SESSION['username_usr']."'");
										$rr = mysql_fetch_row($qq);
									?>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
							</div>
							<div class="row">
								<form action="../config/action.php" class="form-horizontal col-lg-12 col-md-12 col-sm-12" method="post">
									<div class="form-group">
										<label for="pemilik" class="col-lg-4 col-md-4 col-sm-4 control-label">Pemilik</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="pemilik" maxlength="30" required class="form-control" placeholder="Nama Anda" type="text" name="pemilik" value="<?php echo $rr[2]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="email" class="col-lg-4 col-md-4 col-sm-4 control-label">Email</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="email" maxlength="30" required class="form-control" placeholder="Email" type="email" name="email" value="<?php echo $rr[4]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="provinsi" class="col-lg-4 col-md-4 col-sm-4 control-label">Provinsi</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select name="provinsi" required id="provinsi" class="form-control"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="kota" class="col-lg-4 col-md-4 col-sm-4 control-label">Kota/Kab</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select name="kota" id="kota" required class="form-control"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="kec" class="col-lg-4 col-md-4 col-sm-4 control-label">Kecamatan</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select name="kec" id="kec" required class="form-control"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="kel" class="col-lg-4 col-md-4 col-sm-4 control-label">Desa/Kelurahan</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select name="kel" id="kel" required class="form-control"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="alamat" class="col-lg-4 col-md-4 col-sm-4 control-label">Alamat</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<textarea rows="4" id="alamat" maxlength="30" required class="form-control" placeholder="Format: Kampung; RT/RW;" name="alamat"><?php echo $rr[5]; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="nohp" class="col-lg-4 col-md-4 col-sm-4 control-label">Nomor HP</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="nohp" maxlength="30" required class="form-control" min="0" placeholder="Nomor Handphone" type="number" name="nohp" value="<?php echo $rr[6]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="rekening" class="col-lg-4 col-md-4 col-sm-4 control-label">Nomor Rekening</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="rekening" maxlength="30" required class="form-control" placeholder="Nomor Rekening" type="number" name="rekening" value="<?php echo $rr[8]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="bank" class="col-lg-4 col-md-4 col-sm-4 control-label">Nama Bank</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="bank" maxlength="30" required class="form-control" placeholder="Nama Bank" type="text" name="bank" value="<?php echo $rr[7]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="atas" class="col-lg-4 col-md-4 col-sm-4 control-label">Atas Nama</label>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<input id="atas" maxlength="30" required class="form-control" placeholder="Rekening Atas Nama" type="text" name="atas" value="<?php echo $rr[10]; ?>">
										</div>
									</div>
									<div class="form-group col-lg-10 col-md-10 col-sm-10">
										<div class="pull-right">
											<button type="button" id="cancelupdate" data-dismiss="modal" class="btn btn-default">Batal</button>
											<button type="submit" name="updateprofile" class="btn btn-success">Update</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="modal-footer bg-green">
							</div>
						</div>
				</div>
			</div>
		</div>	
<script type="text/javascript">
	$(document).ready(function(){
		$("#alert").hide();
		var IDProv="<?php echo $rr[11]; ?>";
		var IDKota="<?php echo $rr[12]; ?>";
		var IDKec="<?php echo $rr[13]; ?>";
		var IDKel="<?php echo $rr[14]; ?>";
		$("#provinsi").load("../config/load.php","op=getprov&IDProv="+IDProv);
		$("#kota").load("../config/load.php","op=getkota&IDProv="+IDProv+"&IDKota="+IDKota);
		$("#kec").load("../config/load.php","op=getkec&IDKota="+IDKota+"&IDKec="+IDKec);
		$("#kel").load("../config/load.php","op=getkel&IDKec="+IDKec+"&IDKel="+IDKel);
		$("#provinsi").change(function(){
			IDProv = $("#provinsi").val();
			$("#kota").load("../config/load.php","op=getkota&IDProv="+IDProv);
			$("#kec").html("");
			$("#kel").html("");
		});
		$("#kota").change(function(){
			IDKota = $("#kota").val();
			$("#kec").load("../config/load.php","op=getkec&IDKota="+IDKota);
			$("#kel").html("");
		});
		$("#kec").change(function(){
			IDKec = $("#kec").val();
			$("#kel").load("../config/load.php","op=getkel&IDKec="+IDKec);
		});
	});
	function hiding(){
		$("#alert").hide();
	};
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
	$("#addbar_btn").click(function(){
		if($("#addbar-kat").val()==""){
			$("#status").html("Kategori belum dipilih!");
			$("#alert").show();
		}
	});
</script>