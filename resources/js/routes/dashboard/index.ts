import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\DashboardController::serviceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
export const serviceActivation = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: serviceActivation.url(options),
    method: 'post',
})

serviceActivation.definition = {
    methods: ["post"],
    url: '/dashboard/service-activation',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DashboardController::serviceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
serviceActivation.url = (options?: RouteQueryOptions) => {
    return serviceActivation.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DashboardController::serviceActivation
* @see app/Http/Controllers/DashboardController.php:30
* @route '/dashboard/service-activation'
*/
serviceActivation.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: serviceActivation.url(options),
    method: 'post',
})

const dashboard = {
    serviceActivation: Object.assign(serviceActivation, serviceActivation),
}

export default dashboard