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
$route['default_controller'] = 'home';
$route['404_override'] = 'home/notfound';
$route['translate_uri_dashes'] = TRUE;

//Static Page
$route['tentang-kami'] = 'page/about';
$route['(\w{2})/tentang-kami'] = 'page/about';

$route['kontak-kami'] = 'contact/index';
$route['(\w{2})/kontak-kami'] = 'contact/index';

$route['mitra-alam'] = 'page/mitraalam';
$route['(\w{2})/mitra-alam'] = 'page/mitraalam';

$route['syarat-dan-ketentuan'] = 'page/tnc';
$route['(\w{2})/syarat-dan-ketentuan'] = 'page/tnc';

$route['kebijakan-privasi'] = 'page/policy';
$route['(\w{2})/kebijakan-privasi'] = 'page/policy';

//Donate
$route['donasi'] = 'donate/index';
$route['(\w{2})/donasi'] = 'donate/index';
$route['donasi/notifikasi'] = 'donate/notification';
$route['(\w{2})/donasi/notifikasi'] = 'donate/notification';
$route['donasi/simpan'] = 'donate/saved';
$route['(\w{2})/donasi/simpan'] = 'donate/saved';
$route['donasi/sukses'] = 'donate/success';
$route['(\w{2})/donasi/sukses'] = 'donate/success';
$route['donasi/gagal'] = 'donate/unfinish';
$route['(\w{2})/donasi/gagal'] = 'donate/unfinish';
$route['donasi/error'] = 'donate/error';
$route['(\w{2})/donasi/error'] = 'donate/error';
$route['donasi/token'] = 'donate/token';
$route['(\w{2})/donasi/token'] = 'donate/token';

//Dinamis slug
$route['artikel'] = 'article/index';
$route['(\w{2})/artikel'] = 'article/index';
$route['artikel/(:any)'] = 'article/detail/$1';
$route['(\w{2})/artikel/(:any)'] = 'article/detail/$2';

$route['sejarah/(:any)'] = 'stories/detail/$1';
$route['(\w{2})/sejarah/(:any)'] = 'stories/detail/$2';

$route['program'] = 'program/index';
$route['(\w{2})/program'] = 'program/index';
$route['program/(:any)'] = 'program/detail/$1';
$route['(\w{2})/program/(:any)'] = 'program/detail/$2';

//Redirection URL & tracking
$route['r/(:any)'] = 'redirection/detail/$1';

//Image banner & tracking
$route['banner/(:any)'] = 'redirection/banner/$1';

//route example: http://domain.tld/id/controller => http://domain.tld/controller
$route['(\w{2})/(.*)']	= '$2';
$route['(\w{2})']	= $route['default_controller'];


