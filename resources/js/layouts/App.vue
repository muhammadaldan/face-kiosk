<template>
    <v-app style="background: #f5f5f5">
        <v-navigation-drawer
            v-model="drawer"
            class="white shadow-xl"
            fixed
            app
            floating
        >
            <v-list nav dense>
                <v-list-item-group color="">
                    <v-list-item class="mb-5 text-center">
                        <img
                            :src="
                                setting.logo
                                    ? setting.logo
                                    : '/assets/images/logo.png'
                            "
                            width="150px"
                            alt=""
                            srcset=""
                            class="ml-4"
                        />
                    </v-list-item>
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        :to="item.to"
                        active-class="primary--text"
                        router
                        exact
                    >
                        <v-list-item-action>
                            <v-icon class="">{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="" v-text="item.title" />
                        </v-list-item-content>
                    </v-list-item>
                    <template v-if="user.id === 1">
                        <v-list-item
                            v-for="(item, i) in itemsHide"
                            :key="i + 'a'"
                            :to="item.to"
                            active-class="primary--text"
                            router
                            exact
                        >
                            <v-list-item-action>
                                <v-icon class="">{{ item.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title
                                    class=""
                                    v-text="item.title"
                                />
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar fixed app :class="`white shadow-sm`">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <p class="mb-0 font-weight-bold">{{ setting.name }}</p>
            <v-spacer></v-spacer>
            <!-- <v-menu top :offset-x="true">
        <template v-slot:activator="{ on, attrs }">
          <v-badge color="orange" class="mr-5 mt-2" content="6">
            <v-btn class="text-none" small icon v-bind="attrs" v-on="on" text>
              <v-icon width="0">mdi-bell</v-icon>
            </v-btn>
          </v-badge>
        </template>

        <v-list>
          <v-list-item v-for="(item, index) in dropdowns" :key="index">
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu> -->
            <v-avatar size="40px" class="mt-2">
                <v-avatar color="primary">
                    <span class="white--text uppercase">{{
                        user.name[0] + user.name[1]
                    }}</span>
                </v-avatar>
            </v-avatar>
            <v-menu top :offset-x="true">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn class="text-none mt-2" v-bind="attrs" text v-on="on">
                        {{ user.name }}
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item to="/setting-user">
                        <v-list-item-title>Setting</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="logout">
                        <v-list-item-title @click="logout"
                            >Logout</v-list-item-title
                        >
                        <form
                            id="logout-form"
                            action="/logout"
                            method="POST"
                            class="d-none"
                        >
                            <input type="hidden" name="_token" :value="csrf" />
                        </form>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <v-main>
            <v-container class="px-8 pb-8">
                <router-view></router-view>
            </v-container>
            <v-footer class="text-center d-block white" absolute>
                <span
                    >Copyright &copy;
                    <a href="http://makerindo.com/" target="_blank"
                        >MakerIndo</a
                    >
                    {{ new Date().getFullYear() }}
                </span>
            </v-footer>
        </v-main>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            user: user,
            setting: setting,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            items: [
                {
                    icon: "mdi-view-dashboard-outline",
                    title: "Dashboard",
                    hide: false,
                    to: "/"
                },
                {
                    icon: "mdi-office-building",
                    title: "Department",
                    hide: false,
                    to: "/department"
                },
                {
                    icon: "mdi-account-tie",
                    title: "Employee",
                    hide: false,
                    to: "/employee"
                },
                {
                    icon: "mdi-file",
                    title: "Report",
                    hide: false,
                    to: "/report"
                },
                {
                    icon: "mdi-cogs",
                    title: "Setting",
                    hide: false,
                    to: "/setting"
                }
            ],
            itemsHide: [
                {
                    icon: "mdi-account-multiple-plus",
                    title: "User",
                    hide: true,
                    to: "/user"
                }
            ],

            dropdowns: [
                { title: "Click Me" },
                { title: "Click Me" },
                { title: "Click Me" },
                { title: "Logout" }
            ]
        };
    },
    computed: {
        appBar() {
            switch (this.$vuetify.breakpoint.name) {
                case "xs":
                    return true;
                case "sm":
                    return false;
                case "md":
                    return false;
                case "lg":
                    return false;
                case "xl":
                    return false;
            }
        }
    },
    methods: {
        async logout() {
            document.getElementById("logout-form").submit();
        }
    },
    mounted() {}
};
</script>
