import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Forms\MembershipFormController::create
* @see app/Http/Controllers/Forms/MembershipFormController.php:18
* @route '/membership'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/membership',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::create
* @see app/Http/Controllers/Forms/MembershipFormController.php:18
* @route '/membership'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::create
* @see app/Http/Controllers/Forms/MembershipFormController.php:18
* @route '/membership'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::create
* @see app/Http/Controllers/Forms/MembershipFormController.php:18
* @route '/membership'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::store
* @see app/Http/Controllers/Forms/MembershipFormController.php:42
* @route '/membership'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/membership',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::store
* @see app/Http/Controllers/Forms/MembershipFormController.php:42
* @route '/membership'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::store
* @see app/Http/Controllers/Forms/MembershipFormController.php:42
* @route '/membership'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const MembershipFormController = { create, store }

export default MembershipFormController