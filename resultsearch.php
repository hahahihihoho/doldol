<?php 
include 'header3.php';
require_once 'config/app.php';
function search($array, $key, $value)
  {
    $results = array();

    if (is_array($array)) {
      if (isset($array[$key]) && preg_match($value,$array[$key])) {
        $results[] = $array;
      }

      foreach ($array as $subarray) {
        $results = array_merge($results, search($subarray, $key, $value));
      }
    }

    return $results;
  }
?>

<?php
if(isset($_POST['pencarian']))
{
  $cari = $_POST['boxcari'];
  $app = new app();
  $allprod = $app->loadProdukNewAll();
  $kata = ucwords($cari);
  $hasil = search($allprod['listproduk'], 'title', '/'.$kata.'/');
?>
<title>Hasil Pencarian - <?php echo $kata; ?></title>
 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Hasil Pencarian</h2>
        <ol class="breadcrumb">
          <li><a href="index.html"><?php echo $kata; ?></a></li>
          <li class="active">Ditemukan <?php echo count($hasil); ?> hasil pencarian</li>         
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

  <!-- Blog Archive -->
  <section id="aa-blog-archive">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-blog-archive-area">
            <div class="row">

              <div class="col-md-12">
                <div class="aa-blog-content">
                  <div class="row">
                  
                  <?php foreach ($hasil as $arr) { ?>
                          <div class="col-md-4 col-sm-4">
                            <article class="aa-blog-content-single">                          
                              <figure class="aa-blog-img">
                                <a href="detail/<?php echo $arr['link']; ?>"><img src="<?php echo $arr['gambar']; ?>" alt="fashion img"></a>
                              </figure>
                              <h4><a href="detail/<?php echo $arr['link']; ?>"><?php echo $arr['title']; ?></a></h4>
                            </article>
                          </div>
                  <?php } ?>

                  </div>
                </div>
              </div>
              
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
}else{
  echo "Kamu cari apa ?";
}
?>
  <!-- / Blog Archive -->

<!-- footer -->  
  <?php require 'footer.php';?>
  <!-- / footer -->

  </body>
</html>