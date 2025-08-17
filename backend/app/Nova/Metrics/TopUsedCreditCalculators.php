<?php

namespace App\Nova\Metrics;

use App\Models\CreditCalculatorVisit;
use App\Models\CreditCalculator;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Carbon\Carbon;

class TopUsedCreditCalculators extends Partition
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

        // Query for the last 30 days
        $visits = CreditCalculatorVisit::whereBetween('updated_at', [$startDate, $endDate])
                                       ->selectRaw('credit_calculator_id, COUNT(*) as count')
                                       ->groupBy('credit_calculator_id')
                                       ->orderBy('count', 'desc')
                                       ->take(10)
                                       ->get();

        $result = $visits->mapWithKeys(function ($item) {
            $calculator = CreditCalculator::find($item->credit_calculator_id);
            $header = $calculator ? $calculator->name : 'Unknown';
            $shortHeader = Str::limit($header, 25); // Batasi panjang karakter header menjadi 25 karakter
            return [$shortHeader => $item->count];
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
        return __('Top Used Credit Calculators (Last 30 Days)');
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
        return 'top-used-credit-calculators';
    }
}