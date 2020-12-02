<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'System';

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        if ($request->viaResource) {
            return "/resources/{$request->viaResource}/{$request->viaResourceId}";
        }

        return parent::redirectAfterCreate($request, $resource);
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        if ($request->viaResource) {
            return "/resources/{$request->viaResource}/{$request->viaResourceId}";
        }

        return parent::redirectAfterUpdate($request, $resource);
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param \Laravel\Scout\Builder $query
     *
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }
}
