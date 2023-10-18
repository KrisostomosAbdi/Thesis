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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->delete('/DataAnggota/(:num)', 'DataAnggota::delete/$1');
$routes->get('/DataAnggota/detail/(:any)', 'DataAnggota::detail/$1');
$routes->get('/DataAnggota/edit/(:segment)', 'DataAnggota::viewUpdate/$1');
$routes->get('/DataAnggota/viewUpdate/(:segment)', 'DataAnggota::viewUpdate/$1');
$routes->delete('/DataAnggota/hapus/(:num)', 'DataAnggota::delete/$1');
$routes->get('/DataAnggota/update/(:segment)', 'DataAnggota::update/$1');
$routes->get('/DataAbsen/deleteAbsen/', 'DataAbsen::deleteAbsen');

// DataKelompok
$routes->get('/DataKelompok/detail/(:any)', 'DataKelompok::detail/$1');
$routes->get('/DataKelompok/Tambah/(:num)', 'DataKelompok::tambah/$1');
$routes->get('/DataKelompok/Tambah/', 'DataKelompok::index');

$routes->get('/DataKelompok/savedata/(:any)', 'DataKelompok::savedata/$1');
$routes->get('/DataKelompok/editnama/(:any)', 'DataKelompok::editnama/$1');
$routes->delete('/DataKelompok/hapus/(:num)', 'DataKelompok::delete/$1');

// DataPetugasMisaBesar
$routes->get('/DataPetugasMisaBesar/detail/(:any)', 'DataPetugasMisaBesar::detail/$1');
$routes->delete('/DataPetugasMisaBesar/hapus/', 'DataPetugasMisaBesar::delete/');
$routes->delete('/DataPetugasMisaBesar/hapusdatamisa/', 'DataPetugasMisaBesar::hapusdatamisa/');

//DataKegiatan
$routes->get('/DataOutdoor/detail/(:num)', 'DataOutdoor::detail/$1');
$routes->delete('/DataOutdoor/deletepeserta/(:num)', 'DataOutdoor::deletepeserta/$1');
$routes->delete('/DataOutdoor/deletekegiatan/', 'DataOutdoor::deletekegiatan/');
$routes->get('/DataOutdoor/editkegiatan/(:segment)', 'DataOutdoor::editkegiatan/$1');
$routes->get('/DataOutdoor/editprosesKegiatan/(:segment)', 'DataOutdoor::editprosesKegiatan/$1');

//Naive Bayes
$routes->get('NaiveBayesController/getId', 'NaiveBayesController::getId');
$routes->get('/NaiveBayesController/viewadvanced', 'NaiveBayesController::viewadvanced', ['filter' => 'role:admin']);
$routes->get('/NaiveBayesController/prediksiAdvancedKapten/(:segment)', 'NaiveBayesController::prediksiAdvancedKapten');
$routes->get('/NaiveBayesController/prediksiAdvancedPengurus/(:segment)', 'NaiveBayesController::prediksiAdvancedPengurus');
$routes->get('/NaiveBayesController/prediksiAdvancedKetua/(:segment)', 'NaiveBayesController::prediksiAdvancedKetua');
$routes->get('/NaiveBayesController/akurasi', 'NaiveBayesController::akurasi', ['filter' => 'role:admin']);
$routes->get('/NaiveBayesController/akurasiresult', 'NaiveBayesController::akurasiresult', ['filter' => 'role:admin']);

//Kelola Dataset
$routes->get('/KelolaDataset/DatasetKapten', 'KelolaDataset::DatasetKapten', ['filter' => 'role:pendamping,admin']);
$routes->get('/KelolaDataset/DatasetPengurus', 'KelolaDataset::DatasetPengurus', ['filter' => 'role:pendamping,admin']);
$routes->get('/KelolaDataset/DatasetKetuaWakil', 'KelolaDataset::DatasetKetuaWakil', ['filter' => 'role:pendamping,admin']);
$routes->get('/KelolaDataset/uploadDataset/(:segment)', 'KelolaDataset::uploadDataset/$1', ['filter' => 'role:pendamping,admin']);

//Admin
// $routes->group('pendamping', ['filter' => 'role:pendamping,admin'], function ($routes) {
$routes->get('/admin', 'Admin::index', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/changeGroup', 'Admin::changeGroup', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/add', 'Admin::add', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/save', 'Admin::save', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/activate', 'Admin::activate', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/getId', 'Admin::getId', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/edit/(:segment)', 'Admin::edit/$1', ['filter' => 'role:pendamping,admin']);
$routes->get('/admin/delete/', 'Admin::delete/', ['filter' => 'role:pendamping,admin']);
// });

// $routes->get('/DataAnggota/PredictKapten/(:segment)', 'DataAnggota::PredictKapten/$1');



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
