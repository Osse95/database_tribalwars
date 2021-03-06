<?php
require_once dirname(__DIR__, 3) . "/backend/classes/World.php";
require_once dirname(__DIR__, 3) . "/backend/classes/World_User.php";
$World = new World($_SESSION["world"]);
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
                    <span class="input-group-text">Koords</span>
                    <input type="text"
                           id="coordX" name="coordX" placeholder="500" class="form-control">
                    <input type="text"
                           id="coordY" maxlength="3" name="coordY" placeholder="500" class="form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Angriffstyp</span>
                    <input type="text" class="form-control" name="type"
                           placeholder="Ramme,Späh,AG usw." aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-3">
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="off">
                    <label class="form-check-label" for="flexCheckDefault">
                        Off
                    </label>
                </div>
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="fake">
                    <label class="form-check-label" for="flexCheckDefault">
                        Fake
                    </label>
                </div>
            </div>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="double">
                    <label class="form-check-label" for="flexCheckDefault">
                        Doppler
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container table-responsive">
    <table class="table table-dark" ID="allAttacks">
        <thead>
        <tr>
            <th> Type</th>
            <th> Verteidiger</th>
            <th> Ziel</th>
            <th> Angreifer</th>
            <th> Herkunft</th>
            <th> Grund</th>
            <th> Eingelesen am</th>
            <th> Doppler</th>
            <th> Typ</th>
            <?php
            if (!$World->isWatchtowerAvailable()) {
                ?>
                <th> Ankunft</th>
                <?php
            } else {
                ?>
                <th> Ankunft (Ankunft im WT)</th>
            <?php }
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
    $.getJSON("/ajax/attacks/getNames.php", function (result) {
        result.forEach(element => {
            $("#playerNames").append(`<option>${element}</option>`)
        })
    });

    $(document).ready(function () {
        let DataTable = $('#allAttacks').DataTable({
            "paging": true,
            "searching": false,
            "info": true,
            processing: true,
            serverSide: true,
            "createdRow": function (row, data, dataIndex) {
                if (data[8] == `Fake`) {
                    $(row).addClass('fake');
                } else if (data[8] == `Mögliche Off` || data[8] == `mögliche Off`) {
                    $(row).addClass('moff');
                } else if (data[8] == `Off`) {
                    $(row).addClass('off');
                } else if (data[8] == `AG`) {
                    $(row).addClass('snob');
                } else if (data[8] == `mittlerer Angriff`) {
                    $(row).addClass('middle');
                }
            },
            stateSave: true,
            order: [[9, 'asc']],
            "initComplete": function(settings, json) {

                loadParams();
            },
            "lengthMenu": [[10,20,50,75,100,200,500,1000], [10,20,50,75,100,200,500,1000]],
            ajax: {
                url: '/ajax/attacks/getAllAttackTable.php',
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

        <?php
        if($User->isMod() || $User->isSF()){
        ?>
        $("#deleteAll").on("click", function () {
            let deleteIDs = [];
            $(".deleteAttack").each(function () {
                deleteIDs.push($(this).attr("id"))
            })
            if (deleteIDs.length > 0) {
                deleteAttacks(deleteIDs);
            }
        })

        $(document).on("click", ".deleteAttack", function () {
            deleteAttacks([$(this).attr("id")])
        })

        function deleteAttacks(ids) {
            let post = {
                deleteIDS: ids
            }
            $.ajax({
                url: "/ajax/attacks/delete.php",
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

    });
</script>