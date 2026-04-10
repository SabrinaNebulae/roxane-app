import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Packages\Pages\EditPackage::__invoke
* @see app/Filament/Resources/Packages/Pages/EditPackage.php:7
* @route '/admin/packages/{record}/edit'
*/
const EditPackage = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPackage.url(args, options),
    method: 'get',
})

EditPackage.definition = {
    methods: ["get","head"],
    url: '/admin/packages/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Packages\Pages\EditPackage::__invoke
* @see app/Filament/Resources/Packages/Pages/EditPackage.php:7
* @route '/admin/packages/{record}/edit'
*/
EditPackage.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditPackage.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Packages\Pages\EditPackage::__invoke
* @see app/Filament/Resources/Packages/Pages/EditPackage.php:7
* @route '/admin/packages/{record}/edit'
*/
EditPackage.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPackage.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Packages\Pages\EditPackage::__invoke
* @see app/Filament/Resources/Packages/Pages/EditPackage.php:7
* @route '/admin/packages/{record}/edit'
*/
EditPackage.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditPackage.url(args, options),
    method: 'head',
})

export default EditPackage