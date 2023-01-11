<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
//minificar y ofuscar
$hook['display_override'][] = array(
    'class' => '',
    'function' => 'CI_Minifier_Hook_Loader',
    'filename' => '',
    'filepath' => ''
);
/*
$hook['post_controller_constructor'] = array(
    'class' => 'Key',
    'function' => 'index',
    'filename' => 'key.php',
    'filepath' => 'hooks',
    'params' => array()
);
*/
