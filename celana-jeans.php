<?php require 'header3.php';?>
<title>Celana Jeans</title>
 

  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-11">
          <div class="aa-product-catg-content">
            <h2 style='text-align: center;'>Celana Jeans</h2>
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
				$celanaall = $app->loadProdukCelanaJeans();
			?>
              <p>Terdapat <b><?php echo count($celanaall); ?> produk</b> untuk Celana Jeans</p>
              <ul class="aa-product-catg">
                <!-- start single product item -->
			<?php 
				foreach($celanaall as $celana){
			?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="detail/<?php echo "$celana[link]";?>"><img src="<?php echo "$celana[gambar]";?>" alt="<?php echo $celana['title']; ?>"></a>
                    <a class="aa-add-card-btn" href="detail/<?php echo "$celana[link]";?>"><span class="fa fa-search"></span>Detail Produk</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="detail/<?php echo "$celana[link]";?>"><?php echo "$celana[title]";?></a></h4>
                      <span class="aa-product-price">Rp. <?php echo "$celana[harga]";?></span><span class="aa-product-price"><del>Rp. <?php echo "$celana[hargaori]";?></del></span>
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
                      <h3 style="text-align: center;">Kategori Celana Lainnya</h3>
                    </div>
                      <div class="col-md-12 col-md-offset-2">
                        <div class="aa-promo-area">
                          <div class="col-md-4" style="height: 50%;">
                            <a href="celana-jogger">
                            <div class="aa-promo-banner bg-prod-1">                      
                              <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/march/celana-jogger-chino-cargo-camouflage-army-wb-600x600_0.jpg" alt="img" class="blur-img">
                              <a href="celana-jogger">
                                <div class="aa-prom-content">
                                  <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Celana Jogger</h4>                       
                                </div>
                              </a>
                            </div>
                            </a>
                          </div>

                          <div class="col-md-4" style="height: 50%;">
                            <a href="celana-chino">
                            <div class="aa-promo-banner bg-prod-1">                      
                              <img src="http://www.frozenshop.com/image/cache/data/Baju-Pria/2017/march/celana-formal-chino-wool-blue-wb-600x600_0.jpg" alt="img" class="blur-img">
                              <a href="celana-chino">
                                <div class="aa-prom-content">
                                  <h4 style="color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255); padding: 70px; margin: -40px 25px 10px;">Celana Chino</h4>                       
                                </div>
                              </a>
                            </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    <div class="col-md-12">
                      <div style="text-align: center; margin-bottom: 50px;">
                        <a class="aa-browse-btn" href="celana-pria" style="margin-top: 10px;">Lihat Semua <span class="fa fa-long-arrow-right"></span></a>
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