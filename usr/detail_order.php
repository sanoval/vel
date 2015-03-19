<?php connect_db();
if(isset($_GET['trx'])){
	$trx=$_GET['trx'];
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
									  	$q=mysql_query("select tbuser.username,tbuser.namatoko,transactions.trx,transactions.gtotal,transactions.request 
											from tbuser,transactions where
											tbuser.username=transactions.seller and md5(transactions.trx)='$trx'")or die(mysql_error());
											$r=mysql_fetch_row($q);
											$tgl=substr($r[4],8,2); $bln=substr($r[4],5,2); $thn=substr($r[4],0,4);
										?>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3">
									<img class="img-responsive" src="../config/usrthumbnail.php?KB=<?php echo $r[0]; ?>">
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9">
									<h4><a href="?main=store&amp;kb=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a></h4>
									<p><?php echo $r[2]; ?></p>
									<p><?php spell_month($tgl,$bln,$thn); ?></p>
									<p><em>Menunggu konfirmasi dari penjual</em></p>
									<p>
										<a href="#" id="back" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
										<a href="#" id="cancel" data-target="#cancel_dialog" data-toggle="modal" class="btn btn-success">Batalkan Permintaan</a>
									</p>
								</div>
							</div>
                </div>
                <div class="panel-body">
										<h2><i class="fa fa-shopping-cart"></i> Detail Pesanan</h2>
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
    	                		$q_1=mysql_query("select detail.kd_barang, tbbarang.namabar, detail.harga, detail.qty, detail.total
													from detail,tbbarang where md5(detail.trx)='$trx' and tbbarang.kd_barang=detail.kd_barang") 
													or die(mysql_error());
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
												<h2><i class="fa fa-truck"></i> Detail Pengiriman</h2>
												<p>Data ini diperlukan untuk mengirimkan pesanan ke tempat anda!</p>
											</div>
										</div>
										<?php 
											$qq = mysql_query("select * from kirim where md5(trx)='$trx'");
											$rr = mysql_fetch_row($qq);
										?>
										<div class="row">
											<form action="../config/action.php" method="post" id="delform" class="form-horizontal" role="form">
												<input type="hidden" name="trx" value="<?php echo $trx; ?>">
												<div class="form-group">
													<label for="penerima" class="col-lg-3 col-md-3 col-sm-3 control-label">Nama Penerima</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<input type="text" id="penerima" class="form-control" name="penerima" required placeholder="Nama Penerima">
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
														<textarea class="form-control" name="alamat" rows="4" id="alamat"
														required placeholder="Format: KAMPUNG; RT/RW;"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label for="nohp" class="col-lg-3 col-md-3 col-sm-3 control-label">Nomor HP</label>
													<div class="col-lg-4 col-md-4 col-sm-4">
														<input type="number" min="0" id="nohp" class="form-control" name="nohp" required placeholder="Nomor HP">
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-7 col-md-7 col-sm-7">
														<div class="pull-right" id="on">
															<button type="button" id="turn_off" class="btn btn-default">Batal</button>
															<button type="submit" class="btn btn-success" id="accept" name="update_request">Simpan Perubahan</button>
														</div>
														<div class="pull-right" id="off">
															<button type="button" id="turn_on" class="btn btn-success">Ubah</button>
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
		<div class="modal fade" id="cancel_dialog" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">&times;</button>
							<h4><i class="fa fa-question-circle"></i> Batal Permintaan Pesanan</h4>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-6">
											<p>Anda yakin ingin membatalkannya?</p>
										</div>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="pull-right">
												<button class="btn btn-default" data-dismiss="modal">Batal</button>
												<button class="btn btn-success" id="confirm">Ya</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
<script type="text/javascript">
	$(document).ready(function(){
		function disable_input(){
			$("#penerima").attr("disabled","disabled");
			$("#provinsi").attr("disabled","disabled");
			$("#kota").attr("disabled","disabled");
			$("#kec").attr("disabled","disabled");
			$("#kel").attr("disabled","disabled");
			$("#nohp").attr("disabled","disabled");
			$("#alamat").attr("disabled","disabled");
		};
		function enable_input(){
			$("#penerima").removeAttr("disabled","disabled");
			$("#provinsi").removeAttr("disabled","disabled");
			$("#kota").removeAttr("disabled","disabled");
			$("#kec").removeAttr("disabled","disabled");
			$("#kel").removeAttr("disabled","disabled");
			$("#nohp").removeAttr("disabled","disabled");
			$("#alamat").removeAttr("disabled","disabled");
		};
		function default_value(){
			var penerima="<?php echo $rr[1]; ?>";
			var IDProv="<?php echo $rr[2]; ?>";
			var IDKota="<?php echo $rr[3]; ?>";
			var IDKec="<?php echo $rr[4]; ?>";
			var IDKel="<?php echo $rr[5]; ?>";
			var alamat="<?php echo $rr[6]; ?>";
			var nohp="<?php echo $rr[7]; ?>";
			$("#penerima").val(penerima);
			$("#alamat").html(alamat);
			$("#nohp").val(nohp);
			$("#provinsi").load("../config/load.php","op=getprov&IDProv="+IDProv);
			$("#kota").load("../config/load.php","op=getkota&IDProv="+IDProv+"&IDKota="+IDKota);
			$("#kec").load("../config/load.php","op=getkec&IDKota="+IDKota+"&IDKec="+IDKec);
			$("#kel").load("../config/load.php","op=getkel&IDKec="+IDKec+"&IDKel="+IDKel);
		};
		$("#alert").hide();
		default_value();
		disable_input();
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
		$("#on").hide();
		$("#back").click(function(){
			window.history.back();
		});
		$("#turn_on").click(function(){
			$("#on").show();
			$("#off").hide();
			enable_input();
		});
		$("#turn_off").click(function(){
			$("#on").hide();
			$("#off").show();
			default_value();
			disable_input();
		});
		$("#confirm").click(function(){
			document.location="../config/action.php?act=canceltrx&trx=<?php echo $trx; ?>";
		});
	});
</script>	