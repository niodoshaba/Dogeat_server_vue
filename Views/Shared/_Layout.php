<?php

use Bang\Lib\Bundle;
use Bang\Lib\ResponseBag;
use Bang\Lib\ViewBag;
use Bang\Lib\Url;



$bodyView = ResponseBag::Get("View");
$viewBag = ViewBag::Get();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?= $viewBag->GetTitle() ?></title>
        <meta name="description" content="<?= $viewBag->Description ?>" />
        <link rel="shortcut icon" type="image/x-icon" href="<?= Url::Img('favicon.ico') ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8" />
        <?php
        Bundle::Css('test_css', array(
            './Content/css/style.css'
        ));
        Bundle::Js('test_js', array(
            './Content/js/jquery.js',
            './Content/js/vue.js',
            './Content/js/main.js'
        ));
        ?>
    </head>
    <body>
        <?php
        Bundle::PHP('layout', array(
            "Views/Shared/_Layout/_Header.php",
            "Views/{$bodyView}",
            "Views/Shared/_Layout/_Footer.php"
        ));
        ?>
    </body>
</html>