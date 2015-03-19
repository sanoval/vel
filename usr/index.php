<?php 
	include "../config/config.php";
	user_level();
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
		<link rel="stylesheet" type="text/css" href="../engine/style.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<!-- JQuery -->
		<script type="text/javascript" src="../engine/jquery.js"></script>
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
						<li class="navbar-form">
							<form role="form" action="" method="">
									<input type="hidden" name="main" value="result">
								<div class="input-group">
									<input class="form-control" type="text" name="key" placeholder="Cari Produk / Toko">
									<span class="input-group-btn">
										<select class="form-control" name="cat">
											<?php 
												connect_db();
												$q_1=mysql_query("SELECT * FROM tbkat ORDER BY namakat ASC") or die(mysql_error());
												echo "<option value='all'>Semua Kategori</option>";
												while ($r_1=mysql_fetch_array($q_1)){ ?>
												<option value="<?php echo $r_1[0]; ?>"><?php echo $r_1[1]; ?></option><?php
												} 
											?>
										</select>
									</span>
									<span class="input-group-btn">
										<button class="btn btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
						</li>
						<li><a href="#kontak">Tentang</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Beli <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?main=mywish"><i class="fa fa-shopping-cart"></i> Pesanan Saya</a></li>
								<li><a href="?main=mycart"><i class="fa fa-hand-o-right"></i> Konfirmasi Pembayaran</a></li>
								<li><a href="?main=mycart"><i class="fa fa-truck"></i> Konfirmasi Terima Barang</a></li>
								<li><a href="?main=mycart"><i class="fa fa-folder"></i> Arsip Pembelian</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Jual <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?main=request"><i class="fa fa-shopping-cart"></i> Pesanan</a></li>
								<li><a href="?main=mycart"><i class="fa fa-truck"></i> Konfirmasi Pengiriman</a></li>
								<li><a href="?main=mycart"><i class="fa fa-folder"></i> Arsip Penjualan</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Toko Saya <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?main=mystore"><i class="fa fa-folder"></i> Data Barang</a></li>
								<li><a href="?main=mycart"><i class="fa fa-shopping-cart"></i> Pesanan</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i> <?php echo $_SESSION['name_usr']; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="fa fa-gear"></i> Pengaturan Akun</a></li>
								<li><a href="?main=mycart"><i class="fa fa-shopping-cart"></i> Keranjang Belanja</a></li>
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
			<?php main_page_user(); ?>
		</div>
		<!-- End Of Main Area -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text pull-left">© MyToko 2014 - 2015</p>
				<?php $myquery=mysql_query("SELECT SUM(total) FROM tmp WHERE username='".$_SESSION['username_usr']."'");
					$cart=mysql_fetch_row($myquery);
				?>
				<a href="?main=mycart" class="navbar-btn btn-default btn pull-right"><i class="fa fa-shopping-cart"></i> Rp. <?php echo number_format($cart[0]); ?>,-</a>
			</div>
		</div>
		<script type="text/javascript" src="../engine/wowslider.js"></script>
		<script type="text/javascript" src="../engine/script.js"></script>
		<script src="../js/dataTables/jquery.dataTables.js"></script>
		<script src="../js/dataTables/dataTables.bootstrap.js"></script>
	</body>
</html>