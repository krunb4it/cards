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
$route['profile'] = 'config/profile';
$route['profile_validate/(:any)/(:any)'] = 'config/profile_validate/$1/$2';
$route['404_override'] = 'welcome/error404';
$route['translate_uri_dashes'] = FALSE;


/*
	API Rroute
*/

/*-------------------------------------------
	Info
-------------------------------------------*/
$route['api/info/(:any)']					= 'api/config/info/$1';
$route['api/slider/(:any)/(:any)'] 			= 'api/config/slider/$1/$2';
$route['api/page/(:any)/(:any)']			= 'api/config/page/$1/$2';
$route['api/category/(:any)/(:any)']		= 'api/config/category/$1/$2';
$route['api/category_card/(:any)/(:any)']	= 'api/config/card_by_category/$1/$2';
$route['api/card/(:any)/(:any)']			= 'api/config/card/$1/$2';

/*-------------------------------------------
	Auth
-------------------------------------------*/
$route['auth/do_auth']						= 'api/auth/do_auth';
$route['auth/forget_password']				= 'api/auth/forget_password';
$route['auth/change_password']				= 'api/auth/change_password';

/*-------------------------------------------
	Customer
-------------------------------------------*/
$route['customer/my_info']						= 'api/customer/my_info';
$route['customer/create_order']					= 'api/customer/create_order';
$route['customer/my_order/(:any)']				= 'api/customer/my_order/$1';
$route['customer/my_order_id/(:any)/(:any)']	= 'api/customer/my_order_id/$1/$2';
$route['customer/my_order_card/(:any)']			= 'api/customer/my_order_card/$1';
$route['customer/my_wallet']					= 'api/customer/my_wallet';
$route['customer/my_notifications']				= 'api/customer/my_notifications';
$route['customer/print_order_card']				= 'api/customer/print_order_card';

/*
	validiations
*/
$route['adminValidateAccount/(:any)/(:any)']	= 'validiations/adminValidateAccount/$1/$2';
$route['customerValidateAccount/(:any)/(:any)']	= 'validiations/customerValidateAccount/$1/$2';



// front end website

$route['error404']          		= 'extracard/error404';
$route['view_category']      		= 'extracard/view_category';
$route['view_sub_category/(:any)']	= 'extracard/view_sub_category/$1';
$route['view_card/(:any)']          = 'extracard/view_card/$1';
$route['view_page/(:any)']          = 'extracard/view_page/$1';

$route['viewCart']			= 'extracard/viewCart';
$route['addToCart']			= 'extracard/addToCart';
$route['updateToCart']		= 'extracard/updateToCart';
$route['removeFromCart']	= 'extracard/removeFromCart';
$route['clearCart']			= 'extracard/clearCart';


/*
	customerProfile


$route['customerProfile']			= 'validiations/customerProfile';

*/



