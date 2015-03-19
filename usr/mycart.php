<?php connect_db(); 
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-lg-12">
    		<?php $crt=mysql_query("select sum(total) from tmp where username='".$_SESSION['username_usr']."'");
					$cart=mysql_fetch_row($crt);
				?>
	    	<div class="jumbotron no-radius no-bottom" style="background-image: url(../img/cart.jpg) !important;">
						<h2><i class="fa fa-shopping-cart"></i> Keranjang Belanja</h2>
						<p>Total Keseluruhan : Rp. <?php echo number_format($cart[0]) ?>,-</p>
	    	</div>
            <div class="panel panel-default no-radius">
                <div class="panel-heading">
									Daftar belanjaan anda saat ini
                </div>
                <div class="panel-body min-hi-200">
                    <div class="table-responsive">
                    <?php
									  	$q=mysql_query("select distinct(tbuser.namatoko), tbuser.username from tbuser,tbbarang,tmp where tbuser.username=tbbarang.username and tmp.kd_barang=tbbarang.kd_barang and tmp.username='".$_SESSION['username_usr']."'")or die(mysql_error());
										if(mysql_num_rows($q)<>0){
											$i=1;
											while($r=mysql_fetch_array($q)){
										?>
                   		<p><a href="?main=store&amp;kb=<?php echo $r[1]; ?>" class="btn btn-link" data-toggle="tooltip" data-placement="right" title="Lihat Toko"><?php echo $i.". Nama Toko : ".$r[0]; ?></a></p>
                    	<table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                        		<tr>
                        			<th>Kode Produk</th>
                        			<th>Nama Produk</th>
                        			<th>Harga</hd>
                        			<th>Jumlah</th>
                        			<th>Total</th>
                        			<th></th>
                        		</tr>
                            </thead>
                            <tbody>
    	                	<?php
    	                		$q_1=mysql_query("SELECT tmp.kd_barang, tbbarang.namabar, tmp.harga, tmp.qty, tmp.total, tbuser.namatoko, tbbarang.qty FROM tbuser,tmp,tbbarang WHERE tmp.username='".$_SESSION['username_usr']."' AND tbbarang.kd_barang=tmp.kd_barang and tbuser.username = tbbarang.username and tbbarang.username='".$r[1]."'") or die(mysql_error());
    	                		if(mysql_num_rows($q_1)>0){
														$gtotal=0;
    	                			while($r_1=mysql_fetch_array($q_1)){
															$gtotal=$gtotal+$r_1[4];
    	                	?>
                        		<tr>
                        			<td><?php echo $r_1[0]; ?></td>
                        			<td><?php echo $r_1[1]; ?></td>
                        			<td><?php echo "Rp. ".number_format($r_1[2]).",-"; ?></td>
                        			<td>
                        				<form class="form-horizontal" role="form" action="../config/action.php" method="post">
                        					<input type="hidden" name="kd_barang" value="<?php echo $r_1[0]; ?>">
                        					<input type="hidden" name="user" value="<?php echo $_SESSION['username_usr']; ?>">
																	<div class="input-group" style="width:130px;">
																		<input type="number" required value="<?php echo $r_1[3]; ?>" min="1" max="<?php echo $r_1[6]; ?>" name="qty" class="form-control" width="3">
																		<span class="input-group-btn">
																			<button type="submit" name="upd" id="update" class="btn btn-success">Ubah</button>
																		</span>
																	</div>
																</form>
                        			</td>
                        			<td><?php echo "Rp. ".number_format($r_1[4]).",-"; ?></td>
                        			<td>
                        				<a href="../config/action.php?cart_delete=<?php echo $r_1[0]; ?>" class="btn btn-danger">Hapus</a>
                        			</td>
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
                        			<td>
                        				<a href="../config/action.php?cancel_cart=<?php echo $r[1]; ?>" class="btn btn-default">Batalkan</a>
                        				<a href="?main=step_one&amp;trx_for=<?php echo $r[1]; ?>"  class="btn btn-success">Checkout</a>
                        				<!--<a href="../config/action.php?checkout_cart=<php echo $r[1]; ?>"  class="btn btn-success">Checkout</a> -->
                        			</td>
                        		</tr>
													</tfoot>
                    	</table>
                    	<?php } $i=$i++;}else{ ?>
                    	<div class="text-center">Keranjang Belanja Masih Kosong</div>
                    	<?php } ?>
                    </div>    
        	    </div>
                <div class="panel-footer bg-green">
                    Ini adalah keranjang belanja anda, klik tombol "Checkout" untuk melanjutkan / "Batal" untuk membatalkan
                </div>
            </div>
    	</div>
	</div>
</div>	