<?php
	$kb="";
	//koneksi database
	function connect_db(){
		$dbname="dbmall";
		$conn = mysql_connect("localhost","root","");
		if($conn){
			$sele = mysql_select_db($dbname);
			if(!$sele){
				echo mysql_error();
			}
		}
	}

	//login user
	function login_user_check(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$q_1 = mysql_query("SELECT * FROM tbuser WHERE username = '$username' AND password = '$password' AND level = 'user'") or die(mysql_error());
		if(mysql_num_rows($q_1)==1){
			$r_1 = mysql_fetch_row($q_1);
			//masuk ke session
			$_SESSION['username_usr'] = $username;
			$_SESSION['password_usr'] = $password;
			$_SESSION['name_usr'] = $r_1[2];
			$_SESSION['level_usr'] = $r_1[9];
			//coba cookies
			setcookie("username_usr", $username, time() + (86400),  "/");
			setcookie("password_usr", $password, time() + (86400),  "/");
			setcookie("name_usr", $r_1[2], time() + (86400),  "/");
			setcookie("level_usr", $r_1[9], time() + (86400),  "/");
			?><script type="text/javascript">document.location="../usr/";</script><?php
		}else{
			?><script type="text/javascript">alert("Username atau Password yang anda masukan salah!"); window.history.back();</script><?php
		}
	}

	//login user
	function login_adm_check(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$q_1 = mysql_query("SELECT * FROM tbuser WHERE username = '$username' AND password = '$password' AND level = 'admin'") or die(mysql_error());
		if(mysql_num_rows($q_1)==1){
			$r_1 = mysql_fetch_row($q_1);
			//masuk ke session
			$_SESSION['username_usr'] = $username;
			$_SESSION['password_usr'] = $password;
			$_SESSION['name_usr'] = $r_1[2];
			$_SESSION['level_usr'] = $r_1[9];
			//coba cookies
			setcookie("username_usr", $username, time() + (86400),  "/");
			setcookie("password_usr", $password, time() + (86400),  "/");
			setcookie("name_usr", $r_1[2], time() + (86400),  "/");
			setcookie("level_usr", $r_1[9], time() + (86400),  "/");
			?><script type="text/javascript">document.location="../adm/home.php";</script><?php
		}else{
			?><script type="text/javascript">alert("Username atau Password yang anda masukan salah!"); window.history.back();</script><?php
		}
	}

	//logout
	function logout_session(){
		unset($_SESSION['username_usr']);
		unset($_SESSION['password_usr']);
		unset($_SESSION['name_usr']);
		unset($_SESSION['level_usr']);
		setcookie("username_usr", "", time() - (86400),  "/");
		setcookie("password_usr", "", time() - (86400),  "/");
		setcookie("name_usr", "", time() - (86400),  "/");
		setcookie("level_usr", "", time() - (86400),  "/");
		?><script type="text/javascript">document.location="../";</script><?php
	}

	//periksa cookie
	function cookie_check($path,$sess){
		if(isset($_COOKIE['username_usr'])){
			if($sess=false){
				session_start();
			}
			$_SESSION['username_usr'] = $_COOKIE['username_usr'];
			$_SESSION['password_usr'] = $_COOKIE['password_usr'];
			$_SESSION['name_usr'] = $_COOKIE['name_usr'];
			$_SESSION['level_usr'] = $_COOKIE['level_usr'];
			?><script type="text/javascript">document.location="<?php echo $path ?>";</script><?php
		}
	}

	//admin user
	function admin_level(){
		session_start();
		if(isset($_SESSION['username_usr'])){
			if($_SESSION['level_usr']<>"admin"){
				?><script type="text/javascript">alert("Akses Ditolak!"); window.history.back();</script><?php
			}
		}
	}

	//level user
	function user_level(){
		session_start();
		if(isset($_SESSION['username_usr'])){
			if($_SESSION['level_usr']<>"user"){
				?><script type="text/javascript">alert("Akses Ditolak!"); window.history.back();</script><?php
			}
		}else{
			if(count($_COOKIE)>0){
				$path = "../usr";
				$sess=true;
				cookie_check($path,$sess);
			}else{
				?><script type="text/javascript">alert("Silakan Login terlebih dahulu!"); window.history.back();</script><?php
			}
		}
	}

	//main page user
	function main_page_user(){
		if(!isset($_GET['main'])){
			$main = "default.php";
		}else{
			$main = "../usr/".$_GET['main'].".php";
		}if(file_exists($main)){
			include $main;
		}else{ ?>
	<div class="container pad-bottom-70 pad-top-40" style="min-height:668px">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-glow text-center">Error 404 (Halaman Tidak Ditemukan!)</h2>
				<p class="text-glow text-center">Klik Tautan ini untuk kembali ke beranda</p>
				<p class="text-center"><a href="?main=default" class="btn btn-default"><i class="fa fa-hand-o-up"></i> MyToko</a></p>
			</div>
		</div>
	</div>
		<?php
		}
	}

	//user level check
	function general_level(){
		session_start();
		if(isset($_SESSION['username_usr']) || isset($_SESSION['password_usr'])){
			?><script type="text/javascript">window.history.back();</script><?php
		}
	}
	//hapus data barang
	function delete_prod($kb){
		$q_1 = mysql_query("DELETE FROM tbbarang WHERE kd_barang = '$kb'");
	}
	//tambah data barang
	function addbar_process(){
		session_start();
		$kode = strtoupper($_POST['kode']);
		$nama = $_POST['nama'];
		$beli = $_POST['beli'];
		$user = $_SESSION['username_usr'];
		$jual = $_POST['jual'];
		$stok = $_POST['qty'];
		$kat = $_POST['kat'];
		$desk = $_POST['desc'];
		$tmpName = $_FILES['foto']['tmp_name'];
			$fp = fopen($tmpName,'r');
			$dataimg = fread($fp, filesize($tmpName));
			$dataimg = addslashes($dataimg);
			fclose($fp);

		$q_1 = mysql_query("SELECT * FROM tbbarang WHERE kd_barang = '$kode'");
		if(mysql_num_rows($q_1)==1){
			?><script type="text/javascript">alert("Kode barang sudah ada!");</script><?php
		}else{
			$q_1 = mysql_query("INSERT INTO tbbarang values('$kode','$user','$nama','$beli','$jual','$stok','$kat','$desk','$dataimg')") or die(mysql_error());
			?><script type="text/javascript">alert("Data ditambahkan"); document.location="../usr/?main=mystore";</script><?php
		}
	}
	//ubah data barang
	function editbar_process(){
		session_start();
		$kode = strtoupper($_POST['kode']);
		$nama = $_POST['nama'];
		$beli = $_POST['beli'];
		$user = $_SESSION['username_usr'];
		$jual = $_POST['jual'];
		$stok = $_POST['qty'];
		$kat = $_POST['kat'];
		$desk = $_POST['desc'];
		$tmpName = $_FILES['foto']['tmp_name'];
		if($tmpName==""){
			$q_1 = mysql_query("UPDATE tbbarang SET username = '$user', namabar = '$nama', beli = '$beli', harga = '$jual', qty = '$stok', kodekat = '$kat', deskripsi = '$desk' WHERE kd_barang = '$kode'");
		}else{
			$fp = fopen($tmpName,'r');
			$dataimg = fread($fp, filesize($tmpName));
			$dataimg = addslashes($dataimg);
			fclose($fp);
			$q_1 = mysql_query("UPDATE tbbarang SET username = '$user', namabar = '$nama', beli = '$beli', harga = '$jual', qty = '$stok', kodekat = '$kat', deskripsi = '$desk', foto = '$dataimg' WHERE kd_barang = '$kode'");
		}
		if(!$q_1){
			?><script type="text/javascript">alert("Ubah data gagal!"); window.history.back();</script><?php
		}else{
			?><script type="text/javascript">alert("Data diubah!"); document.location="../usr/?main=mystore";</script><?php
		}
	}
	//periksa data barang sebelum masuk keranjang
	function product_check($kb, $user, $cart){
		$cart = $cart;
		$username = $user;
		$q_1=mysql_query("SELECT * FROM tbbarang WHERE kd_barang='$kb'");
		$r_1=mysql_fetch_row($q_1);
		$kd_barang = $kb;
		$harga = $r_1[4];
		cart_proc($username, $kd_barang, $harga, $cart);
	}

	//proses masuk ke tmp
	function cart_proc($username, $kd_barang, $harga, $cart){
		//keranjang tambah
		if($cart=="add"){
			$q_1=mysql_query("SELECT * FROM tmp WHERE username='$username' AND kd_barang='$kd_barang'");
			if(mysql_num_rows($q_1)=="1"){
				$q_2=mysql_query("UPDATE tmp SET qty=qty+1, total=$harga*qty WHERE username='$username' AND kd_barang='$kd_barang'") or die("salah Q_2 update");
			}else{
				$q_2=mysql_query("INSERT INTO tmp VALUES('$username','$kd_barang','$harga','1','$harga')") or die("Salah Q_2 Insert");
			}
		} ?><script type="text/javascript">document.location="../usr/?main=mycart";</script><?php
	}

	//ubah qty barang di keranjang belanja
	function update_cart($kd_barang,$qty,$user){
		$q = mysql_query("update tmp set qty='$qty', total=qty*harga where username='$user' and kd_barang='$kd_barang'") or die(mysql_error());
		?><script type="text/javascript">document.location="../usr/?main=mycart";</script><?php
	}

	//hapus keranjang perbarang
	function delete_cart($id,$user){
		$q = mysql_query("delete from tmp where username='$user' and kd_barang='$id'") or die(mysql_error());
		?><script type="text/javascript">document.location="../usr/?main=mycart";</script><?php
	}

	//hapus data keranjang keseluruhan
	function cancel_cart($id,$user,$req){
		$q = mysql_query("delete tmp.* from tmp,tbbarang,tbuser where tbbarang.kd_barang=tmp.kd_barang and tbbarang.username='$id' and tmp.username='$user'") or die(mysql_error());
		if($req==true){
			?><script type="text/javascript">document.location="../usr/?main=mycart";</script><?php
		}
	}

	//checkout keranjang
	function checkout_cart($id,$user,$penerima,$prov,$kota,$kec,$kel,$nohp,$alamat){
		//default trx and unik number
		$unik=0; $decim=100001;
		$q=mysql_query("select * from transactions");
		if(mysql_num_rows($q)==0){
			$trx="TRX100001";
		}else{
			//find trx number
			while($r=mysql_fetch_array($q)){
				$result=substr($r[0],3,6);
				if($decim==$result){
					$decim=$decim+1;
				}
			}
			$trx=strtoupper("TRX".$decim);
			//find unik number
			$qq=mysql_query("select unik from transactions where confirm='0000-00-00'");
			if(mysql_num_rows($qq)<>0){
				while($rr=mysql_fetch_array($qq)){
					if($unik==$rr[0]){
						$unik=$unik+1;
					}
				}
			}
		}
		//insert into transactions
		$q2=mysql_query("select sum(tmp.total) as gtotal from tmp,tbbarang where tbbarang.kd_barang=tmp.kd_barang and tmp.username='$user' 
		and tbbarang.username='$id'") or die(mysql_error()); $r2=mysql_fetch_row($q2);
		$gtotal=$r2[0]+$unik;
		$q3=mysql_query("insert into transactions (trx,unik,username,seller,request,gtotal)
		values('$trx','$unik','$user','$id',CURRENT_DATE(),'$gtotal')") or die(mysql_error());
		//move from tmp to detail (fix)
		$q4=mysql_query("select tmp.* from tmp,tbbarang where tbbarang.kd_barang=tmp.kd_barang and tmp.username='$user' 
		and tbbarang.username='$id'") or die(mysql_error());
		while($r4=mysql_fetch_array($q4)){
			$kd_barang=$r4[1]; $harga=$r4[2]; $qty=$r4[3]; $total=$r4[4];
			$query=mysql_query("insert into detail values('$trx','$kd_barang','$harga','$qty','$total')");
		}
		$req=false;
		cancel_cart($id,$user,$req);
		$q5=mysql_query("insert into kirim values('$trx','$penerima','$prov','$kota','$kec','$kel','$alamat','$nohp','')")or die(mysql_error());
		?><script type="text/javascript">alert('Disimpan ke daftar permintaan pesanan!');document.location="../usr/?main=mywish";</script><?php
	}

	//ubah profil
	function updateprofile($user,$pemilik,$email,$prov,$kota,$kec,$kel,$alamat,$nohp,$rekening,$bank,$atas){
		$q=mysql_query("update tbuser set nama='$pemilik',email='$email',alamat='$alamat',IDProvinsi='$prov',IDKabupaten='$kota',IDKecamatan='$kec',
		IDKelurahan='$kel',nomor='$nohp',norekening='$rekening',
		bank='$bank',atasnama='$atas' where username='$user'") or die(mysql_error());
		?><script type="text/javascript">alert('Profil Diubah!');document.location="../usr/?main=mystore";</script><?php
	}

	//menghapus pesanan yang tidak dikonfirmasi lebih dari 3 hari
	function autodelete(){
		$q=mysql_query("delete from transactions where datediff(curdate(),request)>3 and confirm='0000-00-00'");
	}
	
	//tambah jumblah views otomatis
	function autocount_views($kb){
		$q=mysql_query("update tbbarang set views=views+1 where username<>'".$_SESSION['username_usr']."' and kd_barang='$kb'");
	}

	//fungsi menyebutkan nama bulan
	function spell_month($tgl,$bln,$thn){
		if($bln==01){$nama="Januari";}
		else if($bln==02){$nama="Februari";}
		else if($bln==03){$nama="Maret";}
		else if($bln==04){$nama="April";}
		else if($bln==05){$nama="Mei";}
		else if($bln==06){$nama="Juni";}
		else if($bln==07){$nama="Juli";}
		else if($bln==08){$nama="Agustus";}
		else if($bln==09){$nama="September";}
		else if($bln==10){$nama="Oktober";}
		else if($bln==11){$nama="November";}
		else if($bln==12){$nama="Desember";}
		echo $tgl." ".$nama." ".$thn;
	}
	
	//fungsi batal permintaan pesanan
	function delete_trans($trx,$req){
		$q=mysql_query("delete from transactions where md5(trx)='$trx'")or die(mysql_error());
		if($req==true){
			?><script type="text/javascript">document.location="../usr/?main=mywish";</script><?php
		}
	}

	//fungsi update data pengiriman
	function update_kirim($penerima,$provinsi,$kota,$kec,$kel,$alamat,$nohp,$trx){
		mysql_query("update kirim set penerima='$penerima',IDProvinsi='$provinsi',IDKabupaten='$kota',
		IDKecamatan='$kec',IDKelurahan='$kel',alamat='$alamat',nohp='$nohp'	where md5(trx)='$trx'")or die(mysql_error());
		?><script type="text/javascript">document.location="../usr/?main=detail_order&trx=<?php echo $trx; ?>";</script><?php
	}
	
	function send_cancel_msg($trx,$to,$msg,$user){
		$msg="Nomor transaksi : ".$trx."<br>".$msg;
		mysql_query("insert into inbox values('','$user','$to','$msg',CURRENT_DATE(),'0000-00-00')")or die(mysql_error());
		$req=false;
		$trx=md5($trx);
		delete_trans($trx,$req);
		?><script type="text/javascript">alert("Pesan sudah dikirim");document.location="../usr/?main=request";</script><?php
	}

	function confirm_request($trx){
		mysql_query("update transactions set confirm=CURRENT_DATE() where md5(trx)='$trx'");
		?><script type="text/javascript">alert("Konfirmasi Berhasil");document.location="../usr/?main=request";</script><?php
	}

	function confirm_buy($trx){
		mysql_query("update transactions set bayar=CURRENT_DATE() where md5(trx)='$trx'")or die(mysql_error());
		?><script type="text/javascript">alert("Konfirmasi Berhasil");document.location="../usr/?main=buy_confirm";</script><?php
	}
?>