<?php
// use config\app;
// spl_autoload_extensions(".php");
// spl_autoload_register();
require_once 'config/app.php';
/*
BOT PENGANTAR
Materi EBOOK: Membuat Sendiri Bot Telegram dengan PHP
Ebook live http://telegram.banghasan.com/
oleh: bang Hasan HS
id telegram: @hasanudinhs
email      : banghasan@gmail.com
twitter    : @hasanudinhs
disampaikan pertama kali di: Grup IDT
dibuat: Juni 2016, Ramadhan 1437 H
nama file : PertamaBot.php
change log:
revisi 1 [15 Juli 2016] :
+ menambahkan komentar beberapa line
+ menambahkan kode webhook dalam mode comment
Pesan: baca dengan teliti, penjelasan ada di baris komentar yang disisipkan.
Bot tidak akan berjalan, jika tidak diamati coding ini sampai akhir.
*/
//isikan token dan nama botmu yang di dapat dari bapak bot :
$TOKEN      = "193258189:AAF5ca5eRge0Feg_kda4k-skTxgQdAz8tD4";
$usernamebot= "@marvisbot"; // sesuaikan besar kecilnya, bermanfaat nanti jika bot dimasukkan grup.
// aktifkan ini jika perlu debugging
$debug = true;
 
// fungsi untuk mengirim/meminta/memerintahkan sesuatu ke bot 
function request_url($method)
{
    global $TOKEN;
    return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}
 
// fungsi untuk meminta pesan 
// bagian ebook di sesi Meminta Pesan, polling: getUpdates
function get_updates($offset) 
{
    $url = request_url("getUpdates")."?offset=".$offset;
        $resp = file_get_contents($url);
        $result = json_decode($resp, true);
        if ($result["ok"]==1)
            return $result["result"];
        return array();
}
// fungsi untuk mebalas pesan, 
// bagian ebook Mengirim Pesan menggunakan Metode sendMessage
function send_reply($chatid, $msgid, $text)
{
    global $debug;
    $data = array(
        'chat_id' => $chatid,
        'text'  => $text,
        'parse_mode'  => 'Markdown',
        'reply_to_message_id' => $msgid   // <---- biar ada reply nya balasannya, opsional, bisa dihapus baris ini
    );
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options); 
    $result = file_get_contents(request_url('sendMessage'), false, $context);
    if ($debug) 
        print_r($result);
}

// function send_replyPhoto($chatid, $msgid, $photo)
// {
//     global $debug;
//     $data = array(
//         'chat_id' => $chatid,
//         'photo'  => $photo,
//         'parse_mode'  => 'Markdown',
//         'reply_to_message_id' => $msgid   // <---- biar ada reply nya balasannya, opsional, bisa dihapus baris ini
//     );
//     // use key 'http' even if you send the request to https://...
//     $options = array(
//         'http' => array(
//             'header'  => "Content-type: multipart/form-data\r\n",
//             'method'  => 'POST',
//             'content' => http_build_query($data),
//         ),
//     );
//     $context  = stream_context_create($options); 
//     $result = file_get_contents(request_url('sendPhoto'), false, $context);
//     if ($debug) 
//         print_r($result);
// }
 
// fungsi mengolahan pesan, menyiapkan pesan untuk dikirimkan
function create_response($text, $message)
{
    global $usernamebot, $debug, $photos;
    // inisiasi variable hasil yang mana merupakan hasil olahan pesan
    $hasil = '';  
    $fromid = $message["from"]["id"]; // variable penampung id user
    $chatid = $message["chat"]["id"]; // variable penampung id chat
 
    // variable penampung username nya user
    isset($message["from"]["username"])
        ? $chatuser = $message["from"]["username"]
        : $chatuser = '';
    
    // variable penampung nama user
    isset($message["from"]["last_name"]) 
        ? $namakedua = $message["from"]["last_name"] 
        : $namakedua = '';   
    $namauser = $message["from"]["first_name"]. ' ' .$namakedua;
    // ini saya pergunakan untuk menghapus kelebihan pesan spasi yang dikirim ke bot.
    $textur = preg_replace('/\s\s+/', ' ', $text); 
    // memecah pesan dalam 2 blok array, kita ambil yang array pertama saja
    $command = explode('_',$textur); //
   // identifikasi perintah (yakni kata pertama, atau array pertamanya)
    if (preg_match('/detail/',$command[0])){
        //$potong = trim($command[0], "/detail");

        $app = new app();
        $test = $app->loadProdukNewAll();
        function search($array, $key, $value)
        {
            $results = array();

            if (is_array($array)) {
                if (isset($array[$key]) && $array[$key] == $value) {
                    $results[] = $array;
                }

                foreach ($array as $subarray) {
                    $results = array_merge($results, search($subarray, $key, $value));
                }
            }

            return $results;
        }
        $cari = search($test['listproduk'], 'id', $command[1]);
        // if($cari != null){       
            $detail = $app->loadDetailProdukTelegram($cari[0]['link']);
            $size = trim(implode(",", $detail['produk']['size']));

            if($size != null){
                $hasil = "📌 *".$detail['produk']['title']."* \n 💰 *Rp. ".$detail['produk']['harga']."*\n ⚖ Berat : ".$detail['produk']['berat']." Gram\n 🎗 Ready Size : ".$size."\n 🔎 Deskripsi : \n".$detail['produk']['deskripsi']."\n";
               // $hasil .= " Test";
                $bot_url    = "https://api.telegram.org/bot193258189:AAF5ca5eRge0Feg_kda4k-skTxgQdAz8tD4/";
                $url        = $bot_url . "sendPhoto?chat_id=" . $chatid ;

                $post_fields = array('chat_id'   => $chatid,
                    'photo'     => new CURLFile(realpath($detail['produk']['gambar']))
                );

                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type:multipart/form-data"
                ));
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
                $output = curl_exec($ch);
                print $output;
            }else{
                $hasil = "📌 *".$detail['produk']['title']."* \n 💰 *Rp. ".$detail['produk']['harga']."*\n ⚖ Berat : ".$detail['produk']['berat']." Gram\n 🔎 Deskripsi : \n".$detail['produk']['deskripsi']."\n";
                //$hasil .= " Test";
                //$hasil .= $detail['produk']['gambar'];
                $bot_url    = "https://api.telegram.org/bot193258189:AAF5ca5eRge0Feg_kda4k-skTxgQdAz8tD4/";
                $url        = $bot_url . "sendPhoto?chat_id=" . $chatid ;

                $post_fields = array('chat_id'   => $chatid,
                    'photo'     => new CURLFile(realpath($detail['produk']['gambar']))
                );

                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type:multipart/form-data"
                ));
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
                $output = curl_exec($ch);
                print $output;
            }
        // }else{
        //     $hasil = "Produk tidak ditemukan. Mohon pilih produk dari menu yang tersedia";
        // }

        

        // $updateid = $message["update_id"];
        // $message_data = $message["message"];

        // $chatid = $message_data["chat"]["id"];
        // $message_id = $message_data["message_id"];
        // $photo = $detail['produk']['gambar'];
        // $response = create_response($photo, $message_data);
        // send_reply($chatid, $message_id, $response);

        // $data = array(
        //     'chat_id' => $chatid,
        //     'photo'  => $photo,
        //     'parse_mode'  => 'Markdown',
        //     'reply_to_message_id' => $message_id  
        // );
        // // use key 'http' even if you send the request to https://...
        // $options = array(
        //     'http' => array(
        //         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        //         'method'  => 'POST',
        //         'content' => http_build_query($data),
        //     ),
        // );
        // $context  = stream_context_create($options); 
        // $result2 = file_get_contents(request_url('sendPhoto'), false, $context);
        // if ($debug) 
        //     print_r($result2);

    }
    else{
        switch (strtolower($command[0])) {
            // jika ada pesan /id, bot akan membalas dengan menyebutkan idnya user
            case '/id':
            case '/id'.$usernamebot : //dipakai jika di grup yang haru ditambahkan @usernamebot
                $hasil = "`$namauser`, ID kamu adalah $fromid ";
                break;
            
            // jika ada permintaan waktu
            case '/time':
            case '/time'.$usernamebot :
                $hasil  = "`$namauser`, waktu lokal bot sekarang adalah :\n";
                $hasil .= date("d-m-Y H:i:s");
                $hasil .= " waktu server";
                break;

            case '/terbaru':
                $app = new app();
                $newproduct = $app->loadProdukNew();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));

                break;

            case '/kemejabaru':
                $app = new app();
                $newproduct = $app->loadProdukKemeja();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));

                break;

            case '/celanabaru':
                $app = new app();
                $newproduct = $app->loadProdukCelana();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                unset($app);
                break;

            case '/luaranbaru':
                $app = new app();
                $newproduct = $app->loadProdukLuaran();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                unset($app);
                break;

            case '/atasanbaru':
                $app = new app();
                $newproduct = $app->loadProdukAtasan();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));
                unset($app);
                break;

            case '/semuakemeja':
                $app = new app();
                $newproduct = $app->loadProdukKemejaAll();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n /Halaman\_2";
                }, $arrprod));
                

                break;

            case '/semua':
                $app = new app();
                $newproduct = $app->loadProdukNewAll();
                $arrprod = $newproduct['listproduk'];
                $hasil = implode('', array_map(function ($entry) {
                    $title = $entry['title'];
                    $link = "[$title](http://www.fashioncowox.hol.es/detail/$entry[link])";
                    return $entry['no'].". ".$link."\n 💰 Rp. ".$entry['harga']."\n 👀 Lihat detail : /detail\_$entry[id]\n\n";
                }, $arrprod));

                break;
                
            // balasan default jika pesan tidak di definisikan
            default:
                $hasil = '⛔️ *Command not found! Perintah diabaikan*.';
                break;
        }
    }
    return $hasil;
}
 
// jebakan token, klo ga diisi akan mati
// boleh dihapus jika sudah mengerti
if (strlen($TOKEN)<20) 
    die("Token mohon diisi dengan benar!\n");
// fungsi pesan yang sekaligus mengupdate offset 
// biar tidak berulang-ulang pesan yang di dapat 
function process_message($message)
{
    $updateid = $message["update_id"];
    $message_data = $message["message"];
    if (isset($message_data["text"])) {
        $chatid = $message_data["chat"]["id"];
        $message_id = $message_data["message_id"];
        $text = $message_data["text"];
        //$photo = $GLOBALS['photo'];
        $response = create_response($text, $message_data);
        //$responsePhoto = create_response($photo, $message_data);
        send_reply($chatid, $message_id, $response);
        //send_replyPhoto($chatid, $message_id, $responsePhoto);
    }
    return $updateid;
}
 
// hapus baris dibawah ini, jika tidak dihapus berarti kamu kurang teliti!
//die("Mohon diteliti ulang codingnya..\nERROR: Hapus baris atau beri komen line ini yak!\n");
 
// hanya untuk metode poll
// fungsi untuk meminta pesan
// baca di ebooknya, yakni ada pada proses 1 
function process_one()
{
    global $debug;
    $update_id  = 0;
    echo "-";
 
    if (file_exists("last_update_id")) 
        $update_id = (int)file_get_contents("last_update_id");
 
    $updates = get_updates($update_id);
    // jika debug=0 atau debug=false, pesan ini tidak akan dimunculkan
    if ((!empty($updates)) and ($debug) )  {
        echo "\r\n===== isi diterima \r\n";
        print_r($updates);
    }
 
    foreach ($updates as $message)
    {
        echo '+';
        $update_id = process_message($message);
    }
    
    // update file id, biar pesan yang diterima tidak berulang
    file_put_contents("last_update_id", $update_id + 1);
}
// metode poll
// proses berulang-ulang
// sampai di break secara paksa
// tekan CTRL+C jika ingin berhenti 
while (true) {
    process_one();
    sleep(1);
}
// metode webhook
// secara normal, hanya bisa digunakan secara bergantian dengan polling
// aktifkan ini jika menggunakan metode webhook
/*
$entityBody = file_get_contents('php://input');
$pesanditerima = json_decode($entityBody, true);
process_message($pesanditerima);
*/
/*
 * -----------------------
 * Grup @botphp
 * Jika ada pertanyaan jangan via PM
 * langsung ke grup saja.
 * ----------------------
 
* Just ask, not asks for ask..
Sekian.
*/
    
?>