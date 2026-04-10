import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Services\Pages\CreateService::__invoke
* @see app/Filament/Resources/Services/Pages/CreateService.php:7
* @route '/admin/services/create'
*/
const CreateService = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateService.url(options),
    method: 'get',
})

CreateService.definition = {
    methods: ["get","head"],
    url: '/admin/services/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Services\Pages\CreateService::__invoke
* @see app/Filament/Resources/Services/Pages/CreateService.php:7
* @route '/admin/services/create'
*/
CreateService.url = (options?: RouteQueryOptions) => {
    return CreateService.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Services\Pages\CreateService::__invoke
* @see app/Filament/Resources/Services/Pages/CreateService.php:7
* @route '/admin/services/create'
*/
CreateService.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateService.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Services\Pages\CreateService::__invoke
* @see app/Filament/Resources/Services/Pages/CreateService.php:7
* @route '/admin/services/create'
*/
CreateService.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateService.url(options),
    method: 'head',
})

export default CreateService