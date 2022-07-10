let mouseOvers = [], previewPlayerInformations = [];
let playerPreviewID, playerPreviewElement;

$(document).bind('DOMSubtreeModified', function () {
    setTimeout(function () {
        $(".previewPlayerinfo").mouseover(function () {
            if (!mouseOvers.includes(this)) {
                mouseOvers.push(this)
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
                            if (result) {
                                content = "Rang: " + result["rank"] + "<br>"
                                content += "Punkte: " + formatNumber(result["points"]) + "<br>";
                                content += "Dörfer: " + result["villages"] + "<br>";
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
    }, 500)
})