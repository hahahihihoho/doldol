<?php include 'header3.php';?>
<title>Kemeja Pria - Kemeja Pria Terbaru</title>
 
  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-11">
          <div class="aa-product-catg-content">
            <h2 style='text-align: center;'>Kemeja Pria</h2>
            <?php
              $kemejaall = $app->loadProdukKemejaAll();
            ?> 
              <p style='text-align: center;'>Terdapat <b><?php echo count($kemejaall['listproduk']); ?> produk</b> untuk Kemeja Pria. Semua produk yang ada di Website <b>Ready Stock.</b></p>
              <p style='text-align: center;'>Untuk cek ukuran yang Ready lihat di <b>Detail Produk.</b></p>
            <!-- <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-left">
                <form action="" class="aa-sort-form">
                  <label for="">Sort by</label>
                  <select name="">
                    <option value="1" selected="Default">Default</option>
                    <option value="2">Name</option>
                    <option value="3">Price</option>
                    <option value="4">Date</option>
                  </select>
                </form>
                <form action="" class="aa-show-form">
                  <label for="">Show</label>
                  <select name="">
                    <option value="1" selected="12">12</option>
                    <option value="2">24</option>
                    <option value="3">36</option>
                  </select>
                </form>
              </div>
              <div class="aa-product-catg-head-right">
                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
              </div>
            </div> -->
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
			<?php 
				foreach($kemejaall['listproduk'] as $kemeja){
			?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="detail/<?php echo "$kemeja[link]";?>"><img src="<?php echo "$kemeja[gambar]";?>" alt="<?php echo $kemeja['title'];?>"></a>
                    <a class="aa-add-card-btn" href="detail/<?php echo "$kemeja[link]";?>"><span class="fa fa-search"></span>Detail Produk</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="detail/<?php echo "$kemeja[link]";?>"><?php echo "$kemeja[title]";?></a></h4>
                      <span class="aa-product-price">Rp. <?php echo "$kemeja[harga]";?></span><span class="aa-product-price"><del>Rp. <?php echo "$kemeja[hargaori]";?></del></span>
                    </figcaption>
                  </figure>                         
                  <!-- <div class="aa-product-hvr-content">
                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                    <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>                            
                  </div> -->
                </li>
			<?php
				}
			?>
              </ul>

                <!-- Start Product section -->
                <section id="aa-promo" style="margin-top: -30px;">
                  <div class="container">

                      <div class="col-md-12">
                        <div class="aa-promo-area">
                            <h3 style="text-align: center;">Kategori Fashion Lainnya</h3>


                                <div class="col-md-4" style="height: 50%;">
                                  <a href="celana-pria">
                                  <div class="aa-promo-banner bg-prod-1">                      
                                    <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/april/celana-jeans-small-rips-dark-blue-wb-600x600_0.jpg" alt="img" class="blur-img">
                                    <a href="celana-pria">
                                      <div class="aa-prom-content">
                                        <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Celana Pria</h4>                       
                                      </div>
                                    </a>
                                  </div>
                                  </a>
                                </div>

                                <div class="col-md-4" style="height: 50%;">
                                  <a href="atasan-pria">
                                  <div class="aa-promo-banner bg-prod-1">                      
                                    <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2016/september/longline-t-shirt-basic-black-wb-600x600_0.jpg" alt="img" class="blur-img">
                                    <a href="atasan-pria">
                                      <div class="aa-prom-content">
                                        <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Atasan Pria</h4>                      
                                      </div>
                                    </a>
                                  </div>
                                  </a>
                                </div>

                                <div class="col-md-4" style="height: 50%;">
                                  <a href="luaran-pria">
                                  <div class="aa-promo-banner bg-prod-1">                      
                                    <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/may/jaket-bomber-leather-dark-tosca-wb-600x600_0.jpg" alt="img" class="blur-img">
                                    <a href="luaran-pria">
                                      <div class="aa-prom-content">
                                        <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Luaran Pria</h4>                    
                                      </div>
                                    </a>
                                  </div>
                                  </a>
                                </div>
                        </div>
                        <div style="text-align: center; margin-bottom: 50px;">
                          <a class="aa-browse-btn" href="terbaru" style="margin-top: 10px;">Lihat Semua <span class="fa fa-long-arrow-right"></span></a>
                        </div>
                      </div>
               
                  </div>
                </section>
                <!-- / Product section -->
             
            </div>
           <!--  <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> -->
          </div>
        </div>
       
       
      </div>
    </div>
  </section>
  <!-- / product category -->

  <!-- footer -->  
  <?php require 'footer.php';?>
  <!-- / footer -->

  </body>
</html>