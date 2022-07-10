function loadParams(){
    let getParams = window.location.search.substr(1);
    getParams = getParams.split("&");
    for (let i = 0; i < getParams.length; i++) {
        let param = getParams[i].split("=");
        if(param.length == 2){
            $(`input[name=${param[0]}`).val(decodeURI(param[1]));
            $(`input[name=${param[0]}`).trigger("change")
        }
    }
}