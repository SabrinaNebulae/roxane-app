import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Services\Pages\ListServices::__invoke
* @see app/Filament/Resources/Services/Pages/ListServices.php:7
* @route '/admin/services'
*/
const ListServices = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListServices.url(options),
    method: 'get',
})

ListServices.definition = {
    methods: ["get","head"],
    url: '/admin/services',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Services\Pages\ListServices::__invoke
* @see app/Filament/Resources/Services/Pages/ListServices.php:7
* @route '/admin/services'
*/
ListServices.url = (options?: RouteQueryOptions) => {
    return ListServices.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Services\Pages\ListServices::__invoke
* @see app/Filament/Resources/Services/Pages/ListServices.php:7
* @route '/admin/services'
*/
ListServices.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListServices.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Services\Pages\ListServices::__invoke
* @see app/Filament/Resources/Services/Pages/ListServices.php:7
* @route '/admin/services'
*/
ListServices.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListServices.url(options),
    method: 'head',
})

export default ListServices