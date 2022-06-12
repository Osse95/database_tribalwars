<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Die Stämme DB</title>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/logo/favicon.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/standard.css">
    <link rel="stylesheet" href="/assets/css/normal.css">
    <script type="text/javascript" src="/assets/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap -->

    <!-- Datatables -->
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>
    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <!-- Datatables -->

    <!-- Jquery -->
    <script type="text/javascript" src="/assets/js/jquery-latest.min.js"></script>
    <!-- Jquery -->

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
<body>
<div class="container p-4 mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <img src="/assets/images/logo/Logo.png" class="img-fluid" alt="Logo">
        </div>

        <div class="row justify-content-center">
            <div class="col-auto">
                <button ID="tabLogin" class="btn btn-primary m-1"> Login</button>
                <button ID="tabRegister" class="btn btn-primary m-1"> Registrieren</button>
            </div>
        </div>
    </div>

    <div id="login" class="row">
        <div class="col-12 mt-2 text-center error"></div>

        <div class="col-xl-3 col-xs-12"></div>
        <div class="col-xl-3 mt-2 col-xs-12">
            <div class="input-group">
                <span class="input-group-text">Username</span>
                <input id="loginName" type="text" class="form-control" placeholder="Username">
            </div>
        </div>
        <div class="col-xl-3 mt-2 col-xs-12">
            <div class="input-group">
                <span class="input-group-text">Passwort</span>
                <input id="loginPassword" type="password" class="form-control" placeholder="Passwort">
            </div>
        </div>
        <div class="col-xl-3 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2">
            <div class="input-group">
                <label class="input-group-text">Welt</label>
                <select id="loginWorld" class="form-select">
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12 mt-2">
            <div class="form-check">
                <input class="form-check-input" id="stayLogged" type="checkbox" checked>
                <label class="form-check-label" for="flexCheckDefault">
                    Eingeloggt bleiben?
                </label>
            </div>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2 text-center">
            <button id="loginBtn" class="btn btn-primary"> Einloggen</button>
        </div>
        <div class="col-xl-4 col-xs-12"></div>
    </div>

    <div id="register" class="row">
        <div class="col-12 mt-2 text-center error"></div>
        <div class="col-xl-3 col-xs-12"></div>
        <div class="col-xl-3 mt-2 col-xs-12">
            <div class="input-group">
                <span class="input-group-text">Username</span>
                <input id="registerName" type="text" class="form-control" placeholder="Username">
            </div>
        </div>
        <div class="col-xl-3  mt-2 col-xs-12">
            <div class="input-group">
                <span class="input-group-text">Passwort</span>
                <input id="registerPassword" type="password" class="form-control" placeholder="Passwort">
            </div>
        </div>
        <div class="col-xl-3 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2 d-flex justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="newDatabase">
                <label class="form-check-label" for="newDatabase">
                    Neue Datenbank
                </label>
            </div>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2">
            <div class="input-group">
                <label class="input-group-text">Welt</label>
                <select id="registerWorld" class="form-select">
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2">
            <div class="input-group">
                <label class="input-group-text">Ingameaccount</label>
                <input id="registerPlayer" list="PlayerAccounts" placeholder="Spieler" class=" form-control">
                <datalist id="PlayerAccounts">
                </datalist>
            </div>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

        <div class="col-xl-4 col-xs-12"></div>
        <div class="col-xl-4 col-xs-12 mt-2 text-center">
            <button id="registerBtn" class="btn btn-primary"> Registrieren</button>
        </div>
        <div class="col-xl-4 col-xs-12"></div>

    </div>
</div>

<script>

    $("#register").hide();

    $("#tabLogin").on("click", function () {
        $("#register").hide();
        $("#login").show();
    })
    $("#tabRegister").on("click", function () {
        $("#register").show();
        $("#login").hide();
    })

    $.ajax({
        url: "/ajax/general/getWorlds.php",
        success: function (data) {
            let result = JSON.parse(data);
            result.forEach(element => {
                $("#loginWorld").append(`<option value="${element}">${element}</option>`)
                $("#registerWorld").append(`<option value="${element}">${element}</option>`)
            });
            if (localStorage.getItem("LastWorld") !== null) {
                $("#loginWorld").val(localStorage.getItem("LastWorld"));
            }
            refreshAccounts();
        }
    });

    $(document).keypress(function (e) {
        const key = e.which;
        if (key == 13) {
            if ($("login").is(":hidden")) {
                login()
            } else {
                register();
            }
        }
    });
    $("#loginBtn").on("click", function () {
        login();
    })
    $("#registerBtn").on("click", function () {
        register();
    })
    $("#registerWorld").on("change", function () {
        refreshAccounts();
    })


    function login() {
        $(".error").html("");
        let userName = $("#loginName").val().trim();
        let userPassword = $("#loginPassword").val().trim();
        let World = $("#loginWorld").val().trim();

        if (userName.length == 0) {
            $(".error").html("Bitte Benutzernamen eingeben.")
            return;
        } else if (userPassword.length == 0) {
            $(".error").html("Bitte Passwort eingeben.")
            return;
        } else if (World.length == 0) {
            $(".error").html("Bitte Welt auswählen.")
            return;
        }
        localStorage.setItem("LastWorld", World);
        let post = {
            name: userName,
            password: userPassword,
            world: World,
            stayLogged: $("#stayLogged").prop("checked")
        }
        $.ajax({
            url: "/ajax/login/login.php",
            data: post,
            type: 'post',
            success: function (data) {
                let result = JSON.parse(data);
                if (result["result"] === true) {
                    location.reload();
                } else {
                    $(".error").text(result["msg"]);
                }
            }
        });
    }

    function register() {
        $(".error").html("");
        let userName = $("#registerName").val().trim();
        let userPassword = $("#registerPassword").val().trim();
        let World = $("#registerWorld").val().trim();
        let Account = $("#registerPlayer").val().trim();

        if (userName.length == 0) {
            $(".error").html("Bitte Benutzernamen eingeben.")
            return;
        } else if (userPassword.length == 0) {
            $(".error").html("Bitte Passwort eingeben.")
            return;
        } else if (World.length == 0) {
            $(".error").html("Bitte Welt auswählen.")
            return;
        } else if (Account.length == 0){
            $(".error").html("Bitte Spieler auswählen.")
            return;
        }
        localStorage.setItem("LastWorld", World);
        let post = {
            name: userName,
            password: userPassword,
            account: Account,
            world: World,
            newDatabase: $("#newDatabase").prop("checked")
        }
        $.ajax({
            url: "/ajax/login/login.php",
            data: post,
            type: 'post',
            success: function (data) {
                let result = JSON.parse(data);
                if (result["result"] === true) {
                    location.reload();
                } else {
                    $(".error").text(result["msg"]);
                }
            }
        });
    }

    function refreshAccounts() {
        $("#PlayerAccounts").empty();
        let World = $("#registerWorld").val().trim();
        let post = {
            world: World
        }
        $.ajax({
            url: "/ajax/general/getNames.php",
            data: post,
            type: 'post',
            success: function (data) {
                let result = JSON.parse(data);
                if (result["result"] === true) {
                    result["userNames"].forEach(element => {
                        $("#PlayerAccounts").append(`<option value="${element}"></option>`)
                    });

                } else {
                    $(".error").text(result["msg"]);
                }
            }
        });
    }
</script>
</body>
</html>
