import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
const EditMember = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMember.url(args, options),
    method: 'get',
})

EditMember.definition = {
    methods: ["get","head"],
    url: '/admin/members/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
EditMember.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return EditMember.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
EditMember.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMember.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
EditMember.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditMember.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
const EditMemberForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMember.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
EditMemberForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMember.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Members\Pages\EditMember::__invoke
* @see app/Filament/Resources/Members/Pages/EditMember.php:7
* @route '/admin/members/{record}/edit'
*/
EditMemberForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMember.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditMember.form = EditMemberForm

export default EditMember