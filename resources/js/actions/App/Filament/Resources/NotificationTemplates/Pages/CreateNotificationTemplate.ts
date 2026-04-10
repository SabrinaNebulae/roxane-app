import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
const CreateNotificationTemplate = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateNotificationTemplate.url(options),
    method: 'get',
})

CreateNotificationTemplate.definition = {
    methods: ["get","head"],
    url: '/admin/notification-templates/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
CreateNotificationTemplate.url = (options?: RouteQueryOptions) => {
    return CreateNotificationTemplate.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
CreateNotificationTemplate.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateNotificationTemplate.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
CreateNotificationTemplate.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateNotificationTemplate.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
const CreateNotificationTemplateForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateNotificationTemplate.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
CreateNotificationTemplateForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateNotificationTemplate.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\CreateNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/CreateNotificationTemplate.php:7
* @route '/admin/notification-templates/create'
*/
CreateNotificationTemplateForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateNotificationTemplate.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateNotificationTemplate.form = CreateNotificationTemplateForm

export default CreateNotificationTemplate