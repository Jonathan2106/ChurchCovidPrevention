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
$route['assets/(:any)'] = 'assets/$1';
$route['events/add'] = 'events/create';
$route['events/new_event'] = 'events/new_event';
$route['events/onsite_reg/(:any)'] = 'events/onsite_reg/$1';
$route['events/attend/(:any)/(:num)'] = 'events/process_attend/$1/$2';
$route['add_participant/process_add'] = 'events/process_add_participant_to_event';
$route['add_committee/process_add'] = 'events/process_add_committee_to_event';
$route['add_participant/phpinfo.php'] = 'events/phpinfo';
$route['events/(:any)'] = 'events/view/$1';
$route['onsite/(:any)'] = 'events/onsite/$1';
$route['summary/(:any)'] = 'events/summary/$1';
$route['manage/(:any)'] = 'events/manage/$1';
$route['hide/(:any)'] = 'events/hide/$1';
$route['add_participant/(:any)'] = 'events/add_participant_to_event/$1';
$route['add_committee/(:any)'] = 'events/add_committee_to_event/$1';
$route['events'] = 'events';
$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'events';
