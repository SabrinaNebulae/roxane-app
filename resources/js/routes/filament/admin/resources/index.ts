import memberGroups from './member-groups'
import members from './members'
import memberships from './memberships'
import notificationTemplates from './notification-templates'
import packages from './packages'
import services from './services'
import users from './users'
import shield from './shield'

const resources = {
    memberGroups: Object.assign(memberGroups, memberGroups),
    members: Object.assign(members, members),
    memberships: Object.assign(memberships, memberships),
    notificationTemplates: Object.assign(notificationTemplates, notificationTemplates),
    packages: Object.assign(packages, packages),
    services: Object.assign(services, services),
    users: Object.assign(users, users),
    shield: Object.assign(shield, shield),
}

export default resources