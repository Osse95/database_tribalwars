<div class="container">
    <div class="row p-4">
        <div class="col-xl-3 col-lg-2 col-xs-12 mt-2">
        </div>
        <div class="col-xl-6 col-lg-8 col-xs-12 mt-2">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <h5 class="card-title">Hol dir den Datenbank Discordbot</h5>
                    <a href="https://discord.com/api/oauth2/authorize?client_id=952509024790798336&permissions=274878032960&scope=bot"
                       target="_blank"> Discordbot einladen </a>
                    <br>
                    <a href="https://discord.com/api/oauth2/authorize?client_id=952509024790798336&permissions=274878032960&scope=bot"
                       target="_blank">
                        <img src="/assets/images/logo/discord_logo.png" class="img-fluid" alt="discord" width="200">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-2 col-xs-12 mt-2">
        </div>
        <div class="col-xl-3 col-lg-2 col-xs-12 mt-2">
        </div>
        <div class="col-xl-6 col-lg-8 col-xs-12 mt-2">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <h5 class="card-title">Nice to Know</h5>
                    <a href="/Kurzanleitung.pdf" target="_blank"> Datenbank Kurzanleitung </a>
                    <br>
                    <a href="/pages/footer/tutorial.php" target="_blank"> Datenbank Tutorial</a>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-2 col-xs-12 mt-2">
        </div>
        <div class="col-sm-6 mt-4">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Spende <i class="fa-brands fa-paypal"></i></h5>
                    <p class="card-text"><a href="https://paypal.me/johnbern" target="_blank">Spenden (Klick mich)</a>
                        <br></br>
                    </p>

                </div>
            </div>
        </div>
        <div class="col-sm-6 mt-4">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Links</h5>
                    <p class="card-text">
                        <a href="https://github.com/extremeCrazyCoder/dsworkbench/releases" target="_blank">Aktuellste
                            DS Workbenchversion (Klick mich)</a>
                        <br>
                        <a href="https://github.com/niondir/ds-timer/releases" target="_blank">Aktuellste DS
                            Timerversion (Klick mich)</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="attackContainer" class="container handy">
    <div class="row p-4 justify-content-md-center">
        <div class="col-lg-8 col-md-10">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Aktuelle Angriffe</h5>
                    <p class="card-text">
                        <canvas id="attacks"></canvas>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="playerDiagram" class="row p-4 justify-content-md-center">
        <div class="col-lg-5 col-md-10 mt-2">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Accountpunkte</h5>
                    <p class="card-text">
                        <canvas id="playerPoints"></canvas>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-10 mt-2">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Accountbashis</h5>
                    <p class="card-text">
                        <canvas id="playerBashis"></canvas>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="tribeDiagram" class="row p-4 justify-content-md-center">
        <div class="col-lg-5 col-md-10 mt-2">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Stammespunkte</h5>
                    <p class="card-text">
                        <canvas id="tribePoints"></canvas>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-10 mt-2">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Stammesbashis</h5>
                    <p class="card-text">
                        <canvas id="tribeBashis"></canvas>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row p-4">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="card bg-secondary">
                <div class="card-body ">
                    <h5 class="card-title">Weltkarte</h5>
                    <p class="card-text text-center">
                        <a href="/graphic/map/heatmap.php" target="_blank">
                            <img src="/graphic/map/heatmap.php" class="img-fluid Map">
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-1">
        </div>
    </div>
</div>
<div class="placeholder">
    <br></br>
</div>

<script>

    createAttackDiagram()
    setInterval(function () {
        createAttackDiagram()
    }, 30000)
    let ChartID = [];

    function createAttackDiagram() {
        $.getJSON("/ajax/overview/getAttackDiagram.php", function (result) {
            let all = [], fakes = [], offs = [], possibleOffs = [], snobs = [], playerNames = [];
            for (const [key, value] of Object.entries(result)) {
                playerNames.push(key)
                all.push(value["all"] ?? 0);
                fakes.push(value["fakes"] ?? 0)
                offs.push(value["offs"] ?? 0)
                possibleOffs.push(value["possibleOffs"] ?? 0)
                snobs.push(value["snobs"] ?? 0)
            }
            if (playerNames.length > 0) {
                $("#attackContainer").show();
                if (ChartID.length > 0) {
                    ChartID[0].destroy();
                    ChartID = []
                }
                ChartID.push(new Chart(document.getElementById("attacks").getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: playerNames,
                        datasets: [{
                            label: 'Fakes',
                            fill: true,
                            borderColor: 'rgba(65,105,225,1)',
                            backgroundColor: 'rgba(8, 0, 255,0.6)',
                            data: fakes,
                            tension: 0.4
                        }, {
                            label: 'Mögliche Offs',
                            fill: true,
                            borderColor: 'rgba(235, 168, 52,0.4)',
                            backgroundColor: 'rgba(235, 168, 52,0.4)',
                            data: possibleOffs,
                            tension: 0.4
                        }, {
                            label: 'Offs',
                            fill: true,
                            borderColor: 'rgba(255,0,0,0.4)',
                            backgroundColor: 'rgba(255,0,0,0.4)',
                            data: offs,
                            tension: 0.4
                        }, {
                            label: 'AGs',
                            fill: true,
                            borderColor: 'rgba(238, 255, 0,1)',
                            backgroundColor: 'rgba(238, 255, 0,0.7)',
                            data: snobs,
                            tension: 0.4

                        }, {
                            label: 'Insgesamt',
                            fill: true,
                            borderColor: 'rgba(128, 128, 128,1)',
                            backgroundColor: 'rgba(128, 128, 128,0.7)',
                            data: all,
                            tension: 0.4
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Spieler',
                                },
                                ticks: {
                                    font: {
                                        size: 16,
                                    }
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Angriffe'
                                },
                                ticks: {
                                    font: {
                                        size: 16,
                                    }
                                }
                            }
                        }
                    }
                }));
            } else {
                $("#attackContainer").hide();
            }
        })
    }

    $.getJSON("/ajax/overview/getDiagramData.php", function (result) {
        if (result["points"].length > 0) {
            createDiagram("playerPoints", "Besiegte Gegner", result["pointsDates"], result["points"], "rgba(0,0,255,0.4)", "rgba(0,0,255,0.1)");
        }
        if (result["bashis"].length > 0) {
            createDiagram("playerBashis", "Punkte", result["bashisDates"], result["bashis"], "rgba(0,0,255,0.4)", "rgba(0,0,255,0.1)");
        }
        if (result["points"].length == 0 && result["bashis"].length == 0) {
            $("#playerDiagram").hide();
        }
        if (result["tribePoints"].length > 0) {
            createDiagram("tribePoints", "Besiegte Gegner", result["tribePointsDates"], result["tribePoints"], "rgba(255,0,0,0.4)", 'rgba(255,0,0,0.1)');
        }
        if (result["tribeBashis"].length > 0) {
            createDiagram("tribeBashis", "Punkte", result["tribeBashisDates"], result["tribeBashis"], "rgba(255,0,0,0.4)", 'rgba(255,0,0,0.1)');
        }
        if (result["tribePoints"].length == 0 && result["tribeBashis"].length == 0) {
            $("#tribeDiagram").hide();
        }
    });

    function createDiagram(id, labelText, label, data, color, bgColor) {
        new Chart(document.getElementById(id).getContext('2d'), {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: labelText,
                    fill: true,
                    borderColor: color,
                    backgroundColor: color,
                    data: data,
                    backgroundColor: bgColor
                }]
            }
        });
    }
</script>