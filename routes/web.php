<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Livewire\Clients\Index as ClientsIndex;
use App\Livewire\Clients\Create as ClientsCreate;
use App\Livewire\Clients\Update as ClientsUpdate;

use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Products\Create as ProductsCreate;
use App\Livewire\Products\Update as ProductsUpdate;

use App\Livewire\Providers\Index as ProvidersIndex;
use App\Livewire\Providers\Create as ProvidersCreate;
use App\Livewire\Providers\Update as ProvidersUpdate;

use App\Livewire\Sales\Index as SalesIndex;
use App\Livewire\Sales\Show as SalesShow;
use App\Livewire\Sales\Create as SalesCreate;
use App\Livewire\Sales\Update as SalesUpdate;
use App\Livewire\Sales\Reports as SalesReport;

use App\Livewire\ProductDeliveries\Index as ProductDeliveriesIndex;
use App\Livewire\ProductDeliveries\Create as ProductDeliveriesCreate;
use App\Livewire\ProductDeliveries\Update as ProductDeliveriesUpdate;
use App\Livewire\ProductDeliveries\Reports as ProductDeliveriesReport;

use App\Livewire\CategoriesAndMeasures\Index as CategoriesAndMeasuresIndex;

use App\Livewire\CategoriesAndMeasures\CreateCategory as CategoriesCreate;
use App\Livewire\CategoriesAndMeasures\UpdateCategory as CategoriesUpdate;

use App\Livewire\CategoriesAndMeasures\CreateMeasure as MeasuresCreate;
use App\Livewire\CategoriesAndMeasures\UpdateMeasure as MeasuresUpdate;

use App\Livewire\PaymentMethods\Index as PaymentMethodsIndex;
use App\Livewire\PaymentMethods\Create as PaymentMethodsCreate;
use App\Livewire\PaymentMethods\Update as PaymentMethodsUpdate;

use App\Livewire\ClientTypes\Index as ClientTypesIndex;
use App\Livewire\ClientTypes\Create as ClientTypesCreate;
use App\Livewire\ClientTypes\Update as ClientTypesUpdate;

use App\Livewire\PersonTypes\Index as PersonTypesIndex;
use App\Livewire\PersonTypes\Create as PersonTypesCreate;
use App\Livewire\PersonTypes\Update as PersonTypesUpdate;

use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Update as UsersUpdate;

use App\Livewire\Reports\Index as ReportsIndex;
use App\Livewire\Reports\Reports as ReportsReports;

Route::get('/', function () {
    return view('livewire.auth.login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    Route::get('clients', ClientsIndex::class)->name('clients.index');
    Route::get('clients/create', ClientsCreate::class)->name('clients.create');
    Route::get('clients/{client}/update', ClientsUpdate::class)->name('clients.update');

    Route::get('products', ProductsIndex::class)->name('products.index');

    Route::get('sales', SalesIndex::class)->name('sales.index');
    Route::get('sales/create', SalesCreate::class)->name('sales.create');
    Route::get('sales/{sale}/show', SalesShow::class)->name('sales.show');
    Route::get('sales/{sale}/reports/pdf', [SalesReport::class, 'pdf'])->name('sales.reports.pdf');
    Route::get('sales/{sale}/reports/download', [SalesReport::class, 'download'])->name('sales.reports.download');

    Route::get('providers', ProvidersIndex::class)->name('providers.index');
    Route::get('productdeliveries', ProductDeliveriesIndex::class)->name('productdeliveries.index');
    Route::get('productdeliveries/create', ProductDeliveriesCreate::class)->name('productdeliveries.create');
    Route::get('productdeliveries/{delivery}/reports/pdf', [ProductDeliveriesReport::class, 'pdf'])->name('productdeliveries.reports.pdf');
    Route::get('productdeliveries/{delivery}/reports/download', [ProductDeliveriesReport::class, 'download'])->name('productdeliveries.reports.download');

    Route::middleware('role:Administrador')->group(function () {
        Route::get('categoriesandmeasures', CategoriesAndMeasuresIndex::class)->name('categoriesandmeasures.index');
        Route::get('paymentmethods', PaymentMethodsIndex::class)->name('paymentmethods.index');
        Route::get('clienttypes', ClientTypesIndex::class)->name('clienttypes.index');
        Route::get('persontypes', PersonTypesIndex::class)->name('persontypes.index');

        Route::get('products/create', ProductsCreate::class)->name('products.create');
        Route::get('products/{product}/update', ProductsUpdate::class)->name('products.update');

        Route::get('sales/{sale}/update', SalesUpdate::class)->name('sales.update');

        Route::get('providers/create', ProvidersCreate::class)->name('providers.create');
        Route::get('providers/{provider}/update', ProvidersUpdate::class)->name('providers.update');

        // Route deshabilitada: edición de entradas de inventario
        // Route::get('productdeliveries/{delivery}/update', ProductDeliveriesUpdate::class)->name('productdeliveries.update');

        Route::get('categories/create', CategoriesCreate::class)->name('categories.create');
        Route::get('categories/{category}/update', CategoriesUpdate::class)->name('categories.update');
        Route::get('measures/create', MeasuresCreate::class)->name('measures.create');
        Route::get('measures/{measure}/update', MeasuresUpdate::class)->name('measures.update');

        Route::get('paymentmethods/create', PaymentMethodsCreate::class)->name('paymentmethods.create');
        Route::get('paymentmethods/{payment}/update', PaymentMethodsUpdate::class)->name('paymentmethods.update');

        Route::get('clienttypes/create', ClientTypesCreate::class)->name('clienttypes.create');
        Route::get('clienttypes/{clienttype}/update', ClientTypesUpdate::class)->name('clienttypes.update');

        Route::get('persontypes/create', PersonTypesCreate::class)->name('persontypes.create');
        Route::get('persontypes/{persontype}/update', PersonTypesUpdate::class)->name('persontypes.update');

        Route::get('users', UsersIndex::class)->name('users.index');
        Route::get('users/create', UsersCreate::class)->name('users.create');
        Route::get('users/{user}/update', UsersUpdate::class)->name('users.update');

        Route::get('reports', ReportsIndex::class)->name('reports.index');
        /* Route::get('reports/{report}/reports/pdf', [ReportsReports::class, 'pdf'])->name('reports.reports.pdf');
        Route::get('reports/{report}/reports/download', [ReportsReports::class, 'download'])->name('reports.reports.download'); */
    });
});
