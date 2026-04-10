import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Services\Pages\EditService::__invoke
* @see app/Filament/Resources/Services/Pages/EditService.php:7
* @route '/admin/services/{record}/edit'
*/
const EditService = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditService.url(args, options),
    method: 'get',
})

EditService.definition = {
    methods: ["get","head"],
    url: '/admin/services/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Services\Pages\EditService::__invoke
* @see app/Filament/Resources/Services/Pages/EditService.php:7
* @route '/admin/services/{record}/edit'
*/
EditService.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditService.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Services\Pages\EditService::__invoke
* @see app/Filament/Resources/Services/Pages/EditService.php:7
* @route '/admin/services/{record}/edit'
*/
EditService.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditService.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Services\Pages\EditService::__invoke
* @see app/Filament/Resources/Services/Pages/EditService.php:7
* @route '/admin/services/{record}/edit'
*/
EditService.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditService.url(args, options),
    method: 'head',
})

export default EditService