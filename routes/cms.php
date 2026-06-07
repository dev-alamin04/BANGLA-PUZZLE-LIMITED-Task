<?php

use App\Http\Controllers\Web\Backend\CMS\CmsContentController;
use Illuminate\Support\Facades\Route;

Route::prefix('cms-contents')->name('admin.cms_contents.')->group(function () {
    Route::patch('/{cms_content}/status', [CmsContentController::class, 'status'])->name('status');

    Route::resource('/', CmsContentController::class)->parameters(['' => 'cms_content']);

    Route::post('get-sections-by-page', [CmsContentController::class, 'getSectionsByPage'])->name('getSectionsByPage');
});
