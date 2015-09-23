<?php
\FTS\FormViewHelper::init()
    ->initLink()->setAttribute('href', '/')->setValue('Home')->create()->render();
$routes = $this->_viewBag->getRoutes();
foreach ($routes as $route => $bindingModel) {
    \FTS\FormViewHelper::init()
        ->initDiv()->setValue($route)->create()->render();
    if ($bindingModel) {
        \FTS\FormViewHelper::init()
        ->initDiv()->setValue("Binding model params:")->create()->render();
        foreach ($bindingModel as $param) {
            \FTS\FormViewHelper::init()
                ->initDiv()->setValue("*$param")->create()->render();
        }
    }
    echo "<hr>";
}
