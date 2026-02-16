import MemberGroups from './MemberGroups'
import Members from './Members'
import Memberships from './Memberships'
import NotificationTemplates from './NotificationTemplates'
import Packages from './Packages'
import Services from './Services'
import Users from './Users'

const Resources = {
    MemberGroups: Object.assign(MemberGroups, MemberGroups),
    Members: Object.assign(Members, Members),
    Memberships: Object.assign(Memberships, Memberships),
    NotificationTemplates: Object.assign(NotificationTemplates, NotificationTemplates),
    Packages: Object.assign(Packages, Packages),
    Services: Object.assign(Services, Services),
    Users: Object.assign(Users, Users),
}

export default Resources