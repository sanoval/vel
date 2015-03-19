<?php connect_db(); 
	$q=""; 
	$par_a=""; $par_b=""; $kat=""; $cat="";
	if(isset($_GET['key'])){
		$key = $_GET['key'];
	}
	if(isset($_GET['cat'])){
		if($_GET['cat']=="all"){
			if($key==""){
				$par_a = "WHERE kd_barang = '$key' OR namabar = '$key'";
				$par_b = "WHERE namatoko = '$key'";
			}else{
				$par_a = "WHERE kd_barang LIKE '$key%' OR namabar LIKE '$key%'";
				$par_b = "WHERE namatoko LIKE '$key%'";
			}
		}else{
			if($key==""){
				$par_a = "WHERE kd_barang = '$key' OR namabar = '$key'";
				$par_b = "WHERE namatoko = '$key'";
			}else{
				$cat = $_GET['cat'];
				$par_a = "WHERE kd_barang LIKE '$key%' OR namabar LIKE '$key%' AND kodekat = '$cat'";
				$par_b = "WHERE namatoko LIKE '$key%'";
			}
		}
	}
?>
<div class="container pad-bottom-70 pad-top-40">
	<div class="row">
		<div class="col-md-12">
			<h2 class="text-glow"><i class="fa fa-search"></i> Hasil Pencarian : <em>"<?php echo $key; ?>"</em></h2>
		</div>
	</div>
	<div class="panel panel-default">
		<?php 
			$q_2 = mysql_query("SELECT COUNT(*) AS jml FROM tbbarang ".$par_a);
			$res = mysql_fetch_row($q_2);
			$q_3 = mysql_query("SELECT COUNT(*) AS jml FROM tbuser ".$par_b);
			$re = mysql_fetch_row($q_3);
		?>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#products-pills" data-toggle="tab">Barang (<?php echo $res[0]; ?>)</a></li>
                <li><a href="#store-pills" data-toggle="tab">Toko (<?php echo $re[0]; ?>)</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="products-pills">
                    <h4>&nbsp;</h4>
					<?php 
					$dataPerPage = 4;
			        $showPage = 0;
				    if (isset($_GET['page']))
				      {
				        $noPage = $_GET['page'];
				    }else $noPage = 1;
				    $offset = ($noPage - 1) * $dataPerPage;
                    $q_1 = mysql_query("SELECT * FROM tbbarang ".$par_a."LIMIT $offset, $dataPerPage") or die(mysql_error());
						if(mysql_num_rows($q_1)==0){
									?><div class="min-hi"><p class="text-center"><em>Tidak Ada Hasil</em></p></div><?php
						}else{
							while($r_1=mysql_fetch_array($q_1)){
					?>
				    <div class="col-lg-3 col-md-4 col-sm-4">
				    	<div class="pad-item btn-default">
				    		<img class="img-responsive img-zoom" src="../config/mythumbnail.php?KB=<?php echo $r_1[0]; ?>">
				    		<h4><?php echo $r_1[0]; ?></h4>
				    		<h4><?php echo $r_1[2]; ?></h4>
				    		<a href="?main=detail_pro&amp;KB=<?php echo $r_1[0] ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Rincian</a>
				    	</div>
				    </div>
				    <?php
			  		}
			        $query = "SELECT COUNT(*) AS jumData FROM tbbarang ".$par_a;
			        $hasil = mysql_query($query);
			        $hasilx = mysql_fetch_array($hasil);
			        $jumData = $hasilx['jumData'];

					// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
					$jumPage = ceil($jumData/$dataPerPage); ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			        	<div class="col-lg-4 pull-right">
				            <div class="bs-example pull-right">
				              <ul class="pagination">
				              <?php if ($noPage > 1){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".($noPage-1)?>">Prev</a></li><?php }
				// memunculkan nomor halaman dan linknya
				                for($page = 1; $page <= $jumPage; $page++){
				                    if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
				                        if (($showPage == 1) && ($page != 2))  echo "";
				                            if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "";
				                                if ($page == $noPage){ ?><li class="active" ><a href="#"><?php echo $page; ?></a></li><?php
				                                }else { ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".$page ?>"><?php echo $page ?></a></li><?php
				                                    $showPage = $page; 
				                                }
				                        }
				                }
				// menampilkan link next
				                if ($noPage < $jumPage){ ?><li><a href="<?php echo $_SERVER['PHP_SELF']."?main=mystore&page=".($noPage+1) ?>">Next</a></li><?php } ?>
				              </ul>
				            </div>
			        	</div>
					</div>
				<?php } ?>
				</div>
                <div class="tab-pane fade" id="store-pills">
                    <h4>&nbsp;</h4>
                    <?php
                    $q_4 = mysql_query("SELECT * FROM tbuser ".$par_b) or die(mysql_error());
						if(mysql_num_rows($q_4)==0){
									?><div class="min-hi"><p class="text-center"><em>Tidak Ada Hasil</em></p></div><?php
						}else{
							while($r_4=mysql_fetch_array($q_4)){
					?>
				    <div class="col-lg-3 col-md-4 col-sm-4">
				    	<div class="pad-item btn-default">
				    		<img class="img-responsive img-zoom" src="../config/usrthumbnail.php?KB=<?php echo $r_4[0]; ?>">
				    		<h4><?php echo $r_4[3]; ?></h4>
				    		<h4><?php echo $r_4[2]; ?></h4>
				    		<a href="?main=store&amp;kb=<?php echo $r_4[0] ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Lihat toko</a>
				    	</div>
				    </div>
				    <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</div>