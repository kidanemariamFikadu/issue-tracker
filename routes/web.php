<?php

use App\Livewire\User\MyProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/issue-list', \App\Livewire\Public\IssueList::class)->name('issue-list');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', \App\Livewire\Issues\Index::class)->name('dashboard');
    Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)->name('dashboard');

    Route::get('/my-profile', MyProfile::class)->name('my-profile');

    Route::get('/settings', \App\Livewire\Settings\Index::class)->name('setting');

    Route::get('/issues', \App\Livewire\Issues\Index::class)->name('issues');
    Route::get('/issue-detail/{issue}', \App\Livewire\Issues\IssueDetail::class)->name('issue-detail');

    Route::get('/reports', \App\Livewire\Report\Index::class)->name('reports');
});
