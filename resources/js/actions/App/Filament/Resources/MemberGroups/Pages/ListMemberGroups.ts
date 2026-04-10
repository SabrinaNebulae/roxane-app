import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\MemberGroups\Pages\ListMemberGroups::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/ListMemberGroups.php:7
* @route '/admin/member-groups'
*/
const ListMemberGroups = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMemberGroups.url(options),
    method: 'get',
})

ListMemberGroups.definition = {
    methods: ["get","head"],
    url: '/admin/member-groups',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\MemberGroups\Pages\ListMemberGroups::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/ListMemberGroups.php:7
* @route '/admin/member-groups'
*/
ListMemberGroups.url = (options?: RouteQueryOptions) => {
    return ListMemberGroups.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\MemberGroups\Pages\ListMemberGroups::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/ListMemberGroups.php:7
* @route '/admin/member-groups'
*/
ListMemberGroups.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMemberGroups.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\ListMemberGroups::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/ListMemberGroups.php:7
* @route '/admin/member-groups'
*/
ListMemberGroups.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMemberGroups.url(options),
    method: 'head',
})

export default ListMemberGroups