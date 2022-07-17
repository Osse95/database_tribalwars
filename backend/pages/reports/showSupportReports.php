<?php
require_once dirname(__DIR__, 3) . "/backend/classes/World_User.php";
$User = new World_User($_SESSION["name"], $_SESSION["world"]);
?>
<div class="container p-4">
    <form id="ValuesTable">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Accountname</span>
                    <input name="playerName" list="playerNames"
                           placeholder="Account" class="form-control">
                    <datalist id="playerNames">
                    </datalist>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
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
                                    <div class="col-md-4 col-xs-12">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Unterstützer</span>
                                            <input name="supporterName" list="playerNames"
                                                   placeholder="Account" class="form-control"
                                                   aria-label="Sizing example input"
                                                   aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Verteidiger</span>
                                            <input name="defenderName" list="playerNames"
                                                   placeholder="Account" class="form-control"
                                                   aria-label="Sizing example input"
                                                   aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-12">

                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Datum vor:</span>
                                            <input type="date"
                                                   name="dateBefore" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                    </div>
                                    <div class="col-md-4 col-xs-12">

                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Datum nach:</span>
                                            <input type="date"
                                                   name="dateAfter" class="form-control">
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
            <th> Unterstützer</th>
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
<script type="text/javascript" src="/assets/js/loadParams.js"></script>
<script type="text/javascript" src="/assets/js/fillCoords.js"></script>
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
            order: [[3, 'desc']],
            "initComplete": function(settings, json) {
                loadParams();
            },
            "lengthMenu": [[10,20,50,75,100,200,500,1000], [10,20,50,75,100,200,500,1000]],
            ajax: {
                url: '/ajax/reports/getSupportTable.php',
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

    $.getJSON("/ajax/reports/getSupportNames.php", function (result) {
        result.forEach(element => {
            $("#playerNames").append(`<option>${element}</option>`)
        })
    });
    $.getJSON("/ajax/reports/getTribeNames.php", function (result) {
        result.forEach(element => {
            $("#tribeNames").append(`<option>${element}</option>`)
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

    $(document).on("change", ".deleteReport", function () {
        deleteReports([$(this).attr("id")])
    })

    function deleteReports(ids) {
        let post = {
            deleteIDS: ids
        }
        $.ajax({
            url: "/ajax/reports/ut_delete.php",
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