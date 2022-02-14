<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'Admin\AuthController::login');
$routes->get('/login', 'Admin\AuthController::login');

$routes->group('admin', function($routes){
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('users', 'Admin\UsersController::index');
    $routes->post('users/store', 'Admin\UsersController::store');
    $routes->get('slider', 'Admin\SliderController::index');
    $routes->get('category', 'Admin\CategoryController::index');
    $routes->get('product', 'Admin\ProductController::index');
    $routes->get('supplier', 'Admin\SupplierController::index');
    $routes->get('transaction', 'Admin\TransactionController::index');
    $routes->get('content', 'Admin\ContentController::index');
    $routes->get('content-items/(:num)', 'Admin\ContentController::items/$1');
    $routes->get('content-preview', 'Admin\ContentController::preview');
    $routes->get('pengaturan-kurir', 'Admin\KurirController::index');
    $routes->get('pengaturan-waktu', 'Admin\WaktuController::index');
    $routes->get('pengaturan-system', 'Admin\SystemController::index');
    $routes->get('pengaturan-profile', 'Admin\ProfileController::index');
    $routes->get('logout', 'Admin\AuthController::logout');

    // Api
    $routes->group('api', function($routes){
        $routes->post('login', 'Admin\AuthController::act_login');

        $routes->get('weekTransaction', 'Admin\DashboardController::weekTransaction');
        $routes->get('statusToday', 'Admin\DashboardController::statusToday');
        $routes->get('totalData', 'Admin\DashboardController::totalData');

        $routes->get('users-get/(:any)', 'Admin\UsersController::get/$1');
        $routes->post('users-store', 'Admin\UsersController::store');
        $routes->post('users-update/(:num)', 'Admin\UsersController::update/$1');
        $routes->get('users-delete/(:num)', 'Admin\UsersController::delete/$1');

        $routes->get('slider-get/(:any)', 'Admin\SliderController::get/$1');
        $routes->post('slider-store', 'Admin\SliderController::store');
        $routes->post('slider-update/(:num)', 'Admin\SliderController::update/$1');
        $routes->get('slider-delete/(:num)', 'Admin\SliderController::delete/$1');

        $routes->get('category-get/(:any)', 'Admin\CategoryController::get/$1');
        $routes->post('category-store', 'Admin\CategoryController::store');
        $routes->post('category-update/(:num)', 'Admin\CategoryController::update/$1');
        $routes->get('category-delete/(:num)', 'Admin\CategoryController::delete/$1');

        $routes->get('product-get/(:any)', 'Admin\ProductController::get/$1');
        $routes->post('product-store', 'Admin\ProductController::store');
        $routes->get('product-category', 'Admin\ProductController::getCategory');
        $routes->post('product-update/(:num)', 'Admin\ProductController::update/$1');
        $routes->get('product-delete/(:num)', 'Admin\ProductController::delete/$1');

        $routes->get('supplier-get/(:any)', 'Admin\SupplierController::get/$1');
        $routes->post('supplier-store', 'Admin\SupplierController::store');
        $routes->post('supplier-update/(:num)', 'Admin\SupplierController::update/$1');
        $routes->get('supplier-delete/(:num)', 'Admin\SupplierController::delete/$1');

        $routes->get('content-get/(:any)', 'Admin\ContentController::get/$1');
        $routes->post('content-store', 'Admin\ContentController::store');
        $routes->post('content-update/(:num)', 'Admin\ContentController::update/$1');
        $routes->get('content-delete/(:num)', 'Admin\ContentController::delete/$1');
        $routes->get('content-items/(:num)/(:num)', 'Admin\ContentController::getItems/$1/$2');
        $routes->get('content-items-update/(:num)/(:num)', 'Admin\ContentController::updateItems/$1/$2');

        $routes->get('kurir-get/(:any)', 'Admin\KurirController::get/$1');
        $routes->post('kurir-store', 'Admin\KurirController::store');
        $routes->post('kurir-update/(:num)', 'Admin\KurirController::update/$1');
        $routes->get('kurir-delete/(:num)', 'Admin\KurirController::delete/$1');

        $routes->get('transaction-get/(:any)', 'Admin\TransactionController::get/$1');
        $routes->post('transaction-kurir', 'Admin\TransactionController::transactionKurir');
        $routes->post('transaction-confirm', 'Admin\TransactionController::transactionConfirm');
        $routes->get('transaction-pesanan/(:num)', 'Admin\TransactionController::getPesanan/$1');
        $routes->post('transaction-pesanan', 'Admin\TransactionController::upPesanan');
        $routes->get('transaction-delete/(:num)', 'Admin\TransactionController::delete/$1');

        $routes->get('waktu-get/(:any)', 'Admin\WaktuController::get/$1');
        $routes->post('waktu-store', 'Admin\WaktuController::store');
        $routes->post('waktu-update/(:num)', 'Admin\WaktuController::update/$1');
        $routes->get('waktu-delete/(:num)', 'Admin\WaktuController::delete/$1');

        $routes->get('profile-get', 'Admin\ProfileController::get');
        $routes->post('profile-update', 'Admin\ProfileController::update');

        $routes->post('system-payment-channel-store', 'Admin\SystemController::storePaymentChannel');
        $routes->post('system-api-setting-store', 'Admin\SystemController::storeApiSetting');
        $routes->post('confirm-payment', 'Admin\TransactionController::confirmPayment');

        $routes->get('cronjob-transaction-kurir', 'Admin\CronjobController::kurirExp');
    });
});

$routes->group('api', function($routes){
    $routes->post('login', 'Api\AuthController::login');
    $routes->post('daftar', 'Api\AuthController::daftar');

    $routes->get('slider', 'Api\HomeController::slider');
    $routes->get('category', 'Api\HomeController::category');
    $routes->get('catalog/(:num)', 'Api\HomeController::catalog/$1');
    $routes->get('promo', 'Api\HomeController::promo');

    $routes->get('product', 'Api\ProductController::get');
    $routes->get('product/d/(:num)/(:any)', 'Api\ProductController::getBy/$1/$2');
    $routes->get('product/c/(:num)/(:any)', 'Api\ProductController::getByCategory/$1/$2');
    $routes->get('product/p/(:num)/(:any)', 'Api\ProductController::getByCatalog/$1/$2');
    $routes->get('product/s/(:num)/(:any)', 'Api\ProductController::search/$1/$2');

    $routes->get('cart/(:num)', 'Api\CartController::get/$1');
    $routes->post('cart/(:num)', 'Api\CartController::store/$1');
    $routes->post('cart/up', 'Api\CartController::updated');
    $routes->post('cart/del', 'Api\CartController::deleted');

    // $routes->get('transaction', 'Api\TransactionController::get');
    $routes->get('transaction/type/(:num)/(:any)', 'Api\TransactionController::get/$1/$2');
    $routes->get('transaction/d/(:num)', 'Api\TransactionController::getDetail/$1');
    $routes->post('transaction/(:num)', 'Api\TransactionController::store/$1');
    $routes->post('transaction/(:num)', 'Api\TransactionController::store/$1');

    $routes->get('tesXendit/(:any)/(:num)', 'Api\TransactionController::tesXendit/$1/$2');
    $routes->get('expXendit/(:any)', 'Api\TransactionController::expXendit/$1');

    $routes->get('waktu', 'Api\WaktuController::get');

    $routes->post('profile/(:num)', 'Api\AuthController::updateProfile/$1');
});

$routes->setAutoRoute(false);
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
