import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
const CreatePackage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePackage.url(options),
    method: 'get',
})

CreatePackage.definition = {
    methods: ["get","head"],
    url: '/admin/packages/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
CreatePackage.url = (options?: RouteQueryOptions) => {
    return CreatePackage.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
CreatePackage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePackage.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
CreatePackage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreatePackage.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
const CreatePackageForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreatePackage.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
CreatePackageForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreatePackage.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Packages\Pages\CreatePackage::__invoke
* @see app/Filament/Resources/Packages/Pages/CreatePackage.php:7
* @route '/admin/packages/create'
*/
CreatePackageForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreatePackage.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreatePackage.form = CreatePackageForm

export default CreatePackage