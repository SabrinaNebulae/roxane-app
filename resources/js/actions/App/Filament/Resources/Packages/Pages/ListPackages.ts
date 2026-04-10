import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Packages\Pages\ListPackages::__invoke
* @see app/Filament/Resources/Packages/Pages/ListPackages.php:7
* @route '/admin/packages'
*/
const ListPackages = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPackages.url(options),
    method: 'get',
})

ListPackages.definition = {
    methods: ["get","head"],
    url: '/admin/packages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Packages\Pages\ListPackages::__invoke
* @see app/Filament/Resources/Packages/Pages/ListPackages.php:7
* @route '/admin/packages'
*/
ListPackages.url = (options?: RouteQueryOptions) => {
    return ListPackages.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Packages\Pages\ListPackages::__invoke
* @see app/Filament/Resources/Packages/Pages/ListPackages.php:7
* @route '/admin/packages'
*/
ListPackages.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPackages.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Packages\Pages\ListPackages::__invoke
* @see app/Filament/Resources/Packages/Pages/ListPackages.php:7
* @route '/admin/packages'
*/
ListPackages.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListPackages.url(options),
    method: 'head',
})

export default ListPackages