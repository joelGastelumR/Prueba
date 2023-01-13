<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*DPVALE PRODUCCION*/
$route['dpvale/principal'] = 'dpvale/dpvale_controller';
$route['dpvale'] = 'dpvale/dpvale_controller';
$route['dpvale/getvale'] = 'dpvale/dpvale_controller/getvale';
$route['dpvale/getcanjeante'] = 'dpvale/dpvale_controller/getCanjeante';
$route['dpvale/getColonias'] = 'dpvale/dpvale_controller/getColonias';
$route['dpvale/saveCustomer'] = 'dpvale/dpvale_controller/saveCustomer';
$route['dpvale/getpromociones'] = 'dpvale/dpvale_controller/getpromociones';
$route['dpvale/setventa'] = 'dpvale/dpvale_controller/setventa';
$route['dpvale/tickets'] = 'dpvale/dpvale_controller/getTickets';
$route['dpvale/setRevale'] = 'dpvale/dpvale_controller/setRevale';
$route['dpvale/setBeneficiario'] = 'dpvale/dpvale_controller/setBeneficiario';

/*DPVALE PRUEBAS*/
$route['dpvale1/principal'] = 'dpvale1/principal_controller';
$route['dpvale1'] = 'dpvale1/principal_controller';
$route['dpvale1/getvale'] = 'dpvale1/principal_controller/getvale';
$route['dpvale1/getcanjeante'] = 'dpvale1/principal_controller/getCanjeante';
$route['dpvale1/getColonias'] = 'dpvale1/principal_controller/getColonias';

/* DPCLUP PRODUCTIVO */
$route['dpclub/getpromociones'] = 'dpclub/Dpclub_controller/getpromociones';
$route['dpclub/validabin'] = 'dpclub/Dpclub_controller/validabin';
$route['dpclub/validabin'] = 'dpclub/Dpclub_controller/validabin';
$route['dpclub/consulta'] = 'dpclub/Dpclub_controller/consulta';

/* Lealtad Blue */
$route['blue/balance'] = 'blue/blue/balance';
$route['blue'] = 'blue/Balance';

/* DPvale devoluciones */
$route['dpvale_devolucion'] = 'dpvale_devolucion/devoluciones';

/*DPVALE PARA ECOMMERCES DPVALECOM*/
$route['dpvalecom'] = 'dpvalecom/Dpvalecom_controller';
$route['dpvalecom/error'] = 'dpvalecom/Dpvalecom_controller/error';
$route['dpvalecom/getvale'] = 'dpvalecom/dpvalecom_controller/getvale';
$route['dpvalecom/checkcode'] = 'dpvalecom/dpvalecom_controller/checkCode';
$route['dpvalecom/setventa'] = 'dpvalecom/dpvalecom_controller/setventa';
$route['dpvalecom/parentescos'] = 'dpvalecom/dpvalecom_controller/getParentescos';
$route['dpvalecom/beneficiario'] = 'dpvalecom/dpvalecom_controller/setBeneficiario';
$route['dpvalecom/guardarpoliza'] = 'dpvalecom/dpvalecom_controller/generarpoliza';
$route['dpvalecom/poliza/(:any)'] = 'dpvalecom/dpvalecom_controller/download/$1';
$route['dpvalecom/reenvio'] = 'dpvalecom/dpvalecom_controller/reenvio';
$route['dpvalecom/pruebas/(:any)'] = 'dpvalecom/dpvalecom_controller/pruebaExternas/$1';
