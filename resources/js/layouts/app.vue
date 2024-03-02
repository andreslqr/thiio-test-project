<template>
    <v-layout>
        <v-navigation-drawer v-model="navigation.getDrawer" permanent>
            <template v-slot:prepend>
                <v-list-item style="height: 64px;" class="bg-secondary">
                    <v-img cover class="w-50 mx-auto" src="https://storage.googleapis.com/thiio.thiiomedia.com/Page/4/thiio.png"></v-img>
                </v-list-item>
            </template>
                    

            <v-list>
                <v-list-item :active="item.route == route.path" link :to="item.route" :key="item.name" :prepend-icon="item.icon" :title="item.name" v-for="item in navigation.getItems"></v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main style="height: 400px">
            <v-app-bar :elevation="2" class="bg-secondary">
                <template v-slot:prepend>
                    <v-app-bar-nav-icon @click.stop="navigation.toggleDrawer"></v-app-bar-nav-icon>
                </template>
                <v-spacer></v-spacer>

                <v-btn icon @click.stop="toggleTheme">
                    <v-icon v-if="! dark" icon="mdi-white-balance-sunny"></v-icon>
                    <v-icon v-if="dark" icon="mdi-weather-night"></v-icon>
                </v-btn>

            </v-app-bar>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-layout>
</template>
<script setup>

import { navigationStore } from './../store/navigation'
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import { useTheme } from 'vuetify'

const route = useRoute()
const navigation = navigationStore()
const theme = useTheme()

const dark = computed(() => theme.global.current.value.dark)

const toggleTheme = () => theme.global.name.value = theme.global.current.value.dark ? 'lightTheme' : 'darkTheme'

</script>