<?php
	// use config\app;
	// spl_autoload_extensions(".php");
	// spl_autoload_register();
  require_once 'config/app.php';
	$app = new app();
?>
<html lang="en">
  <head>
    <title>Toko Baju Pria - Fashion Pria Terbaru 2017</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Toko baju online pria menyediakan, kemeja pria, kaos pria, celana pria, fashion pria, jaket, blazer. Jual Fashion Pria Terbaru dan Termurah 2017" />
   
    <!-- Font awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">  
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/lite-blue-theme.css" rel="stylesheet">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">    
    <link href="css/custom.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type='text/css'> 

    <link href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css' rel='stylesheet' type='text/css'>

    <style type="text/css" media="all">

      .hiddenlink {
        color: #000; /* same color as the surrounding text */
        text-decoration: none; /* to remove the underline */
        cursor: text; /* to make the cursor stay as a text cursor, not the hand */

    </style>



     <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-89668542-1', 'auto');
      ga('send', 'pageview');

    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KCHK3HB');</script>
    <!-- End Google Tag Manager -->

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '388190358199890'); // Insert your pixel ID here.
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=388190358199890&ev=PageView&noscript=1"
    /></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
    <script charset="UTF-8" src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/5a44262865a499b34cb7742ad3d0a2c1_0.js" async></script>

    <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(["init", {
        appId: "cd9c2346-a813-4b93-a487-608ec31bb123",
        autoRegister: true, /* Set to true to automatically prompt visitors */
        subdomainName: 'idfashioncowok.onesignal.com',
        /*
        subdomainName: Use the value you entered in step 1.4: http://imgur.com/a/f6hqN
        */
        promptOptions: {
            /* Change bold title, limited to 30 characters */
          siteName: 'ID Fashion Cowok',
          /* Subtitle, limited to 90 characters */
          actionMessage: "Dapatkan Notifikasi Setiap Kami Menambahkan PRODUK BARU",
          /* Example notification title */
          exampleNotificationTitle: 'Notifikasi ',
          /* Example notification message */
          exampleNotificationMessage: 'This is an example notification',
          /* Text below example notification, limited to 50 characters */
          exampleNotificationCaption: 'You can unsubscribe anytime',
          /* Accept button text, limited to 15 characters */
          acceptButtonText: "YA, SAYA MAU",
          /* Cancel button text, limited to 15 characters */
          cancelButtonText: "NANTI DULU"
        },
        httpPermissionRequest: {
          enable: true
        },
        notifyButton: {
            enable: true /* Set to false to hide */
        }
      }]);
    </script> -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//a.mailmunch.co/app/v1/site.js" id="mailmunch-script" data-mailmunch-site-id="311442" async="async"></script>
    <link rel="shortcut icon" href="img/favicon.ico"/>
  </head>
  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCHK3HB"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.8&appId=394201544273923";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- End Google Tag Manager (noscript) -->
   <!-- wpf loader Two -->
    <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Loading</span>
      </div>
    </div> 
    <!-- / wpf loader Two -->       
  <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->


  <!-- Start header section -->
  <header id="aa-header">

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="/">
                  <span class="fa fa-shopping-cart"></span>
                  <p>Fashion<strong>Cowok</strong> <span>Your Shopping Partner</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.html"><img src="img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->

               <!-- search box -->
              <div class="aa-search-box">
                <form method="POST" action="resultsearch.php">
                  <input type="text" name="boxcari" id="boxcari" placeholder="Cari disini contoh. 'kemeja pendek' " required>
                  <button type="submit" id="pencarian" name="pencarian" style="height: 70%;"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->  
          
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->
  <!-- menu -->
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>          
          </div>
          <div class="navbar-collapse collapse">
            <!-- Left nav -->
            <ul class="nav navbar-nav">
              <li><a href="/">Home</a></li>
      			  <li><a href="#">Kemeja Pria <span class="caret"></span></a>
                 <ul class="dropdown-menu">                
                  <li><a href="kemeja-batik">Kemeja Batik</a></li>
                  <li><a href="kemeja-pendek">Kemeja Pendek</a></li>
                  <li><a href="kemeja-panjang">Kemaja Panjang</a></li>                                              
                  <li><a href="kemeja-pria">Semua Kemeja</a></li>
                </ul>
              </li>
      			  <li><a href="luaran-pria">Luaran Pria</a></li>
      			  <li><a href="#">Celana Pria <span class="caret"></span></a>
                <ul class="dropdown-menu">                
                  <li><a href="celana-jeans">Celana Jeans</a></li>
                  <li><a href="celana-jogger">Celana Jogger</a></li>
                  <li><a href="celana-chino">Celana Chino</a></li>                                              
                  <li><a href="celana-pria">Semua Celana</a></li>
                </ul>
              </li>
      			  <li><a href="#">Atasan Pria <span class="caret"></span></a>
                <ul class="dropdown-menu">                
                  <li><a href="kaos">Kaos</a></li>
                  <li><a href="kaos-longline">Kaos Longline</a></li>
                  <li><a href="kaos-polo">Kaos Polo</a></li>                                              
                  <li><a href="atasan-pria">Semua Atasan</a></li>
                </ul>
              </li>
              <li><a href="#">Aksesoris <span class="caret"></span></a>
                <ul class="dropdown-menu">                
                  <li><a href="gelang-tangan-pria">Gelang</a></li>
                  <li><a href="topi-pria">Topi</a></li>
                  <li><a href="bowtie">Bowtie</a></li>
                  <li><a href="tas-pria">Tas</a></li>                                                
                  <li><a href="dompet-pria">Dompet</a></li>
                </ul>
              </li>
              <li><a href="terbaru">Semua Produk</a></li>
      			  <li><a href="http://www.instagram.com/testimoni_idfashioncowok" target="_blank">Testimoni</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>       
    </div>
  </section>
  <!-- / menu -->