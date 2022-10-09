<?php
require_once dirname(__DIR__, 3) . "/backend/classes/World.php";
$World = new World($_SESSION["world"]);
?>

<div class="container p-4">
    <div class="row">
        <div class="col-12 text-center mb-4 fs-5"> Tabeinheiten</div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_spear.png" alt="Speer">
                    </span>
                <input type="text" class="form-control" name="spear" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_sword.png" alt="Schwert">
                    </span>
                <input type="text" class="form-control" name="sword" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_axe.png" alt="Axt">
                    </span>
                <input type="text" class="form-control" name="axe" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_light.png" alt="Lkav">
                    </span>
                <input type="text" class="form-control" name="light" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_heavy.png" alt="Skav">
                    </span>
                <input type="text" class="form-control" name="heavy" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_ram.png" alt="Ramme">
                    </span>
                <input type="text" class="form-control" name="ram" placeholder="0">
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_catapult.png" alt="Kata">
                    </span>
                <input type="text" class="form-control" name="catapult" placeholder="0">
            </div>
        </div>
        <div class=" col-md-3 col-xs-12">
            <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_snob.png" alt="AG">
                    </span>
                <input type="text" class="form-control" name="snob" placeholder="0">
            </div>
        </div>
        <?php if ($World->isArcherAvailable()) { ?>
            <div class=" col-md-3 col-xs-12">
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_archer.png" alt="Bogen">
                    </span>
                    <input type="text" class="form-control" name="archer" placeholder="0">
                </div>
            </div>
            <div class=" col-md-3 col-xs-12">
                <div class="input-group mb-3">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/report/unit_marcher.png" alt="Beritten">
                    </span>
                    <input type="text" class="form-control" name="marcher" placeholder="0">
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
            </div>
        <?php } ?>
        <div class="col-1">
        </div>
        <div class="col-md-3 col-xs-12 ms-5">
            <div class="input-group ">
                    <span class="input-group-text"><img
                                src="/assets/images/inno/icons/friendship.png"
                                width="26px" height="26px" alt="Freundschaft">
                    </span>
                <select class="form-select" name="friendship">
                    <option value="0.00">0%</option>
                    <option value="0.01">1%</option>
                    <option value="0.02">2%</option>
                    <option value="0.03">3%</option>
                    <option value="0.04">4%</option>
                    <option value="0.05">5%</option>
                    <option value="0.06">6%</option>
                    <option value="0.07">7%</option>
                    <option value="0.08">8%</option>
                    <option value="0.09">9%</option>
                    <option value="0.1">10%</option>
                    <option value="0.11">11%</option>
                    <option value="0.12">12%</option>
                    <option value="0.13">13%</option>
                    <option value="0.14">14%</option>
                    <option value="0.15">15%</option>
                    <option value="0.16">16%</option>
                    <option value="0.17">17%</option>
                    <option value="0.18">18%</option>
                    <option value="0.19">19%</option>
                    <option value="0.2">20%</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-2">
                    <span class="input-group-text">
                        <img src="/assets/images/inno/icons/supBoost.png"
                             width="26px" height="26px"
                             alt="UT_Boost">
                    </span>
                <select class="form-select" name="supBooster">
                    <option value="0.00">0%</option>
                    <option value="0.1">10%</option>
                    <option value="0.2">20%</option>
                    <option value="0.3">30%</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="input-group mb-2">
                <span class="input-group-text">Ergebnisse</span>
                <input type="number"
                       class="form-control" name="results" value="10">
            </div>
        </div>
        <div class="col-4">
        </div>
        <div class="col-md-4 col-xs-12 mt-2">
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="ignoreKnight">
                </div>
                <span class="form-control">
                        <img src="/assets/images/inno/report/unit_knight.png">
                        Paladin ignorieren
                    </span>
            </div>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
        </div>
        <div class="col-md-4 col-xs-12 mt-2">
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="doubler">
                </div>
                <span class="form-control"><img src="/assets/images/inno/icons/attack.png"> Keine Doppler</span>
            </div>
        </div>
        <div class="col-4">
        </div>
        <div class="col-12 text-center mb-2">
            <button id="newCoord" class="btn-primary btn">Dorf hinzufügen</button>
        </div>
        <div class="row" id="manuallyCoords">
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Ziel</span>
                    <input type="text" name="coordX" placeholder="500" class="coordX form-control">
                    <input type="text" maxlength="3" placeholder="500" name="coordY" class="coordY form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Datum</span>
                    <input type="date" name="arrivalDate" class="form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"> Ankunftszeit</span>
                    <input type="text" name="arrivalTime" placeholder="12:00:00:000" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4 d-flex justify-content-center">
            <button class="mt-2 btn btn-primary" id="submit">Lets Tab</button>
        </div>
        <div class="col-4">
        </div>
    </div>
</div>

<script>
    let today = new Date();
    today = today.toISOString().substring(0, 10);
    $("input[name=arrivalDate]").val(today);

    $(".coordX").on('input', function () {
        let match = $(".coordX").val().match(/(\d{3})\|(\d{3})/);
        if (match !== null) {
            $(this).val(match[1]);
            $(this).next().val(match[2]);
        } else if ($(this).val().length == 3) {
            $(this).next().val("");
            $(this).next().focus();
        }
    });

    $("#newCoord").on("click",function (){
        $("#manuallyCoords").append(`
        <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Ziel</span>
                    <input type="text" name="CoordX" placeholder="500" class="CoordX form-control">
                    <input type="text" maxlength="3" placeholder="500" name="CoordY" class="CoordY form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Datum</span>
                    <input type="date" name="arrivalDate" value="${today}" class="form-control">
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text"> Ankunftszeit</span>
                    <input type="text" name="arrivalTime" placeholder="12:00:00:000" class="form-control">
                </div>
            </div>
        `)
    })
</script>
