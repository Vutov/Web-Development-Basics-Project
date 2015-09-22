<?php
/**
 * Route -> namespace of the route.
 * Use lowercase for keys.
 * No request method means get
 */

const GOES_TO = 'goesTo';
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
$cnf['*'][CONTROLLERS]['home'][METHODS]['login'] = 'login';
$cnf['*'][CONTROLLERS]['home'][REQUEST_METHOD]['login'] = 'post';
// Register
$cnf['*'][CONTROLLERS]['home'][METHODS]['register'] = 'register';
$cnf['*'][CONTROLLERS]['home'][REQUEST_METHOD]['register'] = 'post';
// Logout
$cnf['*'][CONTROLLERS]['home'][METHODS]['logout'] = 'logout';

// Api
$cnf['*'][CONTROLLERS]['api'][GOES_TO] = 'api';
$cnf['*'][CONTROLLERS]['api'][METHODS]['index'] = 'index';


// Administration panel
$cnf['Admin/users'][NS] = 'Controllers\something';

$cnf['Admin'][NS] = 'Controllers\Admin';
$cnf['Admin'][CONTROLLERS]['index'][GOES_TO] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['index'] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['new'] = 'create';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['new'] = 'post';

return $cnf;