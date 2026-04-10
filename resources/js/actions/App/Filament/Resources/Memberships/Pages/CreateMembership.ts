import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Memberships\Pages\CreateMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/CreateMembership.php:7
* @route '/admin/memberships/create'
*/
const CreateMembership = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMembership.url(options),
    method: 'get',
})

CreateMembership.definition = {
    methods: ["get","head"],
    url: '/admin/memberships/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Memberships\Pages\CreateMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/CreateMembership.php:7
* @route '/admin/memberships/create'
*/
CreateMembership.url = (options?: RouteQueryOptions) => {
    return CreateMembership.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Memberships\Pages\CreateMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/CreateMembership.php:7
* @route '/admin/memberships/create'
*/
CreateMembership.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMembership.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\CreateMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/CreateMembership.php:7
* @route '/admin/memberships/create'
*/
CreateMembership.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateMembership.url(options),
    method: 'head',
})

export default CreateMembership