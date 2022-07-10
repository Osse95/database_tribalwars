let mouseOverPlayers = [], previewPlayerInformations = [],mouseOverTribes = [], previewTribeInformations = [];
let playerPreviewID, playerPreviewElement,tribePreviewID, tribePreviewElement;

$(document).bind('DOMSubtreeModified', function () {
    setTimeout(function () {
        $(".previewPlayerinfo").mouseover(function () {
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
        $(".previewPlayerinfo").mouseout(function () {
            $('[data-toggle="popover"]').popover('hide');
        })
        $(".previewTribeinfo").mouseover(function () {
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
        $(".previewTribeinfo").mouseout(function () {
            $('[data-toggle="popover"]').popover('hide');
        })
    }, 500)
})