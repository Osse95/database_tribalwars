function loadParams() {
    let selectOptions = ["coordType"];
    let checkboxOptions = ["watchtower", "church", "academy"]
    let getParams = window.location.search.substr(1);
    getParams = getParams.split("&");
    for (let i = 0; i < getParams.length; i++) {
        let param = getParams[i].split("=");
        if (param.length == 2) {
            if (selectOptions.includes(param[0])) {
                $(`select[name=${param[0]}`).val(decodeURI(param[1]));
            } else if (checkboxOptions.includes(param[0])) {
                $(`input[name=${param[0]}`).prop('checked', true);
            } else {
                $(`input[name=${param[0]}`).val(decodeURI(param[1]));
            }
        }
    }
    $(`input`).trigger("change")
}