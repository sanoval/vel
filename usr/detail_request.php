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
									  	$q=mysql_query("SELECT tbuser.username,tbuser.nama,transactions.trx,transactions.gtotal,transactions.request,transactions.trx,
									  		transactions.confirm from tbuser,transactions where
											tbuser.username=transactions.username and md5(transactions.trx)='$trx'")or die(mysql_error());
											$r=mysql_fetch_row($q);
											$tgl=substr($r[4],8,2); $bln=substr($r[4],5,2); $thn=substr($r[4],0,4);
										?>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3">
									<img class="img-responsive" src="../config/usrthumbnail.php?KB=<?php echo $r[0]; ?>">
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9">
									<h4>Dari : <a href="?main=store&amp;kb=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a></h4>
									<p><?php echo $r[2]; ?></p>
									<?php if($r[6]=='0000-00-00'){ ?>
										<p><?php echo "Tanggal Pesan "; spell_month($tgl,$bln,$thn); $tgl=substr($r[6],8,2); $bln=substr($r[6],5,2); $thn=substr($r[6],0,4); ?></p>
										<p><em>Belum Dikonfirmasi</em></p>
										<p>
											<a href="#" id="back" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
											<a href="#" id="cancel" data-target="#cancel_dialog" data-toggle="modal" class="btn btn-success"><i class="fa fa-exclamation-circle"></i> Tolak Pemintaan</a>
											<a href="#" id="confirm_request" class="btn btn-default"><i class="fa fa-check"></i> Konfirmasi Permintaan</a>
										</p>
									<?php }else{ ?>Dikonfirmasi tanggal <?php spell_month($tgl,$bln,$thn); ?> <i class="fa fa-check"></i></em></p>
										<p>Batal Otomatis Tanggal <?php $tgl=$tgl+3; spell_month($tgl,$bln,$thn); ?></p>
									<p>
										<a href="#" id="back" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
									</p>
									<?php } ?>
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
											<div class="col-lg-12 col-md-12 col-sm-12">
												<h2><i class="fa fa-truck"></i> Detail Pengiriman</h2>
												<p>Data ini diperlukan untuk mengirimkan pesanan ke tempat anda!</p>
											</div>
										</div>
										<?php 
											$qq = mysql_query("select kirim.penerima,provinsi.nama,kabupaten.nama,kecamatan.nama,kelurahan.nama,kirim.alamat,kirim.nohp
											from kirim,provinsi,kabupaten,kecamatan,kelurahan where provinsi.idprovinsi=kirim.idprovinsi
											and kabupaten.idkabupaten=kirim.idkabupaten and kecamatan.idkecamatan=kirim.idkecamatan and
											kelurahan.idkelurahan=kirim.idkelurahan and md5(kirim.trx)='$trx'")or die(mysql_error());
											$rr = mysql_fetch_row($qq);
										?>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Penerima</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[0]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Provinsi</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[1]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Kota/Kabupaten</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[2]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Kecamatan</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[3]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Desa/Kelurahan</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[4]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Alamat</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[5]; ?></div>
											</strong>
										</div>
										<div class="row">
											<strong>
												<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">Nomor HP</div>
												<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">: <?php echo $rr[6]; ?></div>
											</strong>
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
							<h4><i class="fa fa-question-circle"></i> Tolak Permintaan Pesanan</h4>
						</div>
						<form action="../config/action.php" method="post" class="form-horizontal" role="form">
							<input type="hidden" name="trx" value="<?php echo $r[5] ?>">
							<input type="hidden" name="to" value="<?php echo $r[0] ?>">
							<div class="modal-body">
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-12">
												<p>Alasan Membatalkan Pesanan</p>
												<div class="form-group">
													<label for="reason" class="control-label col-lg-3 col-md-3 col-sm-3">Alasan</label>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<textarea class="form-control" readonly rows="4" name="reason" id="reason" placeholder="Alasan anda membatalkan permintaan"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-11 col-md-1 col-sm-11">
												<div class="pull-right">
													<button class="btn btn-default" data-dismiss="modal">Batal</button>
													<button class="btn btn-success" name="reason_msg" id="confirm">Kirim</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
				</div>
			</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#confirm_request").click(function(){
			document.location="../config/action.php?act=confirm_request&trx=<?php echo $trx; ?>";
		});
		$("#back").click(function(){
			window.history.back();
		});
	});
</script>	