import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
const SynchronisationsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Synchronisations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
SynchronisationsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Synchronisations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Synchronisations::__invoke
* @see app/Filament/Pages/Synchronisations.php:7
* @route '/admin/synchronisations'
*/
SynchronisationsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Synchronisations.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Synchronisations.form = SynchronisationsForm

export default Synchronisations