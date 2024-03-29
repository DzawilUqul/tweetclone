<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

// Route untuk halaman
$routes->get('/', 'Tweet::index', ['filter'=>'cekLogin']);
$routes->get('/category/(:segment)', 'Tweet::category/$1', ['filter'=>'cekLogin']);

$routes->get('/add', 'Tweet::addForm', ['filter'=>'cekLogin']);
$routes->get('/edit/(:num)', 'Tweet::editForm/$1', ['filter'=>'cekLogin']);

$routes->get('/auth', 'Auth::index');
$routes->get('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');


// Route untuk aksi
$routes->post('/add_user', 'Auth::addUser');
$routes->post('/login', 'Auth::login');

$routes->post('/add', 'Tweet::addTweet', ['filter'=>'cekLogin']);
$routes->get('/delete/(:num)', 'Tweet::delTweet/$1', ['filter'=>'cekLogin']);
$routes->post('/edit', 'Tweet::editTweet', ['filter'=>'cekLogin']);

// ===== Fitur Tambahan =====
// 1. Edit Profile
$routes->get('/edit_profile', 'Auth::EditProfileForm', ['filter'=>'cekLogin']);
$routes->post('/edit_profile', 'Auth::EditProfile', ['filter'=>'cekLogin']);

// 2. Upload Profile Image
$routes->get('/upload_profile_image', 'Auth::UploadProfileImageForm', ['filter'=>'cekLogin']);
$routes->post('/upload_profile_image', 'Auth::UploadProfileImage', ['filter'=>'cekLogin']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
