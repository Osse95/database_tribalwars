<?php
require_once dirname(__DIR__, 3) . "/backend/classes/World_User.php";
$User = new World_User($_SESSION["name"], $_SESSION["world"]);
?>
<div class="container p-4">
    <form id="ValuesTable">
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Accountname</span>
                    <input name="playerName" list="playerNames"
                           placeholder="Account" class="form-control">
                    <datalist id="playerNames">
                    </datalist>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Stamm</span>
                    <input name="tribeName" list="tribeNames"
                           placeholder="Stamm" class=" form-control">
                    <datalist id="tribeNames">

                    </datalist>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Koords</span>
                    <input type="text"
                           id="coordX" name="coordX" placeholder="500" class="form-control">
                    <input type="text"
                           id="coordY" maxlength="3" name="coordY" placeholder="500" class="form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="input-group input-group-sm mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    <select class="form-select" name="coordType" id="inputGroupSelect01">
                        <option> Beliebig</option>
                        <option> Off</option>
                        <option> Def</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Kontinent</span>
                    <input type="text" name="continent"
                           class="form-control" placeholder="55" maxlength="2">
                </div>
            </div>
            <div class="col-3">
            </div>
            <div class="col-lg-2 col-md-2 col-xs-12 me-2 d-flex justify-content-center">
                <div class="form-check">
                    <input class="form-check-input"
                           name="watchtower" type="checkbox">
                    <label class="form-check-label">
                        Wachturm
                    </label>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-12 d-flex justify-content-center">
                <div class="form-check">
                    <input class="form-check-input"
                           name="church" type="checkbox">
                    <label class="form-check-label">
                        Kirche
                    </label>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-12 d-flex justify-content-center">
                <div class="form-check">
                    <input class="form-check-input"
                           name="academy" type="checkbox">
                    <label class="form-check-label">
                        Adelshof
                    </label>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                Erweiterte Suche
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Angreifer</span>
                                            <input name="attackerName" list="playerNames"
                                                   placeholder="Account" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Verteidiger</span>
                                            <input name="defenderName" list="playerNames"
                                                   placeholder="Account" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Speicher unter:</span>
                                            <input type="number" name="storageLevel"
                                                   placeholder="0" class="form-control" max-length="2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Bauernhof unter:</span>
                                            <input type="number" name="farmLevel"
                                                   placeholder="0" class="form-control" max-length="2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Schmiede unter:</span>
                                            <input type="number" name="smithLevel"
                                                   placeholder="0" class="form-control" max-length="2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Wachturm unter:</span>
                                            <input type="number" name="watchtowerLevel"
                                                   placeholder="0" class="form-control" max-length="2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">ZS unter:</span>
                                            <input name="moodUnder" placeholder="100" type="number" class="form-control"
                                                   max-length="3">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">

                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Datum vor:</span>
                                            <input type="date" name="dateBefore" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Datum nach:</span>
                                            <input type="date" name="dateAfter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Katapultziel:</span>
                                            <input name="cataTarget" list="cataTargets"
                                                   placeholder="Kapatultziel" class="form-control">
                                            <datalist id="cataTargets">

                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<div class="container p-4 mt-4 table-responsive">
    <table class="table table-dark table-hover table-striped" ID="Reports">
        <thead>
        <tr>
            <th> Angreifer</th>
            <th> Verteidiger</th>
            <th> Befehl</th>
            <th> Zeit</th>
            <?php
            if ($User->isSF() || $User->isMod()) {
                ?>
                <th><input type='checkbox' id='deleteAll'> Löschen</th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="/assets/js/fillCoords.js"></script>
<script type="text/javascript" src="/assets/js/loadParams.js"></script>
<script>
    $(document).ready(function () {
        let DataTable = $('#Reports').DataTable({
            "paging": true,
            "searching": false,
            "info": true,
            processing: true,
            serverSide: true,
            "columnDefs": [{
                "targets": 2,
                "orderable": false
            }],
            stateSave: true,
            order: [[3, 'desc']],
            "initComplete": function (settings, json) {
                loadParams();
            },
            "lengthMenu": [[10,20,50,75,100,200,500,1000], [10,20,50,75,100,200,500,1000]],
            ajax: {
                url: '/ajax/reports/getReportTable.php',
                type: 'POST',
                async: true,
                // dataSrc: ,
                data: function (d) {
                    $("#ValuesTable :INPUT").each(function () {
                        if ($(this).attr("type") == "checkbox") {
                            d[$(this).attr("name")] = $(this).prop("checked");
                        } else {
                            d[$(this).attr("name")] = $(this).val();
                        }
                    })
                }
            }
        });
        $("#ValuesTable Input").on("change", function () {
            DataTable.ajax.reload();
        });
    });

    $.getJSON("/ajax/reports/getNames.php", function (result) {
        result.forEach(element => {
            $("#playerNames").append(`<option>${element}</option>`)
        })
    });
    $.getJSON("/ajax/reports/getTribeNames.php", function (result) {
        result.forEach(element => {
            $("#tribeNames").append(`<option>${element}</option>`)
        })
    });
    $.getJSON("/ajax/reports/getCataTargets.php", function (result) {
        result.forEach(element => {
            $("#cataTargets").append(`<option>${element}</option>`)
        })
    });
    <?php
    if($User->isMod() || $User->isSF()){
    ?>
    $("#deleteAll").on("click", function () {
        let deleteIDs = [];
        $(".deleteReport").each(function () {
            deleteIDs.push($(this).attr("id"))
        })
        if (deleteIDs.length > 0) {
            deleteReports(deleteIDs);
        }
    })

    $(document).on("click", ".deleteReport", function () {
        deleteReports([$(this).attr("id")])
    })

    function deleteReports(ids) {
        let post = {
            deleteIDS: ids
        }
        $.ajax({
            url: "/ajax/reports/delete.php",
            data: post,
            type: 'post',
            success: function (data) {
                let result = JSON.parse(data);
                if (result["return"] == true) {
                    DataTable.ajax.reload();
                }
            }
        });
    }
    <?php
    }
    ?>
</script>
