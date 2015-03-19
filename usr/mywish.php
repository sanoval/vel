<div class="container pad-bottom-70 pad-top-40">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default no-radius">
			<div class="panel-body">
				<div class="col-lg-3 col-md-3 col-sm-3">
					<div class="list-group">
						<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-arrow-circle-o-down"></i> Pembelian</strong></a>
						<a href="?main=mywish" class="list-group-item no-radius list-active"><i class="fa fa-shopping-cart fa-fw"></i> Pesanan Saya</a>
						<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-hand-o-right fa-fw"></i> Konfirmasi Pembayaran</a>
						<a href="?main=recieve_confirm" class="list-group-item no-radius"><i class="fa fa-truck fa-fw"></i> Konfirmasi Tterima Barang</a>
						<a href="?main=archive" class="list-group-item no-radius"><i class="fa fa-folder fa-fw"></i> Arsip Pembelian</a>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-arrow-circle-o-up"></i> Penjualan</strong></a>
						<a href="?main=request" class="list-group-item no-radius"><i class="fa fa-shopping-cart fa-fw"></i> Pesanan</a>
						<a href="?main=deliver_confirm" class="list-group-item no-radius"><i class="fa fa-truck fa-fw"></i> Konfirmasi Pengiriman</a>
						<a href="?main=myarchive" class="list-group-item no-radius"><i class="fa fa-folder fa-fw"></i> Arsip Penjualan</a>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="jumbotron no-radius">
						<h3><i class="fa fa-shopping-cart"></i> Pesanan Saya</h3>
					</div>
					<div class="list-group" style="margin-top:-30px;">
						<?php 
							$dataPerPage = 4;
							if (isset($_GET['page']))
								{
									$noPage = $_GET['page'];
							}else $noPage = 1;
							$offset = ($noPage - 1) * $dataPerPage;
							$q=mysql_query("select tbuser.username,tbuser.namatoko,transactions.trx,transactions.gtotal,transactions.request 
							from tbuser,transactions where
							tbuser.username=transactions.seller and transactions.confirm='0000-00-00' and transactions.bayar='000-00-00'
							and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.username='".$_SESSION['username_usr']."' 
							order by request desc limit $offset, $dataPerPage")
							or die(mysql_error());
							if(mysql_num_rows($q)<>0){
								while($r=mysql_fetch_array($q)){
								$tgl=substr($r[4],8,2); $bln=substr($r[4],5,2); $thn=substr($r[4],0,4);
						?>
						<div class="list-group-item no-radius btn-default">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3">
									<img class="img-responsive" src="../config/usrthumbnail.php?KB=<?php echo $r[0]; ?>">
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9">
									<h4><a href="?main=store&amp;kb=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a></h4>
									<p><?php echo $r[2]; ?></p>
									<p>Grand Total Rp. <?php echo number_format($r[3]); ?>,-</p>
									<p><?php spell_month($tgl,$bln,$thn); ?></p>
									<p><em>Menunggu konfirmasi dari penjual</em></p>
									<div class="pull-right">
										<a href="?main=detail_order&amp;trx=<?php echo md5($r[2]); ?>" class="btn btn-success">Lihat Rincian</a></div>
								</div>
							</div>
						</div>
						<?php
								}
									$query = "SELECT COUNT(*) AS jumData from tbuser,transactions where
									tbuser.username=transactions.seller and transactions.confirm='0000-00-00' and transactions.bayar='000-00-00'
									and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.username='".$_SESSION['username_usr']."'";
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
													<?php if ($noPage > 1){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mywish&page=".($noPage-1)?>">Prev</a></li><?php }
						// memunculkan nomor halaman dan linknya
														for($page = 1; $page <= $jumPage; $page++){
																if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
																		if (($showPage == 1) && ($page != 2))  echo "";
																				if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "";
																						if ($page == $noPage){ ?><li class="active"><a href="#"><?php echo $page; ?></a></li><?php
																						}else { ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mywish&page=".$page ?>"><?php echo $page ?></a></li><?php
																								$showPage = $page; 
																						}
																		}
														}
						// menampilkan link next
														if ($noPage < $jumPage){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mywish&page=".($noPage+1) ?>">Next</a></li><?php } ?>
													</ul>
												</div>
										</div>
							</div>
						<?php }else{ ?>
						<div class="text-center"><h4>Tidak Ada Pesanan</h4></div><?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>