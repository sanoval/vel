<div class="container pad-bottom-70 pad-top-40">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default no-radius">
			<div class="panel-body">
				<div class="col-lg-3 col-md-3 col-sm-3">
					<div class="list-group">
						<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-arrow-circle-o-down"></i> Pembelian</strong></a>
						<a href="?main=mywish" class="list-group-item no-radius"><i class="fa fa-shopping-cart fa-fw"></i> Pesanan Saya</a>
						<a href="?main=buy_confirm" class="list-group-item no-radius"><i class="fa fa-hand-o-right fa-fw"></i> Konfirmasi Pembayaran</a>
						<a href="?main=recieve_confirm" class="list-group-item no-radius"><i class="fa fa-truck fa-fw"></i> Konfirmasi Tterima Barang</a>
						<a href="?main=archive" class="list-group-item no-radius"><i class="fa fa-folder fa-fw"></i> Arsip Pembelian</a>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item active no-radius" disabled><strong><i class="fa fa-arrow-circle-o-up"></i> Penjualan</strong></a>
						<a href="?main=request" class="list-group-item no-radius list-active"><i class="fa fa-shopping-cart fa-fw"></i> Pesanan</a>
						<a href="?main=deliver_confirm" class="list-group-item no-radius"><i class="fa fa-truck fa-fw"></i> Konfirmasi Pengiriman</a>
						<a href="?main=myarchive" class="list-group-item no-radius"><i class="fa fa-folder fa-fw"></i> Arsip Penjualan</a>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="jumbotron no-radius">
						<h3><i class="fa fa-shopping-cart"></i> Permintaan Pesanan</h3>
					</div>
					<ul class="nav nav-pills">
						<li class="active"><a href="#unconfirmed" data-toggle="tab">Belum Dikonfirmasi</a></li>
						<li><a href="#confirmed" data-toggle="tab">Sudah Dikonfirmasi</a></li>
					</ul>
					<div class="tab-content">
                    	<div class="tab-pane fade in active" id="unconfirmed">
                    		<p>
							<?php 
							$q=mysql_query("SELECT tbuser.username,tbuser.nama,transactions.trx,transactions.gtotal,transactions.request 
							from tbuser,transactions where
							tbuser.username=transactions.username and transactions.confirm='0000-00-00' and transactions.bayar='000-00-00'
							and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.seller='".$_SESSION['username_usr']."' 
							order by request desc") or die(mysql_error());
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
										<p><?php spell_month($tgl,$bln,$thn); ?></p>
										<p><em>Belum dikonfirmasi</em></p>
										<div class="pull-right">
											<a href="?main=detail_request&amp;trx=<?php echo md5($r[2]); ?>" class="btn btn-success">Lihat Rincian</a>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
							</div>
						<?php }else{ ?>
							<p><div class="text-center">Tidak Ada Pesanan</div></p><?php } ?>
							</p>
	                    </div>
	                    <div class="tab-pane fade" id="confirmed">
	                    	<p>                     
							<?php 
							$q=mysql_query("SELECT tbuser.username,tbuser.nama,transactions.trx,transactions.gtotal,transactions.request,transactions.confirm
							from tbuser,transactions where
							tbuser.username=transactions.username and transactions.confirm<>'0000-00-00' and transactions.bayar='000-00-00'
							and transactions.kirim='000-00-00' and transactions.terima='000-00-00' and transactions.seller='".$_SESSION['username_usr']."' 
							order by request desc")
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
										<p><em><?php echo "Dikonfirmasi tanggal "; spell_month($tgl,$bln,$thn); echo" <i class=\"fa fa-check\"></i></em></p>
										<p>Batal Otomatis Tanggal "; $tgl=$tgl+3; spell_month($tgl,$bln,$thn); echo "</p>"; ?></em></p>
										<div class="pull-right">
											<a href="?main=detail_request&amp;trx=<?php echo md5($r[2]); ?>" class="btn btn-success">Lihat Rincian</a></div>
									</div>
								</div>
							</div>
							<?php } ?>
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