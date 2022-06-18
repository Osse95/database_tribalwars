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

<nav class="navbar navbar-expand-xl navbar-dark bg-primary sticky-top" style="margin-bottom:30px;">
    <div class="container-fluid">
        <span class="navbar-brand">
            <img src="/assets/images/logo/Logo.png" height="24" class="d-inline-block align-text-top">
            Datenbank
            <span ID="TribeIconHeader"> <img ID="tribeIcon" src="/assets/images/logo/Logo.png" height="24"
                                             class="d-inline-block align-text-top"> </span>
        </span>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/overview"><i class="fa-regular fa-calendar-check tablet"></i>
                        Übersicht</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/insert"><i class="fa-regular fa-copy tablet"></i> Insert</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false"><i class="fa-solid fa-chart-column tablet"></i> Ranglisten </a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/ranking">
                                <font class="dropitem">Rangliste</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/dbRanking">
                                <font class="dropitem">DB Rangliste</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/auswertungIncs">
                                <font class="dropitem">Auswertung der Incs</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/createDiagram">
                                <font class="dropitem">Diagram erstellen</font>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/villages"><i class="fa-solid fa-house-user tablet"></i> Dörfer</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false"><i class="fa-solid fa-paperclip tablet"></i> Berichte <span class="quantityReports"></span></a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/showReports">
                                <font class="dropitem">Angriffsberichte <span class="quantityReports"></span></font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/showUTReports">
                                <font class="dropitem">UT-Berichte <span class="quantitySupportReports"></span></font>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false"><i class="fa-regular fa-bell tablet"></i> Angriffe <span
                                class="quantityAllAttacks"></span>
                    </a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/ownAttacks">
                                <font class="dropitem">Eigene Angriffe <span class="quantityOwnAttacks"></span>
                                </font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/allAttacks">
                                <font class="dropitem">Angriffe <span class="quantityAllAttacks"></span>
                                </font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/tab">
                                <font class="dropitem">Tab it</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/tabHaendisch">
                                <font class="dropitem">Tab it (Händisch)</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/retimes">
                                <font class="dropitem">Aktuelle Retimes </font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/heatmap">
                                <font class="dropitem">Hitzekarte</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/CreateattackPlan">
                                <font class="dropitem">Neuer Angriffsplaner</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/dbtods">
                                <font class="dropitem">Angriffe übertragen</font>
                            </a></li>
                    </ul>
                </li>

                <?php if ($World_User->isSF() or $World_User->isOffKoord()) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                           aria-expanded="false"><i class="fa-solid fa-pen-to-square tablet"></i> Offplanung </a>
                        <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item bg-primary" href="/offplanung">
                                    <font class="dropitem">Offplanung</font>
                                </a></li>
                            <li><a class="dropdown-item bg-primary" href="/attackPlan.php">
                                    <font class="dropitem">Dailys <span class="quantityDailys"></span></font>
                                </a></li>

                        </ul>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/offs/attackPlan.php"><i
                                    class="fa-solid fa-pen-to-square tablet"></i>
                            Dailys <span class="quantityDailys"></span> </a>
                    </li>
                <?php } ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false"><i class="fa-solid fa-magnifying-glass tablet"></i> Suche </a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/search">
                                <font class="dropitem">Suche</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/conquers">
                                <font class="dropitem">Alle Adelungen</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/statistik">
                                <font class="dropitem">Weltstatistik</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/dorffilter">
                                <font class="dropitem">Dorffilter</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/compare">
                                <font class="dropitem">Vergleich</font>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle id=" dropdown01" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa-solid fa-earth-europe tablet"></i> Karten</a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/worldmap">
                                <font class="dropitem">Top Ten Karte</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/createMap">
                                <font class="dropitem">Eigene Karte erstellen</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/createGif">
                                <font class="dropitem">Eigenes Gif erstellen</font>
                            </a></li>
                        <?php
                        if ($World_User->isSF() or $World_User->isDefKoord()) { ?>
                            <li><a class="dropdown-item bg-primary" href="/SFDefMap">
                                    <font class="dropitem">Defkarte</font>
                                </a></li>
                        <?php } else { ?>
                            <li><a class="dropdown-item bg-primary" href="/defMap">
                                    <font class="dropitem">Deffkarte</font>
                                </a></li>
                        <?php } ?>
                        <li><a class="dropdown-item bg-primary" href="/interactiveMap">
                                <font class="dropitem">interaktive Karte</font>
                            </a></li>
                    </ul>
                </li>
                <?php
                if ($World_User->isSF()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/sf"><i class="fa-regular fa-chess-queen tablet"></i> SF</a>
                    </li>
                    <?php
                } ?>
                <?php
                if ($World_User->isAdmin()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin"><i class="fa-solid fa-key tablet"></i> Admin</a>
                    </li>
                    <?php
                } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                       aria-expanded="false"><i class="fa-solid fa-sliders tablet"></i> Sonstiges</a>
                    <ul class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item bg-primary" href="/user">
                                <font class="dropitem">User</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/logout">
                                <font class="dropitem">Logout</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/münzen">
                                <font class="dropitem">Münzenrechner</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/raubzug">
                                <font class="dropitem">Raubzug</font>
                            </a></li>
                        <li><a class="dropdown-item bg-primary" href="/change">
                                <font class="dropitem">Angriffsplan in UV Plan</font>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item bg-primary" href="/truppenrechner">
                                <font class="dropitem">Truppenrechner</font>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item bg-primary" href="/lzrechner">
                                <font class="dropitem">Laufzeitrechner</font>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item bg-primary" href="/wtrechner">
                                <font class="dropitem">Wachturmrechner</font>
                            </a>
                        </li>
                        <li><a class="dropdown-item bg-primary" href="/workbenchtodsultimate">
                                <font class="dropitem">Workbench -> DS Ultimate</font>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <span class="navbar-brand">
            <?php if ($World_User->uvModeActivated()) { ?>|<span class="text-danger">
                UV-Modus </span><?php } ?>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.innerWidth > 992) {
            document.querySelectorAll('.navbar .nav-item').forEach(function (everyitem) {
                everyitem.addEventListener('mouseover', function (e) {
                    let el_link = this.querySelector('a[data-bs-toggle]');
                    if (el_link != null) {
                        let nextEl = el_link.nextElementSibling;
                        el_link.classList.add('show');
                        nextEl.classList.add('show');
                    }
                });
                everyitem.addEventListener('mouseleave', function (e) {
                    let el_link = this.querySelector('a[data-bs-toggle]');
                    if (el_link != null) {
                        let nextEl = el_link.nextElementSibling;
                        el_link.classList.remove('show');
                        nextEl.classList.remove('show');
                    }
                })
            });
        }
    });
    $("#tribeIcon").css("visibility", "hidden");
    $.getJSON("/ajax/general/getTribeID.php", function (result) {
        let post = {
            id: result
        }
        $.ajax({
            url: "/ajax/inno/guestTribePage.php",
            data: post,
            type: 'post',
            success: function (data) {
                if($("img",$(".vis",$(data)).eq(3)).length > 0){
                     let src = $("img",$(".vis",$(data)).eq(3)).attr("src");
                    $("#tribeIcon").attr("src", src);
                    $("#tribeIcon").css("border-radius", "5px");
                    $("#tribeIcon").css("visibility", "visible");
                }
            }
        });
    })

    refreshCounters();
    setInterval(function () {
        refreshCounters()
    }, 30000)

    function refreshCounters() {
        $.getJSON("/ajax/header/getCounters.php", function (result) {
            $(".quantityAllAttacks").text(`(${result["quantityAttacksAll"]})`)
            $(".quantityOwnAttacks").text(`(${result["quantityAttacksOwn"]})`)
            $(".quantityDailys").text(`(${result["quantityDailys"]})`)
            $(".quantityReports").text(`(${result["quantityReportsAll"]})`)
            $(".quantitySupportReports").text(`(${result["quantitySupportReportsAll"]})`)
        })
    }
</script>