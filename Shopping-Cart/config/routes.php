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
$cnf['*'][CONTROLLERS]['home'][METHODS]['index'] = 'index';
$cnf['*'][CONTROLLERS]['home'][REQUEST_METHOD]['index'] = 'get';

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
$cnf['Admin'][NS] = 'Controllers\Admin';
$cnf['Admin'][CONTROLLERS]['index'][GOES_TO] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['index'] = 'index';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['index'] = 'get';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['edit'] = 'edit';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['edit'] = 'get';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['add'] = 'add';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['add'] = 'post';
$cnf['Admin'][CONTROLLERS]['index'][METHODS]['remove'] = 'remove';
$cnf['Admin'][CONTROLLERS]['index'][REQUEST_METHOD]['remove'] = 'delete';

// Editor panel
$cnf['Editor'][NS] = 'Controllers\Editor';
$cnf['Editor'][CONTROLLERS]['index'][GOES_TO] = 'index';
$cnf['Editor'][CONTROLLERS]['index'][METHODS]['index'] = 'index';
$cnf['Editor'][CONTROLLERS]['index'][REQUEST_METHOD]['index'] = 'get';
$cnf['Editor'][CONTROLLERS]['category'][GOES_TO] = 'category';
$cnf['Editor'][CONTROLLERS]['category'][METHODS]['add'] = 'add';
$cnf['Editor'][CONTROLLERS]['category'][REQUEST_METHOD]['index'] = 'post';
$cnf['Editor'][CONTROLLERS]['category'][METHODS]['remove'] = 'remove';
$cnf['Editor'][CONTROLLERS]['category'][REQUEST_METHOD]['remove'] = 'delete';
$cnf['Editor'][CONTROLLERS]['category'][METHODS]['rename'] = 'rename';
$cnf['Editor'][CONTROLLERS]['category'][REQUEST_METHOD]['rename'] = 'put';


return $cnf;