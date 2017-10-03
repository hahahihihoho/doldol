<?php
// namespace config;
// error_reporting(0);
require("simple_html_dom.php");
require('fungsi_rupiah.php');

class app{

	// public function __construct(){
 //        require("simple_html_dom.php");
	// 	require('fungsi_rupiah.php');
	// }
	
	private function curldata($url)
	{
		$ch = curl_init();
		//curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (http://www.googlebot.com/bot.html)");
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.frozenshop.com');
		curl_setopt($ch, CURLOPT_URL, $url);
		
		// Gagal ngecURL
        if(!$data = curl_exec($ch)){
			return 'offline';
		}		
		else{
			return $data;
		}

		curl_close($ch);
		
	}

	public function apiProdNew()
	{
		$disc = 32000;
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$kotak = $html->find('div[class=wrap]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),26);

				$command = str_replace("-","\_",$potonglink);

				// $item['title']     	= $p->find('a',0)->plaintext;
				// $item['link']    	= $potonglink;
				// $item['gambar']    	= $value->find("img",0)->src;
				// $item['harga']    	= $rupiah;
				// $articles[] 		= $item;
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid,
				);

			}
		}		
		return $output;
	}
	
	public function loadProdukNew()
	{
		$disc = 32000;
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$kotak = $html->find('div[class=wrap]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),26);

				$command = str_replace("-","\_",$potonglink);

				// $item['title']     	= $p->find('a',0)->plaintext;
				// $item['link']    	= $potonglink;
				// $item['gambar']    	= $value->find("img",0)->src;
				// $item['harga']    	= $rupiah;
				// $articles[] 		= $item;
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid,
				);

			}
		}		
		return $output;
	}
	
	public function loadProdukKemeja()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/kemeja-pria?limit=8';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
			
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid,
				);
			}
		}		
		return $output;
	}

	public function filterSearch($array, $key, $value){
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && preg_match($value,$array[$key])) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, $this->filterSearch($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	public function loadProdukKemejaBatik()
	{
        $newproduct = $this->loadProdukKemejaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Batik/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukKemejaPendek()
	{
        $newproduct = $this->loadProdukKemejaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Pendek/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukKemejaPanjang()
	{
        $newproduct = $this->loadProdukKemejaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Panjang/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	
	public function loadProdukCelana()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/celana-pria?limit=8';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukCelanaJeans()
	{
        $newproduct = $this->loadProdukCelanaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Jeans/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukCelanaJogger()
	{
        $newproduct = $this->loadProdukCelanaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Jogger/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukCelanaChino()
	{
        $newproduct = $this->loadProdukCelanaAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Chino/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}
	
	public function loadProdukLuaran()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/luaran-pria?limit=8';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}
	
	public function loadProdukAtasan()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/atasan-pria?limit=8';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->innertext;
				}else{
					$harga = $price->innertext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}


	public function loadProdukKaos()
	{
        $newproduct = $this->loadProdukAtasanAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Kaos/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukKaosLongline()
	{
        $newproduct = $this->loadProdukAtasanAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Longline/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}

	public function loadProdukKaosPolo()
	{
        $newproduct = $this->loadProdukAtasanAll();
        $arrprod = $newproduct['listproduk'];
        $resultcari = $this->filterSearch($arrprod, 'title', '/Polo/');
        $no = 1;
        foreach ($resultcari as $val) {
            $val['nomor'] = $no++;
            $arr[] = $val;
        }

        return $arr;		
	}
	
	public function loadProdukAtasanAll()
	{
		$disc = 32000;
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/atasan-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);

				$images = $value->find("img",0)->src;
				$replaceimages = str_replace("200x200","300x300",$images);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$replaceimages,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukKemejaAll()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/kemeja-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);

				$images = $value->find("img",0)->src;
				$replaceimages = str_replace("200x200","300x300",$images);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$replaceimages,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukLuaranAll()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/luaran-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);

				$images = $value->find("img",0)->src;
				$replaceimages = str_replace("200x200","300x300",$images);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$replaceimages,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukCelanaAll()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/celana-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);

				$images = $value->find("img",0)->src;
				$replaceimages = str_replace("200x200","300x300",$images);
				
				$potonglink = substr(($p->find('a', 0)->href),38);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$replaceimages,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukGelangAll()
	{
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/accessories/gelang-tangan-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				
				$potonglink = substr(($p->find('a', 0)->href),27);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukTopiAll()
	{
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/accessories/topi-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				
				$potonglink = substr(($p->find('a', 0)->href),27);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukBowtieAll()
	{
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/accessories/bowtie?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				
				$potonglink = substr(($p->find('a', 0)->href),27);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukTasAll()
	{
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/accessories/tas-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				
				$potonglink = substr(($p->find('a', 0)->href),27);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukDompetAll()
	{
		$no = 0;
		$output = array();
		$url  = 'http://www.frozenshop.com/accessories/dompet-pria?limit=100';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$section = $html->find('section[id=products]',0);
			$kotak = $section->find('div[class=row]');

			foreach ($kotak as $value) {
				$no += 1;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				
				$potonglink = substr(($p->find('a', 0)->href),27);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadProdukNewAll()
	{
		$no = 0;
		$disc = 32000;
		$output = array();
		$url  = 'http://www.frozenshop.com/latest';
		$ngecurl = $this->curldata($url);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$kotak = $html->find('div[class=wrap]');

			foreach ($kotak as $value) {				
				$no++;
				$p = $value->find('div[class=name]',0);
				$price = $value->find('div[class=price]',0);
				$buttons = $value->find('div[class=buttons]',0);
				$id = $buttons->find('a',0)->onclick;
			
				$getid = str_replace("');","",trim($id,"addToCart('"));

				if($price->find('span[class=new]',0) != null){
					$harga = $price->find('span[class=new]',0)->plaintext;
				}else{
					$harga = $price->plaintext;
				}
				
				$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
				$hargabaru = format_rupiah($harga+10000);
				$hargaawal = format_rupiah($harga+$disc);
				
				$potonglink = substr(($p->find('a', 0)->href),26);
				
				$output["listproduk"][] = array(
					"title"=>$p->find('a',0)->plaintext,
					"link"=>$potonglink,
					"gambar"=>$value->find("img",0)->src,
					"harga"=>$hargabaru,
					"hargaori"=>$hargaawal,
					"no"=>$no,
					"id"=>$getid
				);
			}
		}		
		return $output;
	}

	public function loadDetailProduk($url)
	{
		$disc = 32000;
		$output = array();
		$urlget  = 'http://www.frozenshop.com/'.$url;
		$ngecurl = $this->curldata($urlget);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$kotak = $html->find('div[class=ribbon breadcrumb]',0);
			$h1 = $kotak->find('h1',0)->plaintext;

			$deskripsi = $html->find('div[class=description]',0);
			$isi2 = str_replace('Frozenshop','idfashioncowok',$html->find('div[id=tab-description]',0)->innertext);
			$isi = str_replace('frozenshop','idfashioncowok',$isi2);
			$price = $deskripsi->find('div[class=price]',0);
			$section = $html->find('section[class=product-info]',0);
			$left = $section->find('div[class=left]',0);
			$photoadd = $left->find('div[class=image-additional]',0);
			$stok = $deskripsi->find('b',0);
			$weight = $deskripsi->find('b',1);

			$sections = $html->find('section[class=grid]',0);
			$wrap = $sections->find('div[class=wrap]');

			if($wrap != null){
				foreach ($wrap as $value) {
					$title = $value->find('div[class=name]',0)->plaintext;
					$foto = $value->find('img',0)->src;
					$link = substr(($value->find('a', 0)->href),26);
					$price2 = $value->find('div[class=price]',0);

					if($price2->find('span[class=old]',0) != null){
						$harga2 = $price2->find('span[class=new]',0)->plaintext;
					}else{
						$harga2 = $price2->plaintext;
					}
					
					$harga2 = str_replace(".","",explode("Rp.",(trim($harga2)))[1]);

					$hargabaru2 = format_rupiah($harga2+10000);
					$hargaawal2 = format_rupiah($harga2+$disc);

					$related[] = array(
						"title"=>$title,
						"photo"=>$foto,
						"link"=>$link,
						"harga"=>$hargabaru2,
						"hargaori"=>$hargaawal2
					);
				}
			}

			if($photoadd != null){
				foreach ($photoadd->find('img') as $value) {
					$fotoadd[] = $value->src;
				}
			}
			else{
				$foto = $section->find('img',0)->src;
			}

			$foto = $left->find('img',0)->src;

			//$combo = $section->find('select',0);
			$option = $section->find('div[class=options]',0)->plaintext;

			// if($combo != null){
			// 	$isFirstCombo = true;
			// 	foreach($combo->find('option') as $value){
			// 		if(!$isFirstCombo){
			// 			$option[] = $value->plaintext;
			// 		}
			// 		$isFirstCombo = false;
			// 	}
			// }else{
			// 	$option = "";
			// }
			

			if($price->find('div[class=price-new]',0) != null){
				$harga = $price->find('div[class=price-new]',0)->plaintext;
			}else{
				$harga = $price->plaintext;
			}

			$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
			$hargabaru = format_rupiah($harga+10000);
							
			$output["produk"] = array(
				"title"=>$h1,
				"harga"=>$hargabaru,
				"deskripsi"=>$isi,
				"gambar"=>$foto,
				"gambar2"=>$fotoadd,
				"size"=>$option,
				"status"=>$stok,
				"berat"=>$weight,
				"mirip"=>$related,
				"hargalain"=>$harga+10000
			);

		}		
		return $output;
	}

	public function loadDetailProdukTelegram($url)
	{
		$output = array();
		$urlget  = 'http://www.frozenshop.com/'.$url;
		$ngecurl = $this->curldata($urlget);

		if($ngecurl == 'offline'){
			$output["message"] = "error";
			$output["error"]=1;
			$output["listproduk"] = array();
		}else{
			$html = str_get_html($ngecurl);
			$kotak = $html->find('div[class=ribbon breadcrumb]',0);
			$h1 = $kotak->find('h1',0)->plaintext;

			$deskripsi = $html->find('div[class=description]',0);
			$isi2 = str_replace('Frozenshop','idfashioncowok',$html->find('div[id=tab-description]',0)->plaintext);
			$isi = str_replace('frozenshop','idfashioncowok',$isi2);
			$price = $deskripsi->find('div[class=price]',0);
			$section = $html->find('section[class=product-info]',0);
			$left = $section->find('div[class=left]',0);
			$photoadd = $left->find('div[class=image-additional]',0);
			$stok = $deskripsi->find('b',0);
			$weight = $deskripsi->find('b',1)->plaintext;

			if($photoadd != null){
				foreach ($photoadd->find('img') as $value) {
					$fotoadd[] = $value->src;
				}
			}
			else{
				$fotoadd = $section->find('img',0)->src;
			}

			$foto = $left->find('img',0)->src;

			$combo = $section->find('select',0);

			if($combo != null){
				$isFirstCombo = true;
				foreach($combo->find('option') as $value){
					if(!$isFirstCombo){
						$option[] = $value->plaintext;
					}
					$isFirstCombo = false;
				}
			}else{
				$option = "";
			}
			

			if($price->find('div[class=price-new]',0) != null){
				$harga = $price->find('div[class=price-new]',0)->plaintext;
			}else{
				$harga = $price->plaintext;
			}

			$harga = str_replace(".","",explode("Rp.",(trim($harga)))[1]);
			$hargabaru = format_rupiah($harga+10000);
							
			$output["produk"] = array(
				"title"=>$h1,
				"harga"=>$hargabaru,
				"deskripsi"=>$isi,
				"gambar"=>$foto,
				"gambar2"=>$fotoadd,
				"size"=>$option,
				"status"=>$stok,
				"berat"=>$weight
			);
		}		
		return $output;
	}
}
?>