import Home from "../views/Home.vue";
import Employee from "../views/Employee.vue";
import Department from "../views/Department.vue";
import Setting from "../views/Setting.vue";
import SettingUser from "../views/SettingUser.vue";
import Report from "../views/Report.vue";
import User from "../views/User.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home
    },
    {
        path: "/employee",
        name: "employee",
        component: Employee
    },
    {
        path: "/department",
        name: "department",
        component: Department
    },
    {
        path: "/setting",
        name: "setting",
        component: Setting
    },
    {
        path: "/setting-user",
        name: "settingUser",
        component: SettingUser
    },
    {
        path: "/report",
        name: "report",
        component: Report
    },
    {
        path: "/user",
        name: "user",
        component: User
    }
];

export default routes;
