import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
const ListMemberships = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMemberships.url(options),
    method: 'get',
})

ListMemberships.definition = {
    methods: ["get","head"],
    url: '/admin/memberships',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
ListMemberships.url = (options?: RouteQueryOptions) => {
    return ListMemberships.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
ListMemberships.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMemberships.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
ListMemberships.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMemberships.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
const ListMembershipsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListMemberships.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
ListMembershipsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListMemberships.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\ListMemberships::__invoke
* @see app/Filament/Resources/Memberships/Pages/ListMemberships.php:7
* @route '/admin/memberships'
*/
ListMembershipsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListMemberships.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListMemberships.form = ListMembershipsForm

export default ListMemberships