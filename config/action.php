<?php
	include "config.php";
	session_start();
	if(isset($_SESSION['username_usr'])){
		$user=$_SESSION['username_usr'];
	}else{
		$user="";
	}
	$act=""; $kb=""; $cart="";

	connect_db();
	if(isset($_POST['login_user'])){
		login_user_check();
	}else if(isset($_POST['login_adm'])){
		login_adm_check();
	}else  if(isset($_POST['addbar_btn'])){
		addbar_process();
	}else  if(isset($_POST['editbar_btn'])){
		editbar_process();
	}else if(isset($_GET['act'])){
		$act = $_GET['act'];
		if($act=="delete_bar"){
			$kb = $_GET['kb'];
			delete_prod($kb);
			?><script type="text/javascript">document.location="../usr/?main=mystore";</script><?php
		}else if($act=="canceltrx"){
			$trx=$_GET['trx']; $req=true;
			delete_trans($trx,$req);
		}else if($act=="confirm_request"){
			$trx=$_GET['trx'];
			confirm_request($trx);
		}else if($act=="confirmbuy"){
			$trx=$_GET['trx'];
			confirm_buy($trx);
		}else if($act=="logout"){
			logout_session();
		}
	}else if(isset($_GET['cart'])){
		$cart = $_GET['cart'];
		$kb = $_GET['kb'];
		product_check($kb, $user, $cart);
	}else if(isset($_POST['upd'])){
		$kd_barang = $_POST['kd_barang'];
		$qty = $_POST['qty'];
		update_cart($kd_barang,$qty,$user);
	}else if(isset($_GET['cart_delete'])){
		$id=$_GET['cart_delete'];
		delete_cart($id,$user);
	}else if(isset($_GET['cancel_cart'])){
		$id=$_GET['cancel_cart'];
		$req=true;
		cancel_cart($id,$user);
	}else if(isset($_POST['request'])){
		$id=$_POST['id']; $penerima=$_POST['penerima']; $prov=$_POST['provinsi'];
		$kota=$_POST['kota'];	$kec=$_POST['kec'];	$kel=$_POST['kel']; $nohp=$_POST['nohp'];
		$alamat=$_POST['alamat'];
		checkout_cart($id,$user,$penerima,$prov,$kota,$kec,$kel,$nohp,$alamat);
	}else if(isset($_POST['updateprofile'])){
		$pemilik=$_POST['pemilik']; $email=$_POST['email']; $alamat=$_POST['alamat'];
		$nohp=$_POST['nohp']; $rekening=$_POST['rekening']; $bank=$_POST['bank']; $atas=$_POST['atas'];
		$prov=$_POST['provinsi']; $kota=$_POST['kota']; $kec=$_POST['kec']; $kel=$_POST['kel'];
		updateprofile($user,$pemilik,$email,$prov,$kota,$kec,$kel,$alamat,$nohp,$rekening,$bank,$atas);
	}else if(isset($_POST['update_request'])){
		$penerima=$_POST['penerima']; $provinsi=$_POST['provinsi']; $kota=$_POST['kota']; $kec=$_POST['kec'];
		$kel=$_POST['kel']; $alamat=$_POST['alamat']; $nohp=$_POST['nohp']; $trx=$_POST['trx'];
		update_kirim($penerima,$provinsi,$kota,$kec,$kel,$alamat,$nohp,$trx);
	}else if(isset($_POST['reason_msg'])){
		$trx=$_POST['trx']; $to=$_POST['to']; $msg=$_POST['reason'];
		send_cancel_msg($trx,$to,$msg,$user);
	}else{
		?><script>alert('Command not found!');window.history.back();</script><?php
	}
?>