import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Members\Pages\ListMembers::__invoke
* @see app/Filament/Resources/Members/Pages/ListMembers.php:7
* @route '/admin/members'
*/
const ListMembers = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMembers.url(options),
    method: 'get',
})

ListMembers.definition = {
    methods: ["get","head"],
    url: '/admin/members',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Members\Pages\ListMembers::__invoke
* @see app/Filament/Resources/Members/Pages/ListMembers.php:7
* @route '/admin/members'
*/
ListMembers.url = (options?: RouteQueryOptions) => {
    return ListMembers.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Members\Pages\ListMembers::__invoke
* @see app/Filament/Resources/Members/Pages/ListMembers.php:7
* @route '/admin/members'
*/
ListMembers.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMembers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\ListMembers::__invoke
* @see app/Filament/Resources/Members/Pages/ListMembers.php:7
* @route '/admin/members'
*/
ListMembers.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMembers.url(options),
    method: 'head',
})

export default ListMembers