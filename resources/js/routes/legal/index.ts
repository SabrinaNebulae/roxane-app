import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see routes/web.php:20
* @route '/mentions-legales'
*/
export const mentions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentions.url(options),
    method: 'get',
})

mentions.definition = {
    methods: ["get","head"],
    url: '/mentions-legales',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:20
* @route '/mentions-legales'
*/
mentions.url = (options?: RouteQueryOptions) => {
    return mentions.definition.url + queryParams(options)
}

/**
* @see routes/web.php:20
* @route '/mentions-legales'
*/
mentions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentions.url(options),
    method: 'get',
})

/**
* @see routes/web.php:20
* @route '/mentions-legales'
*/
mentions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mentions.url(options),
    method: 'head',
})

/**
* @see routes/web.php:21
* @route '/conditions-generales'
*/
export const cgu = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cgu.url(options),
    method: 'get',
})

cgu.definition = {
    methods: ["get","head"],
    url: '/conditions-generales',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:21
* @route '/conditions-generales'
*/
cgu.url = (options?: RouteQueryOptions) => {
    return cgu.definition.url + queryParams(options)
}

/**
* @see routes/web.php:21
* @route '/conditions-generales'
*/
cgu.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cgu.url(options),
    method: 'get',
})

/**
* @see routes/web.php:21
* @route '/conditions-generales'
*/
cgu.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: cgu.url(options),
    method: 'head',
})

/**
* @see routes/web.php:22
* @route '/confidentialite'
*/
export const confidentialite = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confidentialite.url(options),
    method: 'get',
})

confidentialite.definition = {
    methods: ["get","head"],
    url: '/confidentialite',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:22
* @route '/confidentialite'
*/
confidentialite.url = (options?: RouteQueryOptions) => {
    return confidentialite.definition.url + queryParams(options)
}

/**
* @see routes/web.php:22
* @route '/confidentialite'
*/
confidentialite.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confidentialite.url(options),
    method: 'get',
})

/**
* @see routes/web.php:22
* @route '/confidentialite'
*/
confidentialite.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: confidentialite.url(options),
    method: 'head',
})

const legal = {
    mentions: Object.assign(mentions, mentions),
    cgu: Object.assign(cgu, cgu),
    confidentialite: Object.assign(confidentialite, confidentialite),
}

export default legal