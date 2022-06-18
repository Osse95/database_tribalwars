<?php
require_once dirname(__DIR__, 3) . "/backend/classes/World.php";
$World = new World($_SESSION["world"]);
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
            <?php if (!$World->isWatchtowerAvailable()) { ?>
                <th> Ankunft</th>
            <?php } else { ?>
                <th> Ankunft (Ankunft im WT)</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

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
            order: [[9, 'asc']],
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
    });
</script>