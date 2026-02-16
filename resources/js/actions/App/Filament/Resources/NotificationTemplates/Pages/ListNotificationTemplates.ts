import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
const ListNotificationTemplates = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListNotificationTemplates.url(options),
    method: 'get',
})

ListNotificationTemplates.definition = {
    methods: ["get","head"],
    url: '/admin/notification-templates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
ListNotificationTemplates.url = (options?: RouteQueryOptions) => {
    return ListNotificationTemplates.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
ListNotificationTemplates.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListNotificationTemplates.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
ListNotificationTemplates.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListNotificationTemplates.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
const ListNotificationTemplatesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNotificationTemplates.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
ListNotificationTemplatesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNotificationTemplates.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\ListNotificationTemplates::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/ListNotificationTemplates.php:7
* @route '/admin/notification-templates'
*/
ListNotificationTemplatesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNotificationTemplates.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListNotificationTemplates.form = ListNotificationTemplatesForm

export default ListNotificationTemplates