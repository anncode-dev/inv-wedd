<?php

namespace App\Nova\Metrics;

use App\Models\ContactUs;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Carbon\Carbon;

class ContactUsStatus extends Partition
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

        return $this->count($request, ContactUs::whereBetween('created_at', [$startDate, $endDate]), 'status')
            ->label(function ($value) {
                return $value == 0 ? 'Waiting' : 'Done';
            });
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Contact Us Status (Last 30 Days)');
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
        return 'contact-us-status-partition';
    }
}