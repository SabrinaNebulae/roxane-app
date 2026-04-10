import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
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

const contact = {
    store: Object.assign(store, store),
}

export default contact