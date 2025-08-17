<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Support\Str;

class Education extends Resource
{   
    // public static function label() {
    //     return 'Education';
    // }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Education>
     */
    public static $model = \App\Models\Education::class;

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

    public static function indexQuery(NovaRequest $request, $query)
    {   
        // Hapus semua pengurutan default
        $query->getQuery()->orders = null;

        return $query->where('type', 2) //Education               
                    ->orderByRaw('COALESCE(publish_date, created_at) DESC');
    }
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
            Hidden::make('Type')->default(2), //Education
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),

            Image::make('Image')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('feature')->prunable(),
            
            //Markdown::make('Short Description')->rules('max:255'),

            CkEditor::make('Content', 'description')
                ->rules('required')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),

            // NovaTinyMCE::make('Content','description')
            //     ->placeholder('Enter Feature Here')
            //     ->id('description')
            //     ->withMeta(['mediaLibrary' => true]),
            Boolean::make('Is active')->default(false)
                ->readonly(function ($request) {
                    return !$request->user()->isSuperAdmin() && !$request->user()->isSuperVisor(); // Jika bukan Admin or supervisor, field jadi readonly
                })->sortable(),
            
            Date::make('Publish date')->sortable()                            
                ->displayUsing(function ($value) {
                    return $value ? $value->format('d M Y') : null;
                })->withMeta([
                    'value' => Carbon::now()->toDateString(), // default hari ini
                ]), 
            
            Text::make('View in Frontend', function() {
                $base = $this->type_website_id == 1 ? config("app.convent_url") : config("app.syariah_url"); 
                $url = $base."/edukasi/detail/".Str::slug($this->title);
                return "<a href='{$url}' target='_blank' class='link-default'>Preview</a>";
            })->asHtml()->onlyOnDetail(),
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
