<div class="container p-4">

    <div class="row mb-3">
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <button class="btn btn-primary me-3" id="troopsTab" data-bs-toggle="tab" data-bs-target="#troops"
                        type="button" role="tab" aria-controls="troops" aria-selected="true">Truppen
                </button>

                <button class="btn btn-primary me-3" id="buildingsTab" data-bs-toggle="tab" data-bs-target="#buildings"
                        type="button" role="tab" aria-controls="buildings" aria-selected="false">Gebäude
                </button>

                <button class="btn btn-primary" id="mapTab" data-bs-toggle="tab" data-bs-target="#map" type="button"
                        role="tab" aria-controls="map" aria-selected="false">Karte
                </button>
            </div>
        </div>
    </div>
    <div id="troops">
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-4">
                <div class="card bg-secondary">
                    <div class="card-header">
                        Truppen insgesamt
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-dark table-hover table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th><img src="/assets/images/inno/report/unit_spear.png" title="Speerträger"></th>
                                <th><img src="/assets/images/inno/report/unit_sword.png" title="Schwertkämpfer"></th>
                                <th><img src="/assets/images/inno/report/unit_axe.png" title="Axtkämpfer"></th>
                                <th class="archer"><img src="/assets/images/inno/report/unit_archer.png" title="Bogen">
                                </th>
                                <th><img src="/assets/images/inno/report/unit_spy.png" title="Späher"></th>
                                <th><img src="/assets/images/inno/report/unit_light.png" title="Leichte Kavallerie">
                                </th>
                                <th class="archer"><img src="/assets/images/inno/report/unit_marcher.png"
                                                        title="Beritten"></th>
                                <th><img src="/assets/images/inno/report/unit_heavy.png" title="Schwere Kavallerie">
                                </th>
                                <th><img src="/assets/images/inno/report/unit_ram.png" title="Rammbock"></th>
                                <th><img src="/assets/images/inno/report/unit_catapult.png" title="Katapult"></th>
                                <th><img src="/assets/images/inno/report/unit_snob.png" title="Adelsgeschlecht"></th>
                            </tr>
                            </thead>
                            <tbody id="troopsAllInAllBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center mt-4">
                <div class="card bg-secondary">
                    <div class="card-header">
                        Truppen
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-dark table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Dorf</th>
                                <th></th>
                                <th><img src="/assets/images/inno/report/unit_spear.png" title="Speerträger"></th>
                                <th><img src="/assets/images/inno/report/unit_sword.png" title="Schwertkämpfer"></th>
                                <th><img src="/assets/images/inno/report/unit_axe.png" title="Axtkämpfer"></th>
                                <th class="archer"><img src="/assets/images/inno/report/unit_archer.png" title="Bogen">
                                </th>
                                <th><img src="/assets/images/inno/report/unit_spy.png" title="Späher"></th>
                                <th><img src="/assets/images/inno/report/unit_light.png" title="Leichte Kavallerie">
                                </th>
                                <th class="archer"><img src="/assets/images/inno/report/unit_marcher.png"
                                                        title="Beritten"></th>
                                <th><img src="/assets/images/inno/report/unit_heavy.png" title="Schwere Kavallerie">
                                </th>
                                <th><img src="/assets/images/inno/report/unit_ram.png" title="Rammbock"></th>
                                <th><img src="/assets/images/inno/report/unit_catapult.png" title="Katapult"></th>
                                <th class="knight"><img src="/assets/images/inno/report/unit_knight.png" title="Pala">
                                </th>
                                <th><img src="/assets/images/inno/report/unit_snob.png" title="Adelsgeschlecht"></th>
                            </tr>
                            </thead>
                            <tbody id="troopsBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="buildings">
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-4">
                <div class="card bg-secondary">
                    <div class="card-header">
                        Gebäude
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-dark table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Dorf</th>
                                <th><img src='/assets/images/inno/report/main.png' title='Hauptgebäude'></th>
                                <th><img src='/assets/images/inno/report/barracks.png' title='Kaserne'></th>
                                <th><img src='/assets/images/inno/report/stable.png' title='Stall'></th>
                                <th><img src='/assets/images/inno/report/garage.png' title='Werkstatt'></th>
                                <th class="church"><img src='/assets/images/inno/report/church.png' title='Kirche'></th>
                                <th class="church"><img src='/assets/images/inno/report/church.png'
                                                        title='Erste Kirche'></th>
                                <th class="watchtower"><img src='/assets/images/inno/report/watchtower.png'
                                                            title='Wachturm'></th>
                                <th><img src='/assets/images/inno/report/snob.png' title='Adelshof'></th>
                                <th><img src='/assets/images/inno/report/smith.png' title='Schmiede'></th>
                                <th><img src='/assets/images/inno/report/place.png' title='Versammlungsplatz'></th>
                                <th><img src='/assets/images/inno/report/statue.png' title='Statue'></th>
                                <th><img src='/assets/images/inno/report/market.png' title='Marktplatz'></th>
                                <th><img src='/assets/images/inno/report/wood.png' title='Holzfällerlager'></th>
                                <th><img src='/assets/images/inno/report/stone.png' title='Lehmgrube'></th>
                                <th><img src='/assets/images/inno/report/iron.png' title='Eisenmine'></th>
                                <th><img src='/assets/images/inno/report/farm.png' title='Bauernhof'></th>
                                <th><img src='/assets/images/inno/report/storage.png' title='Speicher'></th>
                                <th class="hide"><img src='/assets/images/inno/report/hide.png' title='Versteck'></th>
                                <th><img src='/assets/images/inno/report/wall.png' title='Wall'></th>
                            </tr>
                            </thead>
                            <tbody id="buildingsBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="map">
        <div class="row p-4">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                <div class="card bg-secondary">
                    <div class="card-body ">
                        <h5 class="card-title">Spieler</h5>
                        Legende:
                        <font color="darkblue">Blau(Stamm)</font>
                        <font color="red"> Rot(Feind)</font>
                        <font color="yellow"> Gelb(Wachturm) </font>
                        <font color="white"> Weiß(Eigener Account) </font>
                        <font color="darkblue">Blauer Kreis(Kirche)</font>
                        <p class="card-text text-center mt-2">
                            <a href="/ajax/graphic/userMap.php" target="_blank">
                                <img src="/ajax/graphic/userMap.php" loading="lazy" class="img-fluid Map">
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
            </div>
        </div>
    </div>
</div>
<div class="placeholder">
    <br></br>
</div>


<script>

    let buildings = false;

    $("#troops").css("display", "block");
    $("#buildings").css("display", "none");
    $("#map").css("display", "none");


    $("#troopsTab").on('click', function () {
        $("#troops").css("display", "block");
        $("#buildings").css("display", "none");
        $("#map").css("display", "none");
    });

    $("#buildingsTab").on('click', function () {
        if (!buildings) {
            loadBuildings();
        }
        $("#troops").css("display", "none");
        $("#buildings").css("display", "block");
        $("#map").css("display", "none");
    });

    $("#mapTab").on('click', function () {
        $("#troops").css("display", "none");
        $("#buildings").css("display", "none");
        $("#map").css("display", "block");
    })

    let archer = true;
    $.getJSON("/ajax/ownVillages/getOwnTroopsAllInAll.php", function (result) {
        let tableRow = "<tr>";
        tableRow += `<td> eigene </td>`;
        tableRow += `<td></td>`;
        result["own"].forEach(element => {
            tableRow += `<td>${element}</td>`
        });
        tableRow += "</tr>";
        tableRow += "<tr>";
        tableRow += `<td> im Dorf </td>`;
        tableRow += `<td></td>`;
        result["inVillage"].forEach(element => {
            tableRow += `<td>${element}</td>`
        });
        tableRow += "</tr>";
        tableRow += "<tr>";
        tableRow += `<td> auswärts </td>`;
        tableRow += `<td></td>`;
        result["outwards"].forEach(element => {
            tableRow += `<td>${element}</td>`
        });
        tableRow += "</tr>";
        tableRow += "<tr>";
        tableRow += `<td> insgesamt </td>`;
        tableRow += `<td></td>`;
        result["all"].forEach(element => {
            tableRow += `<td>${element}</td>`
        });
        tableRow += "</tr>";
        tableRow += "<tr>";
        tableRow += `<td> zuletzt Eingelesen </td>`;
        tableRow += `<td></td>`;
        tableRow += `<td> ${result["time"]} </td>`;
        tableRow += `<td colspan="100%"></td>`;
        $("#troopsAllInAllBody").append(tableRow)

        $("#troopsAllInAllBody").find("tr").each(function () {
            if ($(this).children().eq(5).text() < 0) {
                $(this).children().eq(5).hide()
                $(this).children().eq(8).hide()
                archer = false;
            }
        })
        if (!archer) {
            $(".archer").hide()
        }
    })

    $.getJSON("/ajax/ownVillages/getOwnTroops.php", function (result) {
        for (let i = 0; i < result["village"].length; i++) {
            let tableRow = "<tr>";
            tableRow += `<td> ${result["village"][i]} </td>`;
            tableRow += `<td> eigene </td>`;
            result["own"][i].forEach(element => {
                tableRow += `<td>${element}</td>`
            });
            tableRow += "</tr>";
            tableRow += "<tr>";
            tableRow += `<td> </td>`;
            tableRow += `<td> im Dorf </td>`;
            result["inVillage"][i].forEach(element => {
                tableRow += `<td>${element}</td>`
            });
            tableRow += "</tr>";
            tableRow += "<tr>";
            tableRow += `<td> </td>`;
            tableRow += `<td> auswärts </td>`;
            result["outwards"][i].forEach(element => {
                tableRow += `<td>${element}</td>`
            });
            tableRow += "</tr>";
            tableRow += "<tr>";
            tableRow += `<td> </td>`;
            tableRow += `<td> insgesamt </td>`;
            result["all"][i].forEach(element => {
                tableRow += `<td>${element}</td>`
            });
            tableRow += "</tr>";
            $("#troopsBody").append(tableRow)
        }
        $("#troopsBody").find("tr").each(function () {
            if ($(this).children().eq(5).text() < 0) {
                $(this).children().eq(5).hide()
                $(this).children().eq(8).hide()
                archer = false;
            }
        })
        if (!archer) {
            $(".archer").hide()
        }
    })

    function loadBuildings() {
        $.getJSON("/ajax/ownVillages/getOwnBuildings.php", function (result) {
            for (let i = 0; i < result.length; i++) {
                let tableRow = "<tr>";
                result[i].forEach(element => {
                    tableRow += `<td>${element}</td>`
                });
                tableRow += "</tr>";
                $("#buildingsBody").append(tableRow)
            }
        })
    }
</script>