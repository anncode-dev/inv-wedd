<?php

namespace App\Nova;

use App\Nova\Filters\NewsFilter;
//use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Http\Requests\NovaRequest;

class Csr extends Resource
{   
    public static function label() {
        return 'CSR';
    }

    
    public static function indexQuery(NovaRequest $request, $query)
    {   
        // Hapus semua pengurutan default
        $query->getQuery()->orders = null;

        return $query->where('type', 4) // Jasa Layanan                    
                    ->orderByRaw('COALESCE(publish_date, created_at) DESC');
    }

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\News>
     */
    public static $model = \App\Models\Csr::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            //ID::make()->sortable(),
            // BelongsTo yang bisa digunakan admin untuk memilih typeWebsite
            BelongsTo::make('Website', 'typeWebsite', typeWebsite::class)
                ->canSee(fn ($request) => $request->user()->isSuperAdmin())  // Hanya admin yang bisa melihat
                ->readonly(fn ($request) => !$request->user()->isSuperAdmin())  // Admin bisa memilih, user tidak bisa mengedit
                ->default(function ($request) {
                    // Untuk user, set default value berdasarkan type_website_id yang sudah ada
                    if (!$request->user()->isSuperAdmin()) {
                        return $request->user()->type_website_id;
                    }
                    return null; // Admin tidak perlu default
                }),
            Hidden::make('created_by')->default(auth()->id()),
            Hidden::make('Type')->default(4), //services
            Text::make('Title')
                ->sortable()                
                ->rules('required', 'max:255')
                ->translatable(),

            Image::make('Image')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('news')->prunable(),
            
            Markdown::make('Short Description')->rules('max:255')
                ->help('Max character 255')               
                ->translatable(),   

            CkEditor::make('Content', 'description')
                ->rules('required')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),

            Boolean::make('Is active')
            ->sortable()                
            ->default(false),   
            
            Date::make('Publish date')->sortable()                            
            ->displayUsing(function ($value) {
                return $value ? $value->format('d M Y') : null;
            })->withMeta([
                'value' => Carbon::now()->toDateString(), // default hari ini
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [new \App\Nova\Filters\WebsiteFilter];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public function authorizedToUpdate(Request $request): bool
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return true;
        }

        $isAuthorized = $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;

        if (!$isAuthorized) {
            abort(403, 'Forbidden');
        }

        return $isAuthorized;
    }

    public function authorizedToView(Request $request): bool
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return true;
        }

        $isAuthorized = $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;

        if (!$isAuthorized) {
            abort(403, 'Forbidden');
        }

        return $isAuthorized;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        $user = $request->user();

        // Admin bisa mengedit semua berita
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya bisa mengedit jika berita dari unitnya sendiri
        return $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;
    }
}
