<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('file-manager', 'AdminFileManagerController@index')
        ->name('file-manager-index');
    $router->get('file-manager/download', 'AdminFileManagerController@download')
        ->name('file-manager-download');
    $router->delete('ile-manager/delete', 'AdminFileManagerController@delete')
        ->name('file-manager-delete');
    $router->put('file-manager/move', 'AdminFileManagerController@move')
        ->name('file-manager-move');
    $router->post('file-manager/upload', 'AdminFileManagerController@upload')
        ->name('file-manager-upload');
    $router->post('file-manager/folder', 'AdminFileManagerController@newFolder')
        ->name('file-manager-new-folder');
});

Route::group([
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => ['web']
    ],function (Router $router){
    $router->get('/storage/{filePath}','StorageController@index')
        ->where(['filePath' => '.*']);
    }
);
//'StorageController@index'
