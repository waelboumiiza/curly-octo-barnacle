<?php

Route::group(['module' => 'Module', 'middleware' => ['web'], 'namespace' => 'App\Modules\Module\Controllers'], function() {

    Route::resource('module', 'ModuleController');

});
