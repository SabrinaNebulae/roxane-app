import Auth from './Auth'
import DashboardController from './DashboardController'
import Settings from './Settings'
import Forms from './Forms'

const Controllers = {
    Auth: Object.assign(Auth, Auth),
    DashboardController: Object.assign(DashboardController, DashboardController),
    Settings: Object.assign(Settings, Settings),
    Forms: Object.assign(Forms, Forms),
}

export default Controllers