<?php connect_db();
if(isset($_GET['trx_for'])){
	$trx_for=$_GET['trx_for'];
}else{
	?><script>window.history.back()</script><?php
}
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-lg-12">
            <div class="panel panel-default no-radius">
                <div class="panel-heading">
                    <?php
									  	$q=mysql_query("select namatoko from tbuser where username='$trx_for'")or die(mysql_error());
											$r=mysql_fetch_row($q);
										?>
               	<div class="text-center"><h4>Nama Toko : <?php echo $r[0]; ?></h4></div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                    	<table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                        		<tr>
                        			<th>Kode Produk</th>
                        			<th>Nama Produk</th>
                        			<th>Harga</hd>
                        			<th>Jumlah</th>
                        			<th>Total</th>
                        		</tr>
                            </thead>
                            <tbody>
    	                	<?php
    	                		$q_1=mysql_query("SELECT tmp.kd_barang, tbbarang.namabar, tmp.harga, tmp.qty, tmp.total, tbuser.namatoko, tbbarang.qty FROM tbuser,tmp,tbbarang WHERE tmp.username='".$_SESSION['username_usr']."' AND tbbarang.kd_barang=tmp.kd_barang and tbuser.username = tbbarang.username and tbbarang.username='$trx_for'") or die(mysql_error());
    	                		if(mysql_num_rows($q_1)==0){
														?><script>document.location="?main=mycart";</script><?php
													}else{
														$gtotal=0;
    	                			while($r_1=mysql_fetch_array($q_1)){
															$gtotal=$gtotal+$r_1[4];
    	                	?>
                        		<tr>
                        			<td><?php echo $r_1[0]; ?></td>
                        			<td><?php echo $r_1[1]; ?></td>
                        			<td><?php echo "Rp. ".number_format($r_1[2]).",-"; ?></td>
                        			<td><?php echo $r_1[3]; ?></td>
                        			<td><?php echo "Rp. ".number_format($r_1[4]).",-"; ?></td>
                        		</tr>   
                    		<?php } } ?>
                          </tbody>
                          <tfoot> 
                        		<tr>
															<td></td>
                        			<td></td>
                        			<td></td>
                        			<td>Grand Total :</td>
                        			<td><?php echo "Rp. ".number_format($gtotal).",-"; ?></td>
                        		</tr>
													</tfoot>
                    	</table>
                    </div>    
        	    </div>
                <div class="panel-footer bg-green">
                	<div class="container">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:30px;">
												<h2><i class="fa fa-users"></i> Data Penerima</h2>
												<p>Data ini diperlukan untuk mengirimkan pesanan ke tempat anda!</p>
											</div>
										</div>
										<?php 
											$qq = mysql_query("select * from tbuser where username='".$_SESSION['username_usr']."'");
											$rr = mysql_fetch_row($qq);
										?>
										<div class="row">
											<form action="../config/action.php" method="post" class="form-horizontal" role="form">
												<input type="hidden" name="id" value="<?php echo $trx_for; ?>">
												<div class="form-group">
													<label for="penerima" class="col-lg-3 col-md-3 col-sm-3 control-label">Nama Penerima</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<input type="text" id="penerima" class="form-control" value="<?php echo $rr[2]; ?>" name="penerima" required placeholder="Nama Penerima">
													</div>
												</div>
												<div class="form-group">
													<label for="provinsi" class="col-lg-3 col-md-3 col-sm-3 control-label">Provinsi</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<select name="provinsi" id="provinsi" class="form-control" required></select>
													</div>
												</div>
												<div class="form-group">
													<label for="kota" class="col-lg-3 col-md-3 col-sm-3 control-label">Kota/Kabupaten</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<select name="kota" id="kota" class="form-control" required></select>
													</div>
												</div>
												<div class="form-group">
													<label for="kec" class="col-lg-3 col-md-3 col-sm-3 control-label">Kecamatan</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<select name="kec" id="kec" class="form-control" required></select>
													</div>
												</div>
												<div class="form-group">
													<label for="kel" class="col-lg-3 col-md-3 col-sm-3 control-label">Desa/Kelurahan</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<select name="kel" id="kel" class="form-control" required></select>
													</div>
												</div>
												<div class="form-group">
													<label for="Alamat" class="col-lg-3 col-md-3 col-sm-3 control-label">Alamat</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<textarea class="form-control" name="alamat" rows="4" 
														required placeholder="Format: KAMPUNG; RT/RW;"><?php echo $rr[5]; ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label for="nohp" class="col-lg-3 col-md-3 col-sm-3 control-label">Nomor HP</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<input type="number" min="0" id="nohp" class="form-control" value="<?php echo $rr[6]; ?>" name="nohp" required placeholder="Nomor HP">
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-7 col-md-7 col-sm-7">
														<div class="pull-right">
															<button type="button" id="back" class="btn btn-default">Batal</button>
															<button type="submit" class="btn btn-success" id="accept" name="request">Lanjukan Memesan</button>
														</div>
													</div>
												</div>
											</form>
										</div>
               		</div>
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
	$("#back").click(function(){
		document.location="?main=mycart";
	})
</script>	