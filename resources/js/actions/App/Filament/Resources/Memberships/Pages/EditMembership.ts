import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
const EditMembership = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMembership.url(args, options),
    method: 'get',
})

EditMembership.definition = {
    methods: ["get","head"],
    url: '/admin/memberships/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
EditMembership.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditMembership.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
EditMembership.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditMembership.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
EditMembership.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditMembership.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
const EditMembershipForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMembership.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
EditMembershipForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMembership.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Memberships\Pages\EditMembership::__invoke
* @see app/Filament/Resources/Memberships/Pages/EditMembership.php:7
* @route '/admin/memberships/{record}/edit'
*/
EditMembershipForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditMembership.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditMembership.form = EditMembershipForm

export default EditMembership