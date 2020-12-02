<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class AuthenticationLog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Yadahan\AuthenticationLog\AuthenticationLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'ip_address', 'login_at', 'logout_at', 'user_agent',
    ];

    /**
     * Custom Label.
     *
     * @var string
     */
    public static $label = 'Authentication';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->authenticatable->name;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Name', function () {
                return $this->authenticatable->name;
            }),

            Text::make('E-mail', function () {
                return $this->authenticatable->email;
            }),

            Text::make('Login At', function () {
                return optional($this->login_at)->format('l, d-m-Y H:i:s');
            }),

            Text::make('Logout At', function () {
                return optional($this->logout_at)->format('l, d-m-Y H:i:s');
            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new \App\Nova\Metrics\Trend\LoginTrend(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
