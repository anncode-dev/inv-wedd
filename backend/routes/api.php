<?php

use App\Http\Controllers\Api\AkselController;
use App\Http\Controllers\Api\CarrierController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CreditCalculationController;
use App\Http\Controllers\Api\ExchangeRateController;
use App\Http\Controllers\Api\HeroBannerController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\InformationSyariahController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PolicyController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\VisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TrackVisitors;
use Illuminate\Support\Facades\Storage;


Route::get('/download/{folder}/{filename}', function ($folder, $filename) {
    $filePath = 'public/' . $folder . '/' . $filename;

    if (!Storage::exists($filePath)) {
        abort(404, 'File not found');
    }

    return Storage::download($filePath);
});


Route::get('/unique-visitors', [VisitorController::class, 'uniqueVisitors']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'public',
    'middleware' => [TrackVisitors::class],
], function () {    
    ##Homepage
    ##NEWS ["1" => "News", "2" => "Education", "3" => "SBDK", "4" => "Services", "5" => Awards]
    Route::get('/type-website', [HeroBannerController::class, 'typeWebsite']);
    Route::get('/hero-banner', [HeroBannerController::class, 'index']);
    Route::get('/promo', [PromoController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news-highlight', [NewsController::class, 'newsHighlight']);
    Route::get('/services', [NewsController::class, 'index'])->defaults('tag', 4); //Services
    Route::get('/search', [NewsController::class, 'search']);
    Route::get('/allsearch', [NewsController::class, 'allsearch']);
    Route::get('/education', [NewsController::class, 'education']); //2. Education
    Route::get('/sbdk', [NewsController::class, 'sbdk']); //3. SBDK
    Route::get('/credit-calculation', [CreditCalculationController::class, 'index']);
    Route::get('/table-simulate', [CreditCalculationController::class, 'show']);
    Route::get('/exchange-rate', [ExchangeRateController::class, 'index']);

    Route::get('/location', [HeroBannerController::class, 'location']);
    Route::get('/location-detail', [HeroBannerController::class, 'locationDetail']);
    Route::get('/search-location', [HeroBannerController::class, 'searchLocation']);

    ##Product
    Route::get('/product-category', [ProductCategoryController::class, 'index']);
    Route::get('/product-type', [ProductCategoryController::class, 'detail']);
    Route::get('/products', [ProductCategoryController::class, 'product']);
    
    ##Service
    Route::get('/service-category', [ProductCategoryController::class, 'index'])->defaults('tag', 1); //Services
    Route::get('/service-type', [ProductCategoryController::class, 'detail'])->defaults('tag', 1); //Services
    Route::get('/service', [ProductCategoryController::class, 'product'])->defaults('tag', 1); //Services
    Route::get('/new-service', [ProductCategoryController::class, 'service'])->defaults('tag', 1); //Services
    
    ##Contact us
    Route::post('/contact-us', [ContactController::class, 'store']);   
    Route::post('/verify-recaptcha', [ContactController::class, 'verifyRecaptcha']);
    
    Route::apiResource('aksels', AkselController::class);
    Route::apiResource('carriers', CarrierController::class);
});

Route::group([
    'prefix' => 'information',
], function () {    
    ##Conventional
    Route::get('/syariah/{year}/{month?}', [InformationSyariahController::class, 'showByDate']);
    
    Route::resource('/conventional', InformationController::class)->only(['index','show']);    
    Route::resource('/syariah', InformationSyariahController::class)->only(['index','show']);   
    Route::get('/category', [InformationSyariahController::class, 'category']);    
});

Route::group([
    'prefix' => 'profile',
], function () {    
    ##Conventional
    Route::get('/category', [ProfileController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::get('/about-us', [ProfileController::class, 'about']);
    Route::get('/about-us-detail', [ProfileController::class, 'aboutDetail']);
    Route::get('/about-us-byid', [ProfileController::class, 'aboutUsDetailById']);
    ##tata Kelola
    Route::get('/tata-kelola-category', [ProfileController::class, 'tatakelolaCategory']);
    Route::get('/tata-kelola-year', [ProfileController::class, 'tatakelolaYear']);
    Route::get('/tata-kelola', [ProfileController::class, 'tatakelola']);
    
    Route::get('/info-finance-category', [ProfileController::class, 'tatakelolaCategory'])->defaults('tag', 1);
    Route::get('/info-finance-type', [ProfileController::class, 'infoFinanceType'])->defaults('tag', 1);
    Route::get('/info-finance', [ProfileController::class, 'tatakelola'])->defaults('tag', 1);
    Route::get('/year-info-finance', [ProfileController::class, 'getYear'])->defaults('tag', 1);
    Route::get('/month-info-finance', [ProfileController::class, 'getMonth'])->defaults('tag', 1);
    Route::get('/quarter-info-finance', [ProfileController::class, 'getQuarter'])->defaults('tag', 1);
    Route::get('/caturwulan-info-finance', [ProfileController::class, 'getCaturwulan'])->defaults('tag', 1);

    ##Keberlanjutan    
    Route::get('/keberlanjutan', [ProfileController::class, 'tatakelola'])->defaults('tag', 2);

    ##Policy
    Route::get('/policy', [PolicyController::class, 'index']);
    Route::get('/policy-detail', [PolicyController::class, 'detail']);
    Route::get('/csr', [NewsController::class, 'index'])->defaults('tag', 4);
    Route::get('/awards', [NewsController::class, 'index'])->defaults('tag', 5);

});

Route::group([
    'prefix' => 'nova',
    'middleware' => 'nova',
], function () {    
    ##Product
    Route::get('type-website/{q}', function(Request $request, $category_id) {
        $pcategory = \App\Models\ProductCategory::query()
                    ->active() // scope
                    ->where(function ($query) use ($request) {
                        if($request->tag){
                            $query->where('type', '=', $request->tag);
                        }else{
                            $query->whereNull('type');
                        }
                    })
                    ->where('type_website_id', $category_id)
                    ->get()
                    ->map(fn($q) => ['value' => $q->id, 'display' => $q->title]);

        return $pcategory;
    });

    Route::get('product-category/{q}', function($q) {
        $qry = \App\Models\ProductType::where(['product_category_id'=>$q])
                    ->get()
                    ->map(fn($q) => ['value' => $q->id, 'display' => $q->title]);

        return $qry;
    });

});

