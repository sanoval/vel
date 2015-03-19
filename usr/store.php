<?php connect_db(); 
	$q=""; 
	$par="";
	if(!isset($_GET['kb'])){
		?><script>window.history.back()</script><?php
	}else{$kb=$_GET['kb'];}
	$q=mysql_query("select tbuser.nama,tbuser.namatoko,kabupaten.nama,provinsi.nama from tbuser,kabupaten,provinsi where username='".$_SESSION['username_usr']."' and tbuser.IDKabupaten=kabupaten.IDKabupaten and tbuser.IDProvinsi=provinsi.IDProvinsi");
	$r=mysql_fetch_row($q);
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-lg-12">
	    	<div class="jumbotron no-radius no-bottom">
					<h2><i class="fa fa-user"></i> <?php echo $r[1]." | ".$r[0]; ?></h2>
					<p><?php echo $r[2].", ".$r[3]; ?></p>
					<p><a href="#detail" class="btn btn-success" data-toggle="modal">Lihat Detail <i class="fa fa-link"></i></a></p>
	    	</div>
		    <div class="panel panel-default no-radius">
		        <div class="panel-body">
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
						$q_1 = mysql_query("SELECT * FROM tbbarang WHERE username = '$kb' $par LIMIT $offset,$dataPerPage") or die(mysql_error());
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
								$query = "SELECT COUNT(*) AS jumData FROM tbbarang WHERE username ='$kb' $par";
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
									<img src="../config/usrthumbnail.php?KB=<?php echo $kb; ?>" class="img-responsive img-circle">
									<?php 
										$qq = mysql_query("select * from tbuser where username='$kb'");
										$rr = mysql_fetch_row($qq);
									?>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Nama Toko</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[3];?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Pemilik</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[2]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Username</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[0]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Email</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[4]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Nomor Telp/HP</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[6]; ?></div>
							</div>
							<?php 
								$qa=mysql_query("select provinsi.nama,kabupaten.nama,kecamatan.nama,kelurahan.nama 
								from tbuser,provinsi,kabupaten,kecamatan,kelurahan where tbuser.username='$rr[0]' and tbuser.IDKelurahan=kelurahan.IDkelurahan
								and Kelurahan.IDKecamatan=Kecamatan.IDKecamatan and kecamatan.IDkabupaten=kabupaten.IDKabupaten 
								and kabupaten.IDProvinsi=provinsi.IDProvinsi")or die(mysql_error());
								$ra=mysql_fetch_row($qa);
							?>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Provinsi</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $ra[0]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Kota/Kabupaten</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $ra[1]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Kecamatan</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $ra[2]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Desa/Kelurahan</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $ra[3]; ?></div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Alamat</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $rr[5]; ?></div>
							</div>
							<?php 
								$qb=mysql_query("select sum(views) from tbbarang where username='$rr[0]'");
								$rb=mysql_fetch_row($qb);
								if($rb[0]<>"0"){$view=$rb[0]." Kali";}else{$view="-";}
							?>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Total Views</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">: <?php echo $view; ?></div>
							</div>
						</div>
						<div class="modal-footer bg-green">
							</div>
						</div>
				</div>
			</div>
		</div>	
<script type="text/javascript">
	$("#kat").change(function(){
		var  url="?main=store&kb=<?php echo $kb; ?>";
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