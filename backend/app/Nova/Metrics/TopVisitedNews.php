<?php

namespace App\Nova\Metrics;

use App\Models\News;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Nova;
use Carbon\Carbon;

class TopVisitedNews extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        // Query for the last 30 days using COALESCE to prioritize publish_date
        $news = News::whereBetween(\DB::raw('COALESCE(publish_date, created_at)'), [$startDate, $endDate])
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get(['count', 'title']);

        $result = $news->mapWithKeys(function ($item) {
            $title = json_decode($item->title, true)['id'] ?? $item->title;
            $shortTitle = Str::limit($title, 25); // Batasi panjang karakter judul menjadi 25 karakter
            return [$shortTitle => $item->count];
        });

        return $this->result($result->toArray());
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Top 10 Visited News, etc (Last 30 Days)');
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'top-visited-news';
    }
}