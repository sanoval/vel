<?php
	include "config.php";
	connect_db();

	//get op command from url
	$op=$_GET['op'];
	if($op=="getprov"){
		if(isset($_GET['IDProv'])){$IDProv=$_GET['IDProv'];}else{$IDProv="";}
		$prov=mysql_query("select Nama,IDProvinsi from provinsi order by Nama");
		?><option value="">--Pilih Provinsi--</option><?php
		while($op=mysql_fetch_array($prov)){
			?><option <?php if($IDProv==$op[1]){ echo "selected"; } ?> value="<?php echo $op[1]; ?>"><?php echo $op[0]; ?></option><?php
		}
	}else if($op=="getkota"){
		$IDProv=$_GET['IDProv'];
		if(isset($_GET['IDKota'])){$IDKota=$_GET['IDKota'];}else{$IDKota="";}
		$kota=mysql_query("select Nama,IDKabupaten from kabupaten where IDProvinsi='$IDProv' order by Nama");
		?><option value="">--Pilih Kabupaten/Kota--</option><?php
		while($op=mysql_fetch_array($kota)){
			?><option <?php if($IDKota==$op[1]){ echo "selected"; } ?> value="<?php echo $op[1]; ?>"><?php echo $op[0]; ?></option><?php
		}
	}else if($op=="getkec"){
		$IDKota=$_GET['IDKota'];
		if(isset($_GET['IDKec'])){$IDKec=$_GET['IDKec'];}else{$IDKec="";}
		$kec=mysql_query("select Nama,IDKecamatan from kecamatan where IDKabupaten='$IDKota' order by Nama");
		?><option value="">--Pilih Kecamatan--</option><?php
		while($op=mysql_fetch_array($kec)){
			?><option <?php if($IDKec==$op[1]){ echo "selected"; } ?> value="<?php echo $op[1]; ?>"><?php echo $op[0]; ?></option><?php
		}
	}else if($op=="getkel"){
		$IDKec=$_GET['IDKec'];
		if(isset($_GET['IDKel'])){$IDKel=$_GET['IDKel'];}else{$IDKel="";}
		$kel=mysql_query("select Nama,IDKelurahan from kelurahan where IDKecamatan='$IDKec' order by Nama");
		?><option value="">--Pilih Desa/Kelurahan--</option><?php
		while($op=mysql_fetch_array($kel)){
			?><option <?php if($IDKel==$op[1]){ echo "selected"; } ?> value="<?php echo $op[1]; ?>"><?php echo $op[0]; ?></option><?php
		}
	}
?>