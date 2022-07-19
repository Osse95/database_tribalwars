<div class="placeholder">
    <br/>
</div>
<footer id="footer" class="fixed-bottom navbar navbar-primary bg-primary">
    <div class="col-12 px-0 text-center">
        <ul class="list-inline my-0 mt-2">
            <li class="list-inline-item mr-0">
                <small>
                    <a href="https://discord.gg/73uYTK2nmp" target="_blank">
                        <i class="fa-brands fa-discord"></i> <font class="footertext">Discordserver</font>
                    </a></small>
            </li>
            <li class="list-inline-item mr-0">
                <small>
                    <a href="/improvement">
                        <i class="fa-regular fa-comment-dots"></i> <font
                                class="footertext">Verbesserungsvorschläge</font>
                    </a>
                </small>
            </li>
            <li class="list-inline-item mr-0">
                <small>
                    <font>
                        Changeworld
                    </font>
                </small>
            </li>
            <li class="list-inline-item mr-0">
                <small>
                    <font>
                        Ladezeit: <?php echo round((microtime(true) - $time)*1000,2); ?> ms
                    </font>
                </small>
            </li>
            <li class="list-inline-item mr-0">
                <small>
                    <font>
                        DB Version: <?php echo $World_User->getVersion(); ?>
                    </font>
                </small>
            </li>
        </ul>
    </div>
</footer>