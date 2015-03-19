<?php
	include "config/config.php";
	general_level();
?>
<!DOCTYPE Html>
<html>
	<head>
		<title>MyToko</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<!-- CSS link -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
    	<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="engine/style.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<!-- JQuery -->
		<script type="text/javascript" src="engine/jquery.js"></script>
	</head>
	<body>
		<div class="navbar navbar-default navbar-static-top margin-bottom-80">
			<div class="container">
				<div class="navbar-header">
					<a href="home.php" class="navbar-brand"><i class="fa fa-hand-o-up"></i> MyToko</a>
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse navHeaderCollapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="navbar-form">
							<form>
								<div class="input-group">
									<input class="form-control" type="text" name="skeyword" placeholder="Cari Produk / Toko">
									<span class="input-group-btn">
										<select class="form-control" name="skat">
											<?php 
												connect_db();
												$q_1=mysql_query("SELECT * FROM tbkat ORDER BY namakat ASC") or die(mysql_error());
												echo "<option value=''>Semua Kategori</option>";
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
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Media Sosial <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
								<li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i> Google+</a></li>
								<li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
							</ul>
						</li>
						<li><a href="#kontak">Tentang</a></li>
						<li><a href="#login" data-toggle="modal"><i class="fa fa-user"></i> Login</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Start Of Main Area -->
		<div id="wowslider-container1" class="wowslider-container">
			<div class="ws_images"><ul>
				<li><a href="#" target="_self"><img src="data/images/2.jpg" alt="full screen slider" title="" id="wows1_0"/></a></li>
				<li><img src="data/images/1.jpg" alt="Selamat Datang" title="" id="wows1_1"/></li>
			</ul></div>
			<div class="ws_shadow"></div>
		</div>
		<div class="container pad-bottom-70">
			<div class="row">
				<div class="col-md-12">
					<h1>Selamat datang di CFI</h1>
					<p>Website CFI (Citra Flora Indonesia) kini telah tersedia. Diharapkan dengan adanya website CFI ini, semua informasi tentang produk kami dan informasi terbaru lainnya dapat lebih mudah anda didapatkan.</p>
        			<p>Follow Twitter kami <a href="#" class="btn btn-success"><i class="fa fa-twitter"></i> @cfi_ID</a></p>
				</div>
			</div>
		</div>	
		<!-- End Of Main Area -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text pull-left">© MyToko 2014 - 2015</p>
				<a href="http://youtube.com/sanoval" class="navbar-btn btn-danger btn pull-right"><i class="fa fa-youtube"></i> Subscribe on YouTube</a>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="login" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="form-horizontal" action="config/action.php" method="post">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-power-off"></i> Login Pengguna</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="login-name" class="col-lg-2 control-label"><i class="fa fa-user"></i></label>
								<div class="col-lg-8">
									<input id="login-name" class="form-control" required type="text" name="username" placeholder="Username" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<label for="login-pass" class="col-lg-2 control-label"><i class="fa fa-lock"></i></label>
								<div class="col-lg-8">
									<input id="login-pass" class="form-control" required type="password" name="password" placeholder="Password" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 control-label">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-success" name="login_user">Login</button>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							Belum punya akun? daftar<a href="#"> di sini</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="engine/wowslider.js"></script>
		<script type="text/javascript" src="engine/script.js"></script>
		<script type="text/javascript" src="js/jquery-min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>