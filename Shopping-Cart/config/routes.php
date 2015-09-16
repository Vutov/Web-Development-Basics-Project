<?php
/**
 * Route -> namespace of the route.
 * Use lowercase for keys.
 */

const GOES_TO = 'goesTo';
const METHODS = 'methods';
const NS = 'namespace';
const CONTROLLERS = 'controllers';

// Default
$cnf['*'][NS] = 'Controllers';

// Administration panel
$cnf['Admin/users'][NS] = 'Controllers\something';

$cnf['Admin'][NS] = 'Controllers\Admin';
$cnf['Admin'][CONTROLLERS]['index2'][GOES_TO] = 'index';
$cnf['Admin'][CONTROLLERS]['index2'][METHODS]['new'] = 'create';
$cnf['Admin'][CONTROLLERS]['user'][GOES_TO] = 'some_dude';
$cnf['Admin'][CONTROLLERS]['user'][METHODS]['create'] = 'some_create';

return $cnf;