<?php

use App\Livewire\User\MyProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/my-profile', MyProfile::class)->name('my-profile');

    Route::get('/settings', \App\Livewire\Settings\Index::class)->name('setting');

    Route::get('/issues', \App\Livewire\Issues\Index::class)->name('issues');
    Route::get('/issue-detail/{issue}', \App\Livewire\Issues\IssueDetail::class)->name('issue-detail');

    Route::get('/reports', \App\Livewire\Report\Index::class)->name('reports');

    Route::get('/notifications',\App\Livewire\Notification::class)->name('notifications');

    Route::get('/',\App\Livewire\Dashboard\Index::class)->name('dashboard');

    Route::get('/user-manuals', \App\Livewire\UserManual\Index::class)->name('user-manuals');
});
