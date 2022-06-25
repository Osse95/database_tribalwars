<?php
require_once dirname(__DIR__, 2) . "/classes/World_User.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Die Stämme Datenbank</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/logo/favicon.png">

    <!-- Fontawesome -->
    <link href="/assets/fontawesome/css/all.css" rel="stylesheet">

    <!-- Bootstrap -->
    <script type="text/javascript" src="/assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/standard.css">
    <link rel="stylesheet" href="/assets/css/normal.css">

    <!-- Datatables -->
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>
    <link rel="stylesheet" href="/assets/css/datatables.min.css">

    <!-- Jquery -->
    <script type="text/javascript" src="/assets/js/chart.min.js"></script>

    <!-- Matomo -->
    <script>
        let _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            let u = "//diestaemmedb.de/matomo/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '1']);
            let d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

