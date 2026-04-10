import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
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

export default EditMember