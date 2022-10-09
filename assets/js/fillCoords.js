$("#coordX").on('input', function () {
    let match = $("#coordX").val().match(/(\d{3})\|(\d{3})/);
    if (match !== null) {
        $("#coordX").val(match[1]);
        $("#coordY").val(match[2]);
    } else if ($("#coordX").val().length == 3) {
        $("#coordY").val("");
        $("#coordY").focus();
    }
});