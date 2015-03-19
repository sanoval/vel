<?php 
	include "../config/config.php";
	admin_level();
	connect_db();
?>
<!DOCTYPE Html>
<html>
	<head>
		<title>MyToko</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<!-- CSS link -->
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css.">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<!-- JQuery -->
		<script type="text/javascript" src="../js/jquery-min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="?main=default" class="navbar-brand"><i class="fa fa-hand-o-up"></i> MyToko</a>
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse navHeaderCollapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#kontak"><i class="fa fa-info"></i> List Kategori</a></li>
						<li><a href="#kontak"><i class="fa fa-envelope"></i> Pesan</a></li>
						<li><a href="#kontak"><i class="fa fa-bar-chart-o"></i> Grafik</a></li>
						<li><a href="#kontak"><i class="fa fa-users"></i> Users</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i> <?php echo $_SESSION['name_usr']; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="fa fa-gear"></i> Pengaturan Akun</a></li>
								<li class="divider"></li>
								<li><a href="../config/action.php?act=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- Start Of Main Area -->
		<div class="bg-repeat">
			<div class="container pad-bottom-70 pad-top-40">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="panel panel-default no-radius">
						<div class="panel-body">
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="list-group">
									<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-arrow-circle-o-down"></i> Konfirmasi</strong></a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-hand-o-right fa-fw"></i> Konfirmasi Pembayaran</a>
									<a href="?main=recieve_confirm" class="list-group-item no-radius"><i class="fa fa-truck fa-fw"></i> Konfirmasi Pengiriman</a>
									<a href="?main=archive" class="list-group-item no-radius"><i class="fa fa-folder fa-fw"></i> Arsip Transaksi</a>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-users"></i> Kategori</strong></a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-user fa-fw"></i> Daftar User</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-gift fa-fw"></i> Daftar Barang</a>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-users"></i> Data Users</strong></a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-user fa-fw"></i> Daftar User</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-gift fa-fw"></i> Daftar Barang</a>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-envelope"></i> Pesan</strong></a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-arrow-down fa-fw"></i> Inbox</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-arrow-up fa-fw"></i> Keluar</a>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-bar-chart-o"></i> Grafik Bulanan</strong></a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Transaksi</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-bar-chart-o fa-fw"></i> Penjualan Terbanyak (User)</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-bar-chart-o fa-fw"></i> Produk Terpopuler</a>
									<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-bar-chart-o fa-fw"></i> Produk Terlaris</a>
								</div>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9">
								<div class="jumbotron no-radius">
									<h3><i class="fa fa-hand-o-right fa-fw"></i> Konfirmasi Pembayaran</h3>
								</div>
								<ul class="nav nav-pills">
									<li class="active"><a href="#unconfirmed" data-toggle="tab">Belum Dikonfirmasi</a></li>
									<li><a href="#confirmed" data-toggle="tab">Sudah Dikonfirmasi</a></li>
								</ul>
								<div class="tab-content">
			                  	<div class="tab-pane fade <?php if(!isset($_GET['page2'])){ echo "in active"; } ?>" id="unconfirmed">
			                  	<p>
										<?php 
										$dataPerPage = 1;
										if (isset($_GET['page']))
											{
												$noPage = $_GET['page'];
										}else $noPage = 1;
										$offset = ($noPage - 1) * $dataPerPage;
										$q=mysql_query("SELECT tbuser.username,tbuser.nama,transactions.trx,transactions.gtotal,transactions.request
										from tbuser,transactions where
										tbuser.username=transactions.username and transactions.confirm<>'0000-00-00' and transactions.bayar='000-00-00'
										and transactions.kirim='000-00-00' and transactions.terima='000-00-00' 
										order by request desc limit $offset, $dataPerPage")
										or die(mysql_error());
										if(mysql_num_rows($q)<>0){
											?><div class="list-group"><?php
											while($r=mysql_fetch_array($q)){
											$tgl=substr($r[4],8,2); $bln=substr($r[4],5,2); $thn=substr($r[4],0,4);
										?>
										<div class="pad-item">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="col-lg-3 col-md-3 col-sm-3">
													<img class="img-responsive" src="../config/usrthumbnail.php?KB=<?php echo $r[0]; ?>">
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9">
												<?php  
													$qy=mysql_query("SELECT tbuser.nama,tbuser.username from tbuser,transactions where tbuser.username=transactions.seller and transactions.trx='".$r[2]."'");
													$ry=mysql_fetch_row($qy);
												?>
													<h4><a href="?main=store&amp;kb=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a> <i class="fa fa-arrow-right"></i> <a href="?main=store&amp;kb=<?php echo $ry[1]; ?>"><?php echo $ry[0]; ?></a></h4>
													<p><?php echo $r[2]; ?></p>
													<p>Grand Total Rp. <?php echo number_format($r[3]); ?>,-</p>
													<p><em><?php echo "Dikonfirmasi tanggal "; spell_month($tgl,$bln,$thn); ?></em></p>
													<div class="pull-right">
														<a href="?main=detail_buy&amp;trx=<?php echo md5($r[2]); ?>" class="btn btn-success">Lihat Rincian</a></div>
												</div>
											</div>
										</div>
										<?php
												}
												$query = "SELECT COUNT(*) AS jumData from tbuser,transactions where
												tbuser.username=transactions.username and transactions.confirm<>'0000-00-00' and transactions.bayar='000-00-00'
												and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.seller='".$_SESSION['username_usr']."'";
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
													<?php if ($noPage > 1){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirmbuy_confirm&page=".($noPage-1)?>">Prev</a></li><?php }
													// memunculkan nomor halaman dan linknya
														for($page = 1; $page <= $jumPage; $page++){
															if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
																if (($showPage == 1) && ($page != 2))  echo "";
																	if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "";
																		if ($page == $noPage){ ?><li class="active"><a href="#"><?php echo $page; ?></a></li><?php
																		}else { ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirm&page=".$page ?>"><?php echo $page ?></a></li><?php
																			$showPage = $page; 
																		}
																}
															}
															// menampilkan link next
														if ($noPage < $jumPage){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirm&page=".($noPage+1) ?>">Next</a></li><?php } ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<?php }else{ ?>
										<p><div class="text-center">Tidak Ada Pesanan</div></p><?php } ?>
										</p>
				                  </div>
				                  <div class="tab-pane fade <?php if(isset($_GET['page2'])){ echo "in active"; } ?>" id="confirmed">
				                     <p>
											<?php 
											$dataPerPage2 = 4;
											if (isset($_GET['page2']))
												{
													$noPage2 = $_GET['page2'];
											}else $noPage2 = 1;
											$offset2 = ($noPage2 - 1) * $dataPerPage2;
											$q=mysql_query("SELECT tbuser.username,tbuser.nama,transactions.trx,transactions.gtotal,transactions.bayar,transactions.confirm
											from tbuser,transactions where
											tbuser.username=transactions.username and transactions.confirm<>'0000-00-00' and transactions.bayar<>'000-00-00'
											and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.seller='".$_SESSION['username_usr']."' 
											order by request desc limit $offset2, $dataPerPage2")
											or die(mysql_error());
											if(mysql_num_rows($q)<>0){
												?><div class="list-group"><?php
												while($r=mysql_fetch_array($q)){
												$tgl=substr($r[4],8,2); $bln=substr($r[4],5,2); $thn=substr($r[4],0,4);
											?>
											<div class="pad-item">
												<div class="col-lg-12 col-md-12 col-sm-12">
													<div class="col-lg-3 col-md-3 col-sm-3">
														<img class="img-responsive" src="../config/usrthumbnail.php?KB=<?php echo $r[0]; ?>">
													</div>
													<div class="col-lg-9 col-md-9 col-sm-9">
														<h4>Dari : <a href="?main=store&amp;kb=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a></h4>
														<p><?php echo $r[2]; ?></p>
														<p>Grand Total Rp. <?php echo number_format($r[3]); ?>,-</p>
														<p><em><?php echo "Dibayar tanggal "; spell_month($tgl,$bln,$thn); ?></em></p>
														<div class="pull-right">
															<a href="?main=detail_buy&amp;trx=<?php echo md5($r[2]); ?>" class="btn btn-success">Lihat Rincian</a></div>
													</div>
												</div>
											</div>
											<?php
													}
													$query2 = "SELECT COUNT(*) AS jumData from tbuser,transactions where
													tbuser.username=transactions.seller and transactions.confirm<>'0000-00-00' and transactions.bayar<>'000-00-00'
													and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.username='".$_SESSION['username_usr']."'";
													$hasil2 = mysql_query($query2);
													$hasilx2 = mysql_fetch_array($hasil2);
													$jumData2 = $hasilx['jumData'];
													$showPage2 = 0;

											// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
											$jumPage2 = ceil($jumData2/$dataPerPage2); ?>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="col-lg-4 pull-right">
													<div class="bs-example pull-right">
														<ul class="pagination">
														<?php if ($noPage2 > 1){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirm&page2=".($noPage2-1)?>">Prev</a></li><?php }
														// memunculkan nomor halaman dan linknya
															for($page2 = 1; $page2 <= $jumPage2; $page2++){
																if ((($page2 >= $noPage2 - 3) && ($page2 <= $noPage2 + 3)) || ($pag2 == 1) || ($page2 == $jumPage2)){
																	if (($showPage2 == 1) && ($page2 != 2))  echo "";
																		if (($showPage2 != ($jumPage2 - 1)) && ($page2 == $jumPage2))  echo "";
																			if ($page2 == $noPage2){ ?><li class="active"><a href="#"><?php echo $page2; ?></a></li><?php
																			}else { ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirm&page2=".$page2 ?>"><?php echo $page2 ?></a></li><?php
																				$showPage2 = $page; 
																			}
																	}
																}
																// menampilkan link next
															if ($noPage2 < $jumPage2){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=buy_confirm&page2=".($noPage2+1) ?>">Next</a></li><?php } ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<?php }else{ ?>
											<p><div class="text-center">Tidak Ada Pesanan</div></p><?php } ?>
											</p>
				                  </div>
				               </div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Of Main Area -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text pull-left">© MyToko 2014 - 2015</p>
			</div>
		</div>
		<script src="../js/dataTables/jquery.dataTables.js"></script>
		<script src="../js/dataTables/dataTables.bootstrap.js"></script>
	</body>
</html>