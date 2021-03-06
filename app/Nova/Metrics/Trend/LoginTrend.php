<?php

namespace App\Nova\Metrics\Trend;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;
use Yadahan\AuthenticationLog\AuthenticationLog as Model;

class LoginTrend extends Trend
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, Model::class, 'login_at');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int
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
        return 'trend-login-trend';
    }
}
