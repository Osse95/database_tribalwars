<?php
require_once dirname(__DIR__, 2) . "/classes/World_User.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
?>

<div class="container p-4">
    <div class="row">
        <div class="col-12 text-center" id="msg"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4 col-xs-12">
            <textarea id="improvement" class="form-control"
                      placeholder="Dein Verbesserungsvorschlag"></textarea>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-4"></div>
        <div class="col-4 d-flex justify-content-center mt-2">
            <button class="btn btn-primary" id="sendImprovement">
                Absenden
            </button>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<div class="container p-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-10 col-xs-12">
            <table class="table table-dark table-hover table-striped">
                <thead>
                <tr>
                    <th> Benutzer</th>
                    <th> Vorschlag</th>
                    <th> Antwort</th>
                </tr>
                </thead>
                <tbody id="improvementBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $("#sendImprovement").on("click", function () {
        $("#msg").text("");

        let improvement = $("#improvement").val();
        if (improvement.length < 30) {
            $("#msg").text("Bitte ausführlichen Vorschlag schreiben.")
            return;
        } else {

        }
    })

    $.getJSON("/ajax/improvement/getAllImprovements.php", function (result) {
        result.forEach(element => {
            let row = `<tr>
                            <td>${element[0]}</td>
                            <td>${element[1]}</td>
                            <td>${element[2]}</td>
                           </tr>`
            $("#improvementBody").append(row)
        })
        <?php
        if($World_User->isAdmin()){
        ?>
        $("#improvementBody > tr").each(function () {
            $(this).children().eq(2).html($(this).children().eq(2).text() + '<br><textarea class="improvementAnswer form-control"</textarea>')
        });
        <?php
        }
        ?>
    })

    <?php
    if($World_User->isAdmin()){
    ?>
    $(document).on("change", ".improvementAnswer", function () {
        let answer = $(this).val().trim();
        let user = $(this).closest("tr").find("td:eq(0)").text().trim();
        let improvement = $(this).closest("tr").find("td:eq(1)").text().trim();
        console.log(answer)
    })
    <?php
    }
    ?>
</script>