import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
const CreateMember = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMember.url(options),
    method: 'get',
})

CreateMember.definition = {
    methods: ["get","head"],
    url: '/admin/members/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
CreateMember.url = (options?: RouteQueryOptions) => {
    return CreateMember.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
CreateMember.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateMember.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
CreateMember.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateMember.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
const CreateMemberForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMember.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
CreateMemberForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMember.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\CreateMember::__invoke
* @see app/Filament/Resources/Members/Pages/CreateMember.php:7
* @route '/admin/members/create'
*/
CreateMemberForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateMember.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateMember.form = CreateMemberForm

export default CreateMember