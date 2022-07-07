<div class="container p-4">
    <div class="row">
        <div class="col-12 text-center mb-3">
            1. Userscript runterladen -> <a
                    href="https://media.innogamescdn.com/com_DS_DE/Scriptdatenbank/userscript/452.user.js" b
                    target="_blank">Hier</a> <br>
            2. Auf der Angriffsübersichtsseite einfach "o" drücken, damit das Userscript sich öffnet. <br>
            3. Danach nehmt ihr die Koordinaten von Unten und fügt sie bei dem Userscript ein. <br>
            4. Den dazugehörigen Infotext eingeben und "Import" klicken. <br>
            5. Auf den "Angriffe umbenennen"button klicken im Userscript & <br>
            dann werden die Angriffe so umbenannt, wie ihr sie mit dem Infotext abgespeichert habt. <br>
            6. <a href="/Userscript.mp4" b target="_blank">Erklärungsvideo</a>
        </div>
        <div class="col-md-6 mt-3 col-xs-12">
            <button class="btn-primary btn mb-2" id="copyOffs"> Offs in die Zwischenablage kopieren</button>
            <div class="input-group">
                <span class="input-group-text">Offs</span>
                <textarea id="Offs" class="form-control" aria-label="With textarea"></textarea>
            </div>
        </div>
        <div class="col-md-6 mt-3 col-xs-12">
            <button class="btn-primary btn mb-2" id="copyFakes"> Fakes in die Zwischenablage kopieren</button>
            <div class="input-group">
                <span class="input-group-text">Fakes</span>
                <textarea id="Fakes" class="form-control" aria-label="With textarea"></textarea>
            </div>
        </div>
    </div>
</div>

<div class="placeholder">
    <br></br>
</div>

<script>
    $("#copyFakes").on("click", function () {
        let copyText = document.getElementById("Fakes");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    })
    $("#copyOffs").on("click", function () {
        let copyText = document.getElementById("Offs");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    })
    $.getJSON("/ajax/attacks/getAttackCoords.php", function (result) {
        $("#Offs").val(result["offs"].toString())
        $("#Fakes").val(result["fakes"].toString())
    })
</script>