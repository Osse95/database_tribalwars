let mouseOverPlayers = [], previewPlayerInformations = [], mouseOverTribes = [], previewTribeInformations = [],mouseOverVillages = [], previewVillageInformations = [];
let playerPreviewID, playerPreviewElement, tribePreviewID, tribePreviewElement,villagePreviewElement,villagePreviewID;

$(document).on("mouseover", ".previewPlayerinfo", function () {
    $('[data-toggle="popover"]').popover('hide');
    if (!mouseOverPlayers.includes(this)) {
        mouseOverPlayers.push(this)
        playerPreviewElement = this;
        playerPreviewID = $(this).attr("href").replace("/playerInfo?ID=", "");
        if (!previewPlayerInformations[playerPreviewID]) {
            $.ajax({
                url: "/ajax/player/getNormalPlayerData.php",
                data: {id: playerPreviewID},
                type: 'post',
                success: function (data) {
                    let result = JSON.parse(data);
                    $(playerPreviewElement).attr("data-toggle", "popover");
                    $(playerPreviewElement).attr("data-placement", "bottom");
                    let content;
                    if (typeof result === "object") {
                        content = "Rang: " + result["rank"] + "<br>"
                        content += "Punkte: " + formatNumber(result["points"]) + "<br>";
                        content += "Dörfer: " + formatNumber(result["villages"]) + "<br>";
                    } else {
                        content = "Spieler nicht gefunden."
                    }
                    previewPlayerInformations[playerPreviewID] = content;
                    $(playerPreviewElement).popover({
                        content: content,
                        trigger: "hover",
                        html: true
                    });
                    $(playerPreviewElement).popover("show")
                }
            });
        } else {
            $(playerPreviewElement).attr("data-toggle", "popover");
            $(playerPreviewElement).attr("data-placement", "bottom");
            $(playerPreviewElement).popover({
                content: previewPlayerInformations[playerPreviewID],
                trigger: "hover",
                html: true
            });
            $(playerPreviewElement).popover("show")
        }
    }
})

$(document).on("mouseover", ".previewTribeinfo", function () {
    $('[data-toggle="popover"]').popover('hide');
    if (!mouseOverTribes.includes(this)) {
        mouseOverTribes.push(this)
        tribePreviewElement = this;
        tribePreviewID = $(this).attr("href").replace("/tribeInfo?ID=", "");
        if (!previewTribeInformations[tribePreviewID]) {
            $.ajax({
                url: "/ajax/tribe/getNormalTribeData.php",
                data: {id: tribePreviewID},
                type: 'post',
                success: function (data) {
                    let result = JSON.parse(data);
                    $(tribePreviewElement).attr("data-toggle", "popover");
                    $(tribePreviewElement).attr("data-placement", "bottom");
                    let content;
                    if (typeof result === "object") {
                        content = "Rang: " + result["rank"] + "<br>"
                        content += "Punkte: " + formatNumber(result["points"]) + "<br>";
                        content += "Dörfer: " + formatNumber(result["villages"]) + "<br>";
                    } else {
                        content = "Spieler nicht gefunden."
                    }
                    previewTribeInformations[tribePreviewID] = content;
                    $(tribePreviewElement).popover({
                        content: content,
                        trigger: "hover",
                        html: true
                    });
                    $(tribePreviewElement).popover("show")
                }
            });
        } else {
            $(tribePreviewElement).attr("data-toggle", "popover");
            $(tribePreviewElement).attr("data-placement", "bottom");
            $(tribePreviewElement).popover({
                content: previewTribeInformations[tribePreviewID],
                trigger: "hover",
                html: true
            });
            $(tribePreviewElement).popover("show")
        }
    }
})

$(document).on("mouseover", ".previewVillageinfo", function () {
    $('[data-toggle="popover"]').popover('hide');
    if (!mouseOverVillages.includes(this)) {
        mouseOverVillages.push(this)
        villagePreviewElement = this;
        villagePreviewID = $(this).attr("href").replace("/villageInfo?ID=", "");
        if (!previewVillageInformations[villagePreviewID]) {
            $.ajax({
                url: "/ajax/village/getNormalVillageData.php",
                data: {id: villagePreviewID},
                type: 'post',
                success: function (data) {
                    let result = JSON.parse(data);
                    $(villagePreviewElement).attr("data-toggle", "popover");
                    $(villagePreviewElement).attr("data-placement", "bottom");
                    let content;
                    if (result["villageOwner"] !== undefined) {
                        content = "Besitzer: " + result["villageOwner"] + "<br>";
                        content += "Punkte: " + formatNumber(result["villageInfo"]["points"]) + "<br>";
                    } else {
                        content = "Dorf nicht gefunden."
                    }
                    previewVillageInformations[villagePreviewID] = content;
                    $(villagePreviewElement).popover({
                        content: content,
                        trigger: "hover",
                        html: true
                    });
                    $(villagePreviewElement).popover("show")
                }
            });
        } else {
            $(villagePreviewElement).attr("data-toggle", "popover");
            $(villagePreviewElement).attr("data-placement", "bottom");
            $(villagePreviewElement).popover({
                content: previewVillageInformations[villagePreviewID],
                trigger: "hover",
                html: true
            });
            $(villagePreviewElement).popover("show")
        }
    }
})