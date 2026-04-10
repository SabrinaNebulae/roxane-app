import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
export const synchronisations = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: synchronisations.url(options),
    method: 'get',
})

synchronisations.definition = {
    methods: ["get","head"],
    url: '/admin/synchronisations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
synchronisations.url = (options?: RouteQueryOptions) => {
    return synchronisations.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
synchronisations.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: synchronisations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
synchronisations.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: synchronisations.url(options),
    method: 'head',
})

const pages = {
    dashboard: Object.assign(dashboard, dashboard),
    synchronisations: Object.assign(synchronisations, synchronisations),
}

export default pages