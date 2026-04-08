import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DashboardController::index
* @see app/Http/Controllers/DashboardController.php:15
* @route '/dashboard'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\DashboardController::requestServiceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
export const requestServiceActivation = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: requestServiceActivation.url(options),
    method: 'post',
})

requestServiceActivation.definition = {
    methods: ["post"],
    url: '/dashboard/service-activation',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DashboardController::requestServiceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
requestServiceActivation.url = (options?: RouteQueryOptions) => {
    return requestServiceActivation.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DashboardController::requestServiceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
requestServiceActivation.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: requestServiceActivation.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DashboardController::requestServiceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
const requestServiceActivationForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: requestServiceActivation.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DashboardController::requestServiceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
requestServiceActivationForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: requestServiceActivation.url(options),
    method: 'post',
})

requestServiceActivation.form = requestServiceActivationForm

const DashboardController = { index, requestServiceActivation }

export default DashboardController