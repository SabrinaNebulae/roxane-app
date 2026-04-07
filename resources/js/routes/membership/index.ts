import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
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

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::store
* @see app/Http/Controllers/Forms/MembershipFormController.php:42
* @route '/membership'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Forms\MembershipFormController::store
* @see app/Http/Controllers/Forms/MembershipFormController.php:42
* @route '/membership'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const membership = {
    store: Object.assign(store, store),
}

export default membership