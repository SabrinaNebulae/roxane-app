import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
const CreateMemberGroup = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMemberGroup.url(options),
    method: 'get',
})

CreateMemberGroup.definition = {
    methods: ["get","head"],
    url: '/admin/member-groups/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
CreateMemberGroup.url = (options?: RouteQueryOptions) => {
    return CreateMemberGroup.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
CreateMemberGroup.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMemberGroup.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
CreateMemberGroup.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateMemberGroup.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
const CreateMemberGroupForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMemberGroup.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
CreateMemberGroupForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMemberGroup.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\CreateMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/CreateMemberGroup.php:7
* @route '/admin/member-groups/create'
*/
CreateMemberGroupForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMemberGroup.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateMemberGroup.form = CreateMemberGroupForm

export default CreateMemberGroup