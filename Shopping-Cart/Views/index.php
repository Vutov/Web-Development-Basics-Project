<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1>Index View</h1>
<div><?= $this->_viewBag->getSomeShit() ?></div>
<?php
\FTS\FormViewHelper::init()->initTextBox()->setAttribute('class', 'some')->setName('username')->setValue('pesho')->create()->render();
?>
</body>
</html>