import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Forms\ContactFormController::create
* @see app/Http/Controllers/Forms/ContactFormController.php:16
* @route '/contact'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/contact',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Forms\ContactFormController::create
* @see app/Http/Controllers/Forms/ContactFormController.php:16
* @route '/contact'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Forms\ContactFormController::create
* @see app/Http/Controllers/Forms/ContactFormController.php:16
* @route '/contact'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Forms\ContactFormController::create
* @see app/Http/Controllers/Forms/ContactFormController.php:16
* @route '/contact'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Forms\ContactFormController::store
* @see app/Http/Controllers/Forms/ContactFormController.php:26
* @route '/contact'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/contact',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Forms\ContactFormController::store
* @see app/Http/Controllers/Forms/ContactFormController.php:26
* @route '/contact'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Forms\ContactFormController::store
* @see app/Http/Controllers/Forms/ContactFormController.php:26
* @route '/contact'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const ContactFormController = { create, store }

export default ContactFormController