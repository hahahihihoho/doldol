<?php include 'header3.php';?>
<title>Kaos Polo</title>

  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-11">
          <div class="aa-product-catg-content">
            <h2 style='text-align: center;'>Kaos Polos</h2>
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
			<?php
				$atasanall = $app->loadProdukKaosPolo();
			?>
              <p>Terdapat <b><?php echo count($atasanall); ?> produk</b> untuk Kaos Polo</p>
              <ul class="aa-product-catg">
                <!-- start single product item -->
			<?php 
				foreach($atasanall as $atasan){
			?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="detail/<?php echo "$atasan[link]";?>"><img src="<?php echo "$atasan[gambar]";?>" alt="<?php echo $atasan['title']; ?>"></a>
                    <a class="aa-add-card-btn" href="detail/<?php echo "$atasan[link]";?>"><span class="fa fa-search"></span>Detail Produk</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="detail/<?php echo "$atasan[link]";?>"><?php echo "$atasan[title]";?></a></h4>
                      <span class="aa-product-price">Rp. <?php echo "$atasan[harga]";?></span><span class="aa-product-price"><del>Rp. <?php echo "$atasan[hargaori]";?></del></span>
                    </figcaption>
                  </figure>                         
                 
                </li>
			<?php
				}
			?>
              </ul>

              <!-- Start Product section -->
              <section id="aa-promo">
                <div class="container">

                    <div class="col-md-12">
                      <div class="aa-promo-area">
                          <h3 style="text-align: center;">Kategori Atasan Lainnya</h3>


                              <div class="col-md-4" style="height: 50%;">
                                <a href="kaos">
                                <div class="aa-promo-banner bg-prod-1">                      
                                  <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/march/kaos-alan-walker-front-and-back-black-wb-600x600_0.jpg" alt="img" class="blur-img">
                                  <a href="kaos">
                                    <div class="aa-prom-content">
                                      <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Kaos</h4>                       
                                    </div>
                                  </a>
                                </div>
                                </a>
                              </div>

                              <div class="col-md-4" style="height: 50%;">
                                <a href="kaos-longline">
                                <div class="aa-promo-banner bg-prod-1">                      
                                  <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/may/longline-t-shirt-black-and-white-wb-600x600_0.jpg" alt="img" class="blur-img">
                                  <a href="kaos-longline">
                                    <div class="aa-prom-content">
                                      <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Kaos Longline</h4>                       
                                    </div>
                                  </a>
                                </div>
                                </a>
                              </div>

                      </div>
                      <div style="text-align: center; margin-bottom: 50px;">
                        <a class="aa-browse-btn" href="atasan-pria" style="margin-top: 10px;">Lihat Semua <span class="fa fa-long-arrow-right"></span></a>
                      </div>
                    </div>
             
                </div>
              </section>
              <!-- / Product section -->
             
            </div>
            <!-- <div class="aa-product-catg-pagination">
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