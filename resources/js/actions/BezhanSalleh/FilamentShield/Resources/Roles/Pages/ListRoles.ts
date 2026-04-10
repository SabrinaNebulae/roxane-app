import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \BezhanSalleh\FilamentShield\Resources\Roles\Pages\ListRoles::__invoke
* @see vendor/bezhansalleh/filament-shield/src/Resources/Roles/Pages/ListRoles.php:7
* @route '/admin/shield/roles'
*/
const ListRoles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListRoles.url(options),
    method: 'get',
})

ListRoles.definition = {
    methods: ["get","head"],
    url: '/admin/shield/roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \BezhanSalleh\FilamentShield\Resources\Roles\Pages\ListRoles::__invoke
* @see vendor/bezhansalleh/filament-shield/src/Resources/Roles/Pages/ListRoles.php:7
* @route '/admin/shield/roles'
*/
ListRoles.url = (options?: RouteQueryOptions) => {
    return ListRoles.definition.url + queryParams(options)
}

/**
* @see \BezhanSalleh\FilamentShield\Resources\Roles\Pages\ListRoles::__invoke
* @see vendor/bezhansalleh/filament-shield/src/Resources/Roles/Pages/ListRoles.php:7
* @route '/admin/shield/roles'
*/
ListRoles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListRoles.url(options),
    method: 'get',
})

/**
* @see \BezhanSalleh\FilamentShield\Resources\Roles\Pages\ListRoles::__invoke
* @see vendor/bezhansalleh/filament-shield/src/Resources/Roles/Pages/ListRoles.php:7
* @route '/admin/shield/roles'
*/
ListRoles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListRoles.url(options),
    method: 'head',
})

export default ListRoles