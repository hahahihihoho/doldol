<?php

require_once 'config/app.php';
/**
 * Bot PHP Telegram ver Curl
 * Lebih Bersih
 * Sample Sederhana untuk Ebook Edisi 3: Membuat Bot Sendiri Menggunakan PHP
 * 
 * Dibuat oleh Hasanudin HS
 * @hasanudinhs di Telegram dan Twitter
 * Ebook live http://telegram.banghasan.com/
 * -----------------------
 * Grup @botphp
 * Jika ada pertanyaan jangan via PM
 * langsung ke grup saja.
 * ----------------------
 * PertamaCurlBot.php
 * Bot PHP sederhana Menggunakan Curl
 * Versi 0.02
 * Juli 2016
 * Last Update : 23 Juli 2016 22:40 WIB
 * 
 * Default adalah webhook!
 * Default pake API pihak ke-3, siap tanpa https / SSL
 */
// masukkan bot token di sini
define('BOT_TOKEN', '193258189:AAF5ca5eRge0Feg_kda4k-skTxgQdAz8tD4'); 
// versi official telegram bot
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
// versi 3rd party, biar bisa tanpa https / tanpa SSL.
//define('API_URL', 'https://api.pwrtelegram.xyz/bot'.BOT_TOKEN.'/'); 
define('myVERSI','0.02');
// aktifkan ini jika ingin menampilkan debugging poll
$debug = true;
function exec_curl_request($handle) {
  $response = curl_exec($handle);
  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }
  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);
  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }
  return $response;
}

function apiRequest($method, $parameters=null) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  $parameters["method"] = $method;
  $handle = curl_init(API_URL);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
  return exec_curl_request($handle);
}

// jebakan token, klo ga diisi akan mati
if (strlen(BOT_TOKEN)<20) 
    die(PHP_EOL."-> -> Token BOT API nya mohon diisi dengan benar!\n");


function getUpdates($last_id = null){
  $params = [];
  if (!empty($last_id)){
    $params = ['offset' => $last_id+1, 'limit' => 1];
  }
  echo print_r($params, true);
  return apiRequest('getUpdates', $params);
}
// matikan ini jika ingin bot berjalan
//die('baca dengan teliti yak!');
// ----------- pantengin mulai ini
function sendMessage($idpesan, $idchat, $pesan){
  $data = [
    'chat_id'=> $idchat,
    'text' => $pesan,
    'parse_mode'  => 'Markdown',
    "reply_to_message_id" => $idpesan
  ];
  return apiRequest("sendMessage", $data);
}

function sendOtherMessage($idpesan, $idchat, $pesan){
  $data = [
    'chat_id'=> $idchat,
    'text' => $pesan,
    'parse_mode'  => 'Markdown',
    "reply_to_message_id" => $idpesan
  ];
  return apiRequest("sendMessage", $data);
}

function sendPhoto($idpesan, $idchat, $pesan){
  $data = [
    'chat_id'=> $idchat,
    'photo' => $pesan,
    'parse_mode'  => 'Markdown',
    "reply_to_message_id" => $idpesan
  ];
  return apiRequest("sendPhoto", $data);
}

function sendSticker($idpesan, $idchat, $pesan){
  $data = [
    'chat_id'=> $idchat,
    'sticker' => $pesan,
    'parse_mode'  => 'Markdown',
    "reply_to_message_id" => $idpesan
  ];
  return apiRequest("sendSticker", $data);
}

function sendAudio($idpesan, $idchat, $pesan){
  $data = [
    'chat_id'=> $idchat,
    'audio' => $pesan,
    'parse_mode'  => 'Markdown',
    "reply_to_message_id" => $idpesan
  ];
  return apiRequest("sendAudio", $data);
}

//Fungsi tampil detail berdasarkan ID produk
function searchProd($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, searchProd($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearch($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && preg_match($value,$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearch($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchKemejaLain($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && !preg_match($value,$array[$key]) && !preg_match('/Pendek/',$array[$key]) && !preg_match('/Batik/',$array[$key]) && !preg_match('/Flanel/',$array[$key])) {
        //if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchKemejaLain($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchCelanaLain($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && !preg_match($value,$array[$key]) && !preg_match('/Jeans/',$array[$key]) && !preg_match('/Jogger/',$array[$key]) && !preg_match('/Chino/',$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchCelanaLain($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchAtasanLain($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && !preg_match($value,$array[$key]) && !preg_match('/Kaos/',$array[$key]) && !preg_match('/Polo/',$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchAtasanLain($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchLuaranLain($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && !preg_match($value,$array[$key]) && !preg_match('/Jaket/',$array[$key]) && !preg_match('/Jacket/',$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchLuaranLain($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchJaket($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && preg_match($value,$array[$key]) || preg_match('/Jacket/',$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchJaket($subarray, $key, $value));
        }
    }

    return $results;
}

function filterSearchPolo($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && preg_match($value,$array[$key]) && !preg_match('/Zipper Black/',$array[$key]) && !preg_match('/Polos/',$array[$key])) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, filterSearchPolo($subarray, $key, $value));
        }
    }

    return $results;
}

//Fungsi paging
function paging($data, $limit, $page){
    $jmlData = count($data);
    if(!empty($limit)){
        $totalHalaman = ceil($jmlData/$limit);  
    }else{
        $totalHalaman = 1;
    }

    if(!empty($page) && !empty($limit)){
        $start = ($page - 1) * $limit;
    }else{
        $start = 0;
    }

    $end = $start + $limit;

    if($start < 0 || $totalHalaman < $page){
        return array();
    } elseif($start == 0 && $limit == 0){
        return array_slice($data, $totalHalaman);
    }else{
        return array_slice($data, $start, $end - $start);
    }
}

function processMessage($message) { 
  if ( $GLOBALS['debug']) print_r($message);
  $photos = '';
  $sticker = '';
  $othertext = '';
  if (isset($message["message"])) {
    $sumber   = $message['message'];
    $idpesan  = $sumber['message_id'];
    $idchat   = $sumber['chat']['id'];
    $namamu   = $sumber['from']['first_name'];
    if (isset($sumber['text'])) {
      $pesan  =  $sumber['text'];
      $gabung = explode(' ', $pesan);
      $pecah  = explode(' ', $pesan);
      $command = explode('_',$pecah[0]);
      if(preg_match('/telolet/',$pesan)){
        $sticker = "BQADBQADYwMAAttQAwABy-nM5ZpMuqMC";
        $audio = "BQADBQADKQADzx3wAVvahZvlZZuNAg";
      }
      else
      {
        if (preg_match('/detail/',$command[0])){
            try{
              $app = new app();
              $test = $app->loadProdukNewAll();       
              $cari = searchProd($test['listproduk'], 'id', $command[1]);
              if($cari != null){
                  $link = $cari[0]['link'];       
                  $detail = $app->loadDetailProdukTelegram($link);
                  $size = preg_replace('/\s+/','',implode(",", $detail['produk']['size']));
                  //$potonglink = substr($cari[0]['link'],27);
                  $title = $detail['produk']['title'];
                  $titlelink = "[$title](http://www.idfashioncowok.com/detail/$link)";

                  if($size != null){
                      $text = "📌 ".$titlelink." \n 💰 *Rp. ".$detail['produk']['harga']."*\n ⚖ Berat : ".$detail['produk']['berat']." Gram\n 🎗 Ready Size : ".$size."\n 🔎 Deskripsi : \n".$detail['produk']['deskripsi']."\n";
                      $photos = $detail['produk']['gambar'];

                  }else{
                      $text = "📌 ".$titlelink." \n 💰 *Rp. ".$detail['produk']['harga']."*\n ⚖ Berat : ".$detail['produk']['berat']." Gram\n 🔎 Deskripsi : \n".$detail['produk']['deskripsi']."\n";
                      $photos = $detail['produk']['gambar'];
                  }
              }else{
                  $text = "Produk tidak ditemukan. Mohon pilih produk dari menu yang tersedia";
              }
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya, mohon coba kembali nanti.";
            }
        }elseif (preg_match('/kemejahalaman/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $hal = $command[1] + 1;
              $pages = paging($newproduct['listproduk'], 10, $command[1]);
              $pages2 = paging($newproduct['listproduk'], 10, $hal);
              $total = count($arrprod); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejahalaman\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kemejapanjanghal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Panjang/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejapanjanghal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kemejapendekhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Pendek/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejapanjanghal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kemejabatikhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Batik/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejapanjanghal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kemejaflanelhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Flanel/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejaflanelhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kemejalainhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukKemejaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchKemejaLain($arrprod, 'title', '/Panjang/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejalainhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanajeanshal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Jeans/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanajeanshal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanajoggerhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Jogger/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanajoggerhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanachinohal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Chino/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanachinohal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanapendekhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Pendek/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanapendekhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanalainhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchCelanaLain($arrprod, 'title', '/Pendek/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanalainhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/longlinehal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Longline/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/longlinehal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/polohal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchPolo($arrprod, 'title', '/Polo/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/polohal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/kaoshal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Kaos/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kaoshal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/atasanlainhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchAtasanLain($arrprod, 'title', '/Kaos/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/atasanlainhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/blazerhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukLuaranAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearch($arrprod, 'title', '/Blazer/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/blazerhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/jakethal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukLuaranAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchJaket($arrprod, 'title', '/Jaket/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/jakethal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/luaranlainhal/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $resultcari = filterSearchLuaranLain($arrprod, 'title', '/Blazer/');
              $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
              $hal = $command[1] + 1;
              $pages = paging($arr, 10, $command[1]);
              $pages2 = paging($arr, 10, $hal);
              $total = count($resultcari); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/luaranlainhal\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/luaranhalaman/',$command[0])){
            try{
              $app = new app();
              $newproduct = $app->loadProdukLuaranAll();
              $arrprod = $newproduct['listproduk'];
              $hal = $command[1] + 1;
              $pages = paging($newproduct['listproduk'], 10, $command[1]);
              $pages2 = paging($newproduct['listproduk'], 10, $hal);
              $total = count($arrprod); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/luaranhalaman\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
            }catch(Exception $e) {
              $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
            }
        }elseif (preg_match('/celanahalaman/',$command[0])){
          try{
            $app = new app();
              $newproduct = $app->loadProdukCelanaAll();
              $arrprod = $newproduct['listproduk'];
              $hal = $command[1] + 1;
              $pages = paging($newproduct['listproduk'], 10, $command[1]);
              $pages2 = paging($newproduct['listproduk'], 10, $hal);
              $total = count($arrprod); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanahalaman\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
          }catch(Exception $e) {
            $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
          }
        }elseif (preg_match('/atasanhalaman/',$command[0])){
          try{
            $app = new app();
              $newproduct = $app->loadProdukAtasanAll();
              $arrprod = $newproduct['listproduk'];
              $hal = $command[1] + 1;
              $pages = paging($newproduct['listproduk'], 10, $command[1]);
              $pages2 = paging($newproduct['listproduk'], 10, $hal);
              $total = count($arrprod); //total items in array    
              $limit = 10; //per page    
              $totalPages = ceil($total / $limit); //calculate total pages
              $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
              $text .= implode('', array_map(function ($entry) {
                  $title = $entry['title'];
                  $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                  return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
              }, $pages));
              if($pages2 != null)
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/atasanhalaman\_".$hal;
              else
                  $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *".$command[1]."* dari *".$totalPages."* `Halaman`";
          }catch(Exception $e) {
            $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
          }
        }else{
          $katapertama = strtolower($pecah[0]);
          switch ($katapertama) {
            case '/start':
              $text = "Hai *$namamu*.. 😀 Akhirnya kita bertemu!";
              $othertext = "Saya *MARVIS*! Saya akan membantu kamu untuk mencari atau melakukan cekstok produk fashion yang kamu mau. Kamu dapat memulainya dengan perintah-perintah berikut.\n\n";
              $othertext .= "🤖 Perintah yang tersedia : \n";
              $othertext .= "/pencarian - Mencari produk\n/terbaru - menampilkan 8 produk terbaru\n/semuakemeja - Menampilkan semua produk kemeja\n/semuacelana - Menampilkan semua produk celana\n/semuaatasan - Menampilkan semua produk atasan (Kaos, Longline, Polo)\n/semualuaran - Menampilkan semua produk luaran (Blazer, Jaket, Vest, Cardigan)\n/caraorder - Cara melakukan order";
              break;
            case '/time':
              $text  = "Waktu Sekarang :\n";
              $text .= date("d-m-Y H:i:s");
              $text .= "\nWaktu Server";
              break;
            case '/terbaru':
              try{
                $app = new app();
                $newproduct = $app->loadProdukNew();
                $arrprod = $newproduct['listproduk'];
                $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejabaru':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemeja();
                $arrprod = $newproduct['listproduk'];
                $text = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanabaru':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelana();
                $arrprod = $newproduct['listproduk'];
                $text = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/luaranbaru':
              try{
                $app = new app();
                $newproduct = $app->loadProdukLuaran();
                $arrprod = $newproduct['listproduk'];
                $text = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/atasanbaru':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasan();
                $arrprod = $newproduct['listproduk'];
                $text = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/semuakemeja':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $pages = paging($arrprod, 10, 1);
                $total = count($arrprod); //total items in array    
                $limit = 10; //per page    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejahalaman\_2";

                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/semualuaran':
              try{
                $app = new app();
                $newproduct = $app->loadProdukLuaranAll();
                $arrprod = $newproduct['listproduk'];
                $pages = paging($arrprod, 10, 1);
                $total = count($arrprod); //total items in array    
                $limit = 10; //per page    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/luaranhalaman\_2";

                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/semuacelana':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $pages = paging($arrprod, 10, 1);
                $total = count($arrprod); //total items in array    
                $limit = 10; //per page    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanahalaman\_2";

                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/semuaatasan':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasanAll();
                $arrprod = $newproduct['listproduk'];
                $pages = paging($arrprod, 10, 1);
                $total = count($arrprod); //total items in array    
                $limit = 10; //per page    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/atasanhalaman\_2";

                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/pencarian':
              try{
                $text = "Mau cari barang apa bro ? Berikut pilihannya ya.\n1⃣ /kemeja\n2⃣ /celana\n3⃣ /atasan\n4⃣ /luaran";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemeja':
              try{
                $text = "Kamu mau cari kemeja jenis apa ?\n1⃣ /kemejapanjang\n2⃣ /kemejapendek\n3⃣ /kemejabatik\n4⃣ /kemejaflanel\n5⃣ /kemejalainnya";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celana':
              try{
                $text = "Kamu mau cari celana jenis apa ?\n1⃣ /celanajeans\n2⃣ /celanajogger\n3⃣ /celanachino\n4⃣ /celanapendek\n5⃣ /celanalainnya";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/atasan':
              try{
                $text = "Kamu mau cari atasan jenis apa ?\n1⃣ /longline\n2⃣ /polo\n3⃣ /kaos\n4⃣ /atasanlainnya";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/luaran':
              try{
                $text = "Kamu mau cari luaran jenis apa ?\n1⃣ /blazer\n2⃣ /jaket\n3⃣ /luaranlainnya";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejapanjang':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Panjang/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($resultcari); //total items in array    
                $limit = 10; //per page
                $nomor = 0;
                
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kemeja Panjang_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejapanjanghal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejapendek':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Pendek/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($resultcari); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kemeja Pendek_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejapendekhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejabatik':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Batik/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kemeja Batik_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejabatikhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejaflanel':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Flanel/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kemeja Flanel_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejaflanelhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kemejalainnya':
              try{
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchKemejaLain($arrprod, 'title', '/Panjang/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kemeja Lainnya_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kemejalainhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanajeans':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Jeans/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Celana Jeans_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanajeanshal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanajogger':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Jogger/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Celana Jogger_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanajoggerhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanachino':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Chino/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Celana Chino_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanachinohal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanapendek':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Pendek/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Celana Pendek_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanapendekhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/celanalainnya':
              try{
                $app = new app();
                $newproduct = $app->loadProdukCelanaAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchCelanaLain($arrprod, 'title', '/Pendek/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Celana Lainnya_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/celanalainhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/longline':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasanAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Longline/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Longline_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/longlinehal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/polo':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasanAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchPolo($arrprod, 'title', '/Polo/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Polo_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                echo $text;
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/polohal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/kaos':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasanAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Kaos/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Kaos_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/kaoshal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/atasanlainnya':
              try{
                $app = new app();
                $newproduct = $app->loadProdukAtasanAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchAtasanLain($arrprod, 'title', '/Longline/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Atasan Lain_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/atasanlainhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/blazer':
              try{
                $app = new app();
                $newproduct = $app->loadProdukLuaranAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearch($arrprod, 'title', '/Blazer/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Blazer_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/blazerhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/jaket':
              try{
                $app = new app();
                $newproduct = $app->loadProdukLuaranAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchJaket($arrprod, 'title', '/Jaket/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Jaket_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/jakethal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/luaranlainnya':
              try{
                $app = new app();
                $newproduct = $app->loadProdukLuaranAll();
                $arrprod = $newproduct['listproduk'];
                $resultcari = filterSearchLuaranLain($arrprod, 'title', '/Blazer/');
                $no = 1;
                foreach ($resultcari as $val) {
                    $val['nomor'] = $no++;
                    $arr[] = $val;
                }
                $pages = paging($arr, 10, 1);
                $total = count($arr); //total items in array    
                $limit = 10; //per page
                    
                $totalPages = ceil($total / $limit); //calculate total pages
                $text = "🔎 Ditemukan *".$total."* hasil pencarian untuk _Luaran Lain_\n\n ✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n";
                $text .= implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $no = 1;
                    $link = "[$title](http://www.idfashioncowok.com/detail/$entry[link])";
                    return $entry['nomor'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 _Lihat detail_ : /detail\_$entry[id]\n\n";
                }, $pages));
                if($total > 10)
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🚩 `Halaman` *1* dari *".$totalPages."* `Halaman`\n\n ▶️ Halaman Berikutnya : \n/luaranlainhal\_2";
                else
                    $text .= "✌☘🔰🔰🚥🚧🚧🚧🚥🔰🔰☘✌\n\n🏁 `Halaman` *1* dari *".$totalPages."* `Halaman`";
                break;
                
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            case '/caraorder':
              try{
                $text = "*ORDER VIA TELEGRAM*\n🔶🔸🔷🔹🔹🔷🔸🔶\n\n1⃣ Pilih product yang Kamu inginkan lewat telegram.\n\n2⃣ Teruskan (_Forward_) gambar produk yang kamu pilih ke akun telegram CS kita di @idfashioncowok. \nLalu kirimkan data-data berikut ke CS kita @idfashioncowok, \n\nContoh :\n*- Paket JNE(OKE/REG/YES)\n- Orderan : 1pcs - L\n- Nama : Anton\n- Alamat Lengkap : Jl.Semangka No.1, Kec.Duren, Kota Manggis\n- Telp/Hp : 0800001234*\n\n3⃣ Kami akan membalas pesan Kamu beserta totalan order Kamu (beserta ongkos kirimnya) dan nomor rekening kami.\n\n4⃣ Segera melakukan pembayaran dan konfirmasi pembayaran Kamu ke CS kami, konfirmasi sebelum jam 16.00 akan di proses hari itu juga, untuk konfirmasi pembayaran di atas jam 16.00 akan di proses di hari esok. Hari sabtu sampai jam 14.00, Minggu dan hari libur kita close.\n\n🚧👀🌀🍀🍀🍂🍂🐾🐾🎗🎗🏠🏠📌📌💪💪🌀👀🚧";
                $othertext = "*ORDER VIA BBM\LINE@*\n🔴⚜⚜✅✅⚜⚜🔴\n\n1⃣ Pilih product yang Kamu inginkan lewat telegram.\n\n2⃣ Screenshoot atau Simpan gambar produk yang kamu pilih, lalu kirimkan ke akun BBM CS kita di `5BAEB5DE` atau LINE@ di `@fyq6118d` (_Pilih salah satu_). \nLalu kirimkan data-data berikut ke akun BBM/Line@ CS kita, \n\nContoh :\n*- Paket JNE(OKE/REG/YES)\n- Orderan : 1pcs - L\n- Nama : Anton\n- Alamat Lengkap : Jl.Semangka No.1, Kec.Duren, Kota Manggis\n- Telp/Hp : 0800001234*\n\n3⃣ Kami akan membalas pesan Kamu beserta totalan order Kamu (beserta ongkos kirimnya) dan nomor rekening kami.\n\n4⃣ Segera melakukan pembayaran dan konfirmasi pembayaran Kamu ke CS kami, konfirmasi sebelum jam 16.00 akan di proses hari itu juga, untuk konfirmasi pembayaran di atas jam 16.00 akan di proses di hari esok. Hari sabtu sampai jam 14.00, Minggu dan hari libur kita close.\n\n🚧👀🌀🍀🍀🍂🍂🐾🐾🎗🎗🏠🏠📌📌💪💪🌀👀🚧";
                break;
              }catch(Exception $e) {
                $text = "Maaf, Bot sedang error. Kami sedang memperbaikinya. Mohon coba kembali nanti";
                break;
              }

            
            default:
              $text = "Pesan diabaikan. Mohon masukkan perintah yang tersedia saja.\n\n";
              $text .= "Perintah yang tersedia : \n";
              $text .= "/pencarian -  cari produk yang kamu inginkan\n/terbaru - menampilkan 8 produk terbaru\n/semuakemeja - Menampilkan semua produk kemeja\n/semuacelana - Menampilkan semua produk celana\n/semuaatasan - Menampilkan semua produk atasan\n/semualuaran - Menampilkan semua produk luaran\n/caraorder - Panduan untuk order";
              break;
          }
        }
      }
    } else {
      $text  = "Apaan itu bro ? aku gak ngerti nih. Ajarin aku (tuk jadi pejantan tangguh 🙈)";
    }
    if($sticker != ''){
        $hasilsticker = sendSticker($idpesan, $idchat, $sticker);
        $hasilaudio = sendAudio($idpesan, $idchat, $audio);
    }
    else{
        if($photos == ''){
            $hasil = sendMessage($idpesan, $idchat, $text);
            if($othertext != '')
              $hasiltext = sendOtherMessage($idpesan, $idchat, $othertext);
        }
        else{
            $hasil = sendMessage($idpesan, $idchat, $text);
            $hasilphoto = sendPhoto($idpesan, $idchat, $photos);
        }
    }

    if ( $GLOBALS['debug']) {
      // hanya nampak saat metode poll dan debug = true;
      echo "Pesan yang dikirim: ".$text.PHP_EOL;
      print_r($hasil);
    }
  }    
}

// pencetakan versi dan info waktu server, berfungsi jika test hook
echo "Ver. ".myVERSI." OK Start!".PHP_EOL.date('Y-m-d H:i:s'). PHP_EOL;
function printUpdates($result){
  foreach($result as $obj){
    // echo $obj['message']['text'].PHP_EOL;
    processMessage($obj);
    $last_id = $obj['update_id'];
  }
  return $last_id;
}


//SETTINGAN WEBHOOK ATAU POLL///////////-----------------++++++++++++++---------------//////////////////////+++++++++++++

// AKTIFKAN INI jika menggunakan metode poll
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// $last_id = null;
// while (true){
//   $result = getUpdates($last_id);
//   if (!empty($result)) {
//     echo "+";
//     $last_id = printUpdates($result);
//   } else {
//     echo "-";
//   }
  
//  sleep(1);
// }

// AKTIFKAN INI jika menggunakan metode webhook
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (!$update) {
  // ini jebakan jika ada yang iseng mengirim sesuatu ke hook
  // dan tidak sesuai format JSON harus ditolak!
  exit;
} else {
  // sesuai format JSON, proses pesannya
  processMessage($update);
}
/*
Sekian.
*/
    
?>