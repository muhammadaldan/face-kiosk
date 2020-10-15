import Home from "../views/Home.vue";
import Employee from "../views/Employee.vue";
import Department from "../views/Department.vue";
import Setting from "../views/Setting.vue";
import SettingUser from "../views/SettingUser.vue";

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
    }
];

export default routes;
