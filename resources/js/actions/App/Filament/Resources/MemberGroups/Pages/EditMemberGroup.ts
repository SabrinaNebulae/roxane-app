import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
const EditMemberGroup = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMemberGroup.url(args, options),
    method: 'get',
})

EditMemberGroup.definition = {
    methods: ["get","head"],
    url: '/admin/member-groups/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
EditMemberGroup.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditMemberGroup.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
EditMemberGroup.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMemberGroup.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
EditMemberGroup.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditMemberGroup.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
const EditMemberGroupForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMemberGroup.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
EditMemberGroupForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMemberGroup.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\MemberGroups\Pages\EditMemberGroup::__invoke
* @see app/Filament/Resources/MemberGroups/Pages/EditMemberGroup.php:7
* @route '/admin/member-groups/{record}/edit'
*/
EditMemberGroupForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMemberGroup.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditMemberGroup.form = EditMemberGroupForm

export default EditMemberGroup