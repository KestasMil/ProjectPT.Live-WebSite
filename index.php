<!DOCTYPE html>
<html lang="">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135462040-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-135462040-1');

    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectPT Live</title>
    <link rel="stylesheet" href="fonts/stylesheet.css">
    <link rel="stylesheet" href="main.css">
</head>
<a name="home"></a>
<div class="root_div">
    <div class="header_menu">
        <a href="https://www.twitch.tv/projectpt" target="_blank">
            <div class="twitch-logo"></div>
        </a>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/sections/home_menu.php';?>
    </div>
    <div class="header_logo">
        <div class="logo_text_container heading1-title">
            <p>ProjectPT</p>
            <p class="heading2 italic-style">"Welcome to Actual Hardcore."</p>
        </div>
    </div>
    <?php 
    //$_SERVER['DOCUMENT_ROOT'] = "C:/Users/kestu/Desktop/CODE/WEB/projectPT.live";
    ?>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/sections/intro.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/sections/stats.php';?>
</div>

<body>

</body>

</html>
