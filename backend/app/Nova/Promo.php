<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Boolean;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Hidden;
use Illuminate\Support\Str;
use Mostafaznv\NovaCkEditor\CkEditor;
use App\Rules\NoHtmlTags;

class Promo extends Resource
{   
    public static function label() {
        return 'Promotions';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Promo>
     */
    public static $model = \App\Models\Promo::class;

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
            Hidden::make('created_by')->default(auth()->id()),
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
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255',new NoHtmlTags)
                ->translatable(),

            // Markdown::make('Short Description')
            //     ->help('Max character 255')               
            //     ->rules('max:255')
            //     ->translatable(),

            CkEditor::make('Short Description')
                //->rules('required')
                ->rules([
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        // Deteksi tag script
                        if (preg_match('/<script|javascript:/i', $value)) {
                            $fail('Script tags or JavaScript code are not allowed.');
                        }
                        
                        // Deteksi event attributes
                        if (preg_match('/on\w+\s*=/i', $value)) {
                            $fail('Event attributes are not allowed.');
                        }
                    }
                ])
                ->resolveUsing(fn ($value) => $value ?? '')
                ->hideFromIndex()
                ->translatable(),

            Image::make('Banner')
                ->help('Format Webp & Max file size 500kb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('promo')->prunable(), 

            Images::make('Promo Image', 'my_multi_collection') // second parameter is the media collection name
                ->help('Format Webp & Max file size 2mb'),
            
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
                $url = $base."/promo/detail/".Str::slug($this->title);
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
        return [new \App\Nova\Filters\WebsiteFilter,];
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
