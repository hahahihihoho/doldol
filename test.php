<?php
  // use config\app;
  // spl_autoload_extensions(".php");
  // spl_autoload_register();
  require_once 'config/app.php';


  $app = new app();
  // $test = $app->loadProdukNewAll();

  $url = "kemeja-batik";
  $test = $app->loadProdukKemeja();

  print '<pre>';
  print_r ($test);
  print '</pre>';

  // foreach($test as $kemeja){
  //   echo $kemeja['title'];
  // }


  // foreach($test['produk']['mirip'] as $titles){
  //   echo $titles['hargaori']."\n";
  // }



  // foreach($test['produk']['mirip'] as $val){
  //   foreach($val as $prod){
  //     echo $prod;
  //   } 
  // }
  // $menuItems = array_slice($test['listproduk'], 0, 10);

  // $total = count($test['listproduk']); //total items in array    
  // $limit = 10; //per page    
  // $totalPages = ceil($total/ $limit); //calculate total pages
  // // $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
  // // $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
  // // $offset = ($page - 1) * $limit;
  // // if( $offset < 0 ) $offset = 0;

  // //$yourDataArray = array_slice( $yourDataArray, $offset, $limit );

  // print '<pre>';
  // print_r($menuItems);
  // print '</pre>';
  // echo "Total data : ".$total. "</br>"; 
  // echo "Total page : ".$totalPages. "</br>"; 
// function paging($data, $limit, $page){
//     $jmlData = count($data);
//     if(!empty($limit)){
//         $totalHalaman = ceil($jmlData/$limit);  
//     }else{
//         $totalHalaman = 1;
//     }

//     if(!empty($page) && !empty($limit)){
//         $start = ($page - 1) * $limit;
//     }else{
//         $start = 0;
//     }

//     $end = $start + $limit;

//     if($start < 0 || $totalHalaman < $page){
//         return array();
//     } elseif($start == 0 && $limit == 0){
//         return array_slice($data, $totalHalaman);
//     }else{
//         return array_slice($data, $start, $end - $start);
//     }
// }

//   $pages = paging($test['listproduk'], 10, 1);
  //$size = preg_replace('/\s+/','',implode(",", $test['produk']['size']));
  //echo $test['listproduk'];
  // print '<pre>';
  // print_r($test['listproduk']);
  // print '</pre>';
  // print_r ($page);
  // function searchForId($id, $array) {
    // foreach ($array as $key => $val) {
       // if ($val['id'] === $id) {
         // return $key;
       // }
    // }
    // return null;
  // }
  
  // $id = searchForId('3114', $test['listproduk']);
  
  // function search($array, $key, $value)
  // {
  //  $results = array();

  //  if (is_array($array)) {
 //      if (isset($array[$key]) && preg_match($value,$array[$key])) {
  //    //if (isset($array[$key]) && $array[$key] == $value) {
  //      $results[] = $array;
  //    }

  //    foreach ($array as $subarray) {
  //      $results = array_merge($results, search($subarray, $key, $value));
  //    }
  //  }

  //  return $results;
  // }

  
 //  //$id = array_search('kemeja', array_column($test['listproduk'], 'title'));
  
  // $kata = ucwords("black");
 //  echo $kata;
  // //print_r($id);
 //  $hasil = search($test['listproduk'], 'title', '/'.$kata.'/');
 //  $no = 1;
 //  foreach ($hasil as $arr) {
 //    $arr['nomor'] = $no++;
 //    $arx[] = $arr;
 //  }

  // //$hasil = search($test['listproduk'], 'title', '/Batik/');

 //   // $detail = $app->loadDetailProdukTelegram('kemeja-pendek-summer-floral-blue');
 //    print '<pre>';
 //    print_r ($arx);
 //    print '</pre>';
    
  // $detail = $app->loadDetailProduk($hasil[0]['link']);
  
  // print_r ($hasil);
  // print_r ($detail['produk']['deskripsi']);
  
  // function searchForId($id, $array) {
  //  foreach ($array as $key => $val) {
  //      if ($val['harga'] === $id) {
  //          return $key; 
  //      }
  //  }
  //  return null;
  // }
  //echo array_search(3114,$test['listproduk']['id'],true);
  // print '<pre>';
  // print_r($detail);
  // //print_r($hasil);
  // print '</pre>';

  // echo implode('', array_map(function ($entry) {
  //   return $entry['title']." - Rp. ".$entry['harga']."<br/>"."http://www.fashioncowox.hol.es/detail/".$entry['link']."<br/><br/>";
  // }, $test['listproduk']));

  // //$key = array_search(150, array_column($test['listproduk'], 'harga'));
  // //$keys = array_keys(array_column($test['listproduk'], 'harga'), 150);
  
  // // print '<pre>';
  // // //$hasil = searchForId(150, $test['listproduk']);

  // // print_r($test['listproduk']);
  // // print '</pre>';
  // //var_dump($test['listproduk']);



 

 
 
 
// foreach($test['listproduk'] as $prod){
//   $item = $rss->addChild('item'); //add item node
//   $title = $item->addChild('title', $prod['title']); //add title node under item
//   $link = $item->addChild('guid', 'http://s-widodo.com/'. strtolower(str_replace(' ', '-', $prod['title'])));
//   //add link node under item
//   $guid = $item->addChild('guid', 'http://s-widodo.com/'. strtolower(str_replace(' ', '-', $prod['title']))); //add guid node under item
//   $guid->addAttribute('isPermaLink', 'false'); //add guid node attribute

//   $description = $item->addChild('description', '<![CDATA['. htmlentities($prod['title']) . ']]>'); //add description

//   // $date_rfc = gmdate(DATE_RFC2822, strtotime($row->published));
//   // $item = $item->addChild('pubDate', $date_rfc); //add pubDate node
// }


 
// foreach($test['listproduk'] as $prod){
//  $idartikel = $prod['title'];
//  $judul = $prod['title'];
//  $link = $prod['link'];
 
//   echo "<item>";
//   echo "<title>$judul</title>";
//   echo "<link>www.idfashioncowok.com/detail/$link</link>";
//   echo "<description>$judul</description>";
//   echo "</item>";
// }
 
// echo "</channel>";
// echo "</rss>";



?>