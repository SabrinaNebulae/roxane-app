import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
const Synchronisations = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Synchronisations.url(options),
    method: 'get',
})

Synchronisations.definition = {
    methods: ["get","head"],
    url: '/admin/synchronisations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
Synchronisations.url = (options?: RouteQueryOptions) => {
    return Synchronisations.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
Synchronisations.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Synchronisations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
Synchronisations.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Synchronisations.url(options),
    method: 'head',
})

export default Synchronisations