<div class="panel">
    <h1>Ajax test</h1>
    <button id="btn" class="btn btn-default" onclick="sent()">Submit Ajax</button>
    <div id="#"></div>
    <script>
        function sent() {
            <?php
            \FTS\AjaxViewHelper::init()->initForm("/api/jsonroutes", "put")->initCallback("function( msg ) {
               document.getElementById(\"#\").innerHTML = msg;
            }")->render(true);
    ?>
        }
    </script>
</div>