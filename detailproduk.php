
<?php 
require 'header2.php';
$data = $app->loadDetailProduk($_GET['id']);
$photo = str_replace("300x300","600x600",$data['produk']['gambar']);
// $data = $app->loadDetailProduk($_GET['id']);
// print_r ($data);
?>
<title><?php echo $data['produk']['title'];?></title>
 

  <!-- product category -->
  <section id="aa-product-details">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-product-details-area">
            <div class="aa-product-details-content">
              <div class="row">
              
                <!-- Modal view slider -->
                <div class="col-md-5 col-sm-5 col-xs-12">                              
                  <div class="aa-product-view-slider">                                
                    <div id="demo-1" class="simpleLens-gallery-container">
                      <div class="simpleLens-container">
                        <div class="simpleLens-big-image-container"><a href="<?php echo $photo; ?>" title="<?php echo $data['produk']['title']; ?>" class="fancybox"><img src="<?php echo $data['produk']['gambar']; ?>" alt="<?php echo $data['produk']['title']; ?>"></a></div>
                      </div>
                      <div class="simpleLens-thumbnails-containers">
                        <a class="fancybox" rel="gallery1" href="<?php echo $photo; ?>" title="<?php echo $data['produk']['title']; ?>">
                          <img src="<?php echo $data['produk']['gambar'] ?>" style="width: 55px;" alt="<?php echo $data['produk']['title']; ?>" />
                        </a>
                        <?php
                        if($data['produk']['gambar2'] != null){ 
                          foreach($data['produk']['gambar2'] as $photos){
                            $photobig = str_replace("70x70","600x600",$photos);
                          ?>
                              <a class="fancybox" rel="gallery1" href="<?php echo $photobig; ?>" title="<?php echo $data['produk']['title']; ?>">
                                <img src="<?php echo $photos; ?>" style="width: 55px;" alt="<?php echo $data['produk']['title']; ?>" />
                              </a>
                      <?PHP
                          }
                        }
                      ?>
                     </div>
                    </div>
                  </div>
                </div>
                <!-- Modal view content -->
                <div class="col-md-7 col-sm-7 col-xs-12">
                
                  <div class="aa-product-view-content">
                    <h3><?php echo $data['produk']['title']; ?></h3>
                    <div class="aa-price-block">
                      <span class="aa-product-view-price aa-product-price"><b>Rp. <?php echo $data['produk']['harga']; ?></b></span>
                      <p class="aa-product-avilability">Ketersediaan: <span style="color: #FF6666;"><?php echo $data['produk']['status']; ?></span></p>
                      <p class="aa-product-avilability">Berat: <span><?php echo $data['produk']['berat']; ?> gram</span></p>
                    </div>
                    <p></p>
                    <?php
                      if($data['produk']['size'] != null){
                    ?>
                    <h4 style="color: #FF6666;">Ukuran yang Ready</h4>
                    <div class="aa-prod-view-size">
                    <?php
                      
                      //$arrsize = $data['produk']['size'];
                      //foreach($arrsize as $size){?>
                        <?php echo $data['produk']['size']; ?>
                    <?php
                     // }
                    ?>
                    </div>
                    
                    <?php
                      }
                    ?>
                    <div class="aa-prod-view-bottom">
                        <a href="#" data-toggle2="tooltip" data-placement="top" title="Beli Produk Ini" data-toggle="modal" data-target="#quick-order-modal" class="aa-add-to-cart-btn">Beli Sekarang</a> 
                    </div>
                    <br/>
                    <p>
                      Bagikan dan Beritahu Teman Kamu!
                      <br/>
                      <div class="addthis_inline_share_toolbox"></div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="aa-product-details-bottom">
              <ul class="nav nav-tabs" id="myTab2">
                <li><a href="#description" data-toggle="tab">Description</a></li>
                <li><a href="#review" data-toggle="tab">Reviews</a></li>                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <p><?php echo $data['produk']['deskripsi']; ?></p>
                </div>
                <div class="tab-pane fade " id="review">
                  <h4>Cek review kami di Instagram dengan hashtag <a href="http://www.instagram.com/explore/tags/testimonifashioncowok" target="_blank" style="color: #FF6666;">#testimonifashioncowok</a></h4>
                </div>            
              </div>
            </div>
            <!-- Related product -->
            <div class="aa-product-related-item">
              <h3>Related Products</h3>
              <ul class="aa-product-catg aa-related-item-slider">
                <!-- start single product item -->
        <?php foreach($data['produk']['mirip'] as $related){ ?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="<?php echo "$related[link]";?>"><img src="<?php echo "$related[photo]";?>" alt="<?php echo $related['title'];?>"></a>
                     <figcaption>
                      <h4 class="aa-product-title"><a href="<?php echo "$related[link]";?>"><?php echo $related['title'];?></a></h4>
                      <span class="aa-product-price">Rp. <?php echo $related['harga'];?></span><span class="aa-product-price"><del>Rp. <?php echo $related['hargaori'];?></del></span>
                    </figcaption>
                  </figure>                     
                  <!-- product badge -->
                  <span class="aa-badge aa-sale" href="#">SALE!</span>
                </li>
                 <!-- start single product item -->
        <?php } ?>
                                                          
              </ul>


               <!-- quick ORDER modal -->                  
              <div class="modal fade" id="quick-order-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">                      
                    <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <div class="row" id="vieworder">
                        <!-- Modal view slider -->
                        <div class="col-md-6 col-sm-6 col-xs-12">                              
                          <div class="aa-product-view-slider">                                
                            <div class="simpleLens-gallery-container" id="demo-1">
                              <div class="simpleLens-container">
                                  <div class="simpleLens-big-image-container">
                                      <a class="simpleLens-lens-image" data-lens-image="../img/view-slider/large/polo-shirt-1.png">
                                          <img src="<?php echo $data['produk']['gambar']; ?>" class="simpleLens-big-image">
                                      </a>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <h3><?php echo $data['produk']['title']; ?></h3>
                          <div class="aa-price-block">
                            <span class="aa-product-view-price">Rp. <?php echo $data['produk']['harga']; ?></span>
                            <p class="aa-product-avilability">Ketersediaan: <span style="color: #FF6666;"><?php echo $data['produk']['status']; ?></span></p>
                            <p class="aa-product-avilability">Berat: <span><?php echo $data['produk']['berat']; ?> gram</span></p>
                             <?php
                              if($data['produk']['size'] != null){
                            ?>
                            <h4>Ready Size</h4>
                            <div class="aa-prod-view-size">
                            <?php
                              
                              //$arrsize = $data['produk']['size'];
                              //foreach($arrsize as $size){?>
                                <?php echo $data['produk']['size']; ?>
                            <?php
                              //}
                            ?>
                            </div>
                            <?php
                              }
                            ?>
                            <div class="aa-prod-view-bottom">
                              <a href="http://www.pin.bbm.com/5baeb5de" class="aa-add-to-cart-btn" target="_blank">Order via BBM (5BAEB5DE)</a>
                              <a href="http://line.me/ti/p/%40fyq6118d" class="aa-add-to-cart-btn" target="_blank">Order via Line@</a>
                            </div>
                          </div>
                        </div>
                        <!-- Modal view content -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="aa-product-view-content">
                            <h3>Cara Order</h3>
                            <p>1. Pilih product yang Kamu inginkan.</p>
                            <p>2. Klik tombol order via Line@ atau BBM diatas, lalu kirimkan data orderdan kamu dengan format berikut, contoh :</p>
                            <p> 
                              <dl>
                                <dd>- Paket JNE(OKE/REG/YES)*</dd>
                                <dd>- Orderan : 1pcs Kemeja Neck Combination Maroon Size L</dd>
                                <dd>- Nama : </dd>
                                <dd>- Alamat Lengkap** : </dd>
                                <dd>- Telp/Hp : </dd>
                              </dl>
                            </p> 
                            <p> *ongkos kirim dan estimasi pengiriman tergantung kota yang di tuju</p>
                            <p> **(Mohon alamat di isi selengkap-lengkapnya, agar paket dapat sampai ke tujuan)</p>
                            <p>4. Kami akan membalas pesan Kamu beserta totalan order Kamu (beserta ongkos kirimnya) dan nomor rekening kami.</p>
                            <p>5. Segera melakukan pembayaran dan konfirmasi pembayaran Kamu ke kami, konfirmasi sebelum jam 16.00 akan di proses hari itu juga, untuk konfirmasi pembayaran di atas jam 16.00 akan di proses di hari esok. Hari sabtu sampai jam 14.00, Minggu dan hari libur kita close.</p>

                            
                          </div>
                        </div>
                      </div>
                    </div>                        
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div>
              <!-- / quick order modal -->
              
            </div>  
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / product category -->


  <!-- footer -->  
  <?php require 'footer2.php';?>
  <!-- / footer -->

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> 
 
  <!-- Product view slider -->
  <script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']; ?>/js/jquery.simpleGallery.js"></script>
  <script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']; ?>/js/jquery.simpleLens.js"></script>
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']; ?>/js/slick.js"></script>
  
  <!-- Custom js -->
  <script src="<?php $_SERVER['SERVER_NAME']; ?>/js/custom.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $(".fancybox").fancybox({
        openEffect  : 'none',
        closeEffect : 'none'
      });
    });
  </script>

  <script>
    fbq('track', 'ViewContent', {
    value: <?php echo $data['produk']['hargalain']; ?>,
    currency: 'IDR'
    });
  </script>
 

  </body>
</html>