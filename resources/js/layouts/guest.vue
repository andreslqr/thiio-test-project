<template>
    <div class="w-100 d-flex px-4 py-4">
        <v-spacer></v-spacer>
        <v-btn icon @click.stop="toggleTheme">
            <v-icon v-if="! dark" icon="mdi-white-balance-sunny"></v-icon>
            <v-icon v-if="dark" icon="mdi-weather-night"></v-icon>
        </v-btn>
    </div>
    <v-layout>
        <v-container>
            <router-view></router-view>
        </v-container>
    </v-layout>
</template>

<script setup>

import { computed } from 'vue'
import { useTheme } from 'vuetify'

const theme = useTheme()

const dark = computed(() => theme.global.current.value.dark)

const toggleTheme = () => theme.global.name.value = theme.global.current.value.dark ? 'lightTheme' : 'darkTheme'
</script>