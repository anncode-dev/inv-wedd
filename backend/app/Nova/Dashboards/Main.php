<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ContactUsStatus;
use App\Nova\Metrics\ContactUsTrend;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\TopVisitedNews;
use App\Nova\Metrics\TopVisitedPromos;
use App\Nova\Metrics\TopVisitedProducts;
use App\Nova\Metrics\TopUsedCreditCalculators;
use App\Nova\Metrics\VisitorsTrend;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new TopVisitedNews,
            new TopVisitedPromos,
            new TopVisitedProducts,
            new TopUsedCreditCalculators,
            new ContactUsStatus,
            new ContactUsTrend,
            new VisitorsTrend,
        ];
    }
}
