<html>
<head>
    <meta charset="UTF-8">
    <title>Ajax Test</title>
    <?php //TODO add boostrap to the project folders ?>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<h1>Ajax test</h1>
<button id="btn" class="btn btn-default" onclick="sentAjax()">Submit Ajax</button>
<div id="#"></div>
<script>
    function sentAjax() {
        <?php
        \FTS\AjaxViewHelper::init()->initForm("/api/jsonroutes", "put")->initCallback("function( msg ) {
           document.getElementById(\"#\").innerHTML = msg;
        }")->render(true);
?>
    }
</script>
</body>
</html>