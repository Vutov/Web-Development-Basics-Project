<?php
/**
 * Route -> namespace of the route.
 * Use lowercase for keys.
 * No request method means get
 */

const GOES_TO = 'goesTo'; // witch controller it goes to
const METHODS = 'methods';
const REQUEST_METHOD = 'requestMethod';
const NS = 'namespace';
const CONTROLLERS = 'controllers';

// Default
$cnf['*'][NS] = 'Controllers';

// Home
$cnf['*'][CONTROLLERS]['home'][GOES_TO] = 'index';
$cnf['*'][CONTROLLERS]['home'][METHODS]['new'] = 'index';
$cnf['*'][CONTROLLERS]['home'][REQUEST_METHOD]['new'] = 'post';

// Login
$cnf['*'][CONTROLLERS]['user'][GOES_TO] = 'user';
$cnf['*'][CONTROLLERS]['user'][METHODS]['login'] = 'login';
$cnf['*'][CONTROLLERS]['user'][REQUEST_METHOD]['login'] = 'post';
// Register
$cnf['*'][CONTROLLERS]['user'][METHODS]['register'] = 'register';
$cnf['*'][CONTROLLERS]['user'][REQUEST_METHOD]['register'] = 'post';
// Logout
$cnf['*'][CONTROLLERS]['user'][METHODS]['logout'] = 'logout';

// Api
$cnf['*'][CONTROLLERS]['api'][GOES_TO] = 'api';
$cnf['*'][CONTROLLERS]['api'][METHODS]['index'] = 'index';

// Categories
$cnf['*'][CONTROLLERS]['categories'][GOES_TO] = 'category';
$cnf['*'][CONTROLLERS]['categories'][METHODS]['index'] = 'index';

// Cart
$cnf['*'][CONTROLLERS]['cart'][GOES_TO] = 'cart';
$cnf['*'][CONTROLLERS]['cart'][METHODS]['index'] = 'index';

// Administration panel
$cnf['Admin/users'][NS] = 'Controllers\something';

$cnf['Admin'][NS] = 'Controllers\Admin';
$cnf['Admin'][CONTROLLERS]['index'][GOES_TO] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['index'] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['new'] = 'create';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['new'] = 'post';

return $cnf;