<?php

Route::group(['module' => 'Module', 'middleware' => ['api'], 'namespace' => 'App\Modules\Module\Controllers'], function() {

    Route::resource('module', 'ModuleController');

});
