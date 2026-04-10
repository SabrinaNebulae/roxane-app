import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\EditNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/EditNotificationTemplate.php:7
* @route '/admin/notification-templates/{record}/edit'
*/
const EditNotificationTemplate = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditNotificationTemplate.url(args, options),
    method: 'get',
})

EditNotificationTemplate.definition = {
    methods: ["get","head"],
    url: '/admin/notification-templates/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\EditNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/EditNotificationTemplate.php:7
* @route '/admin/notification-templates/{record}/edit'
*/
EditNotificationTemplate.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return EditNotificationTemplate.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\EditNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/EditNotificationTemplate.php:7
* @route '/admin/notification-templates/{record}/edit'
*/
EditNotificationTemplate.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditNotificationTemplate.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NotificationTemplates\Pages\EditNotificationTemplate::__invoke
* @see app/Filament/Resources/NotificationTemplates/Pages/EditNotificationTemplate.php:7
* @route '/admin/notification-templates/{record}/edit'
*/
EditNotificationTemplate.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditNotificationTemplate.url(args, options),
    method: 'head',
})

export default EditNotificationTemplate