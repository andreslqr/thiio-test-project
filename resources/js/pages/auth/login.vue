<template>
    <v-row no-gutters justify="center">
        <v-col cols="12" xs="10" sm="8" md="6" lg="4" class="d-flex flex-column justify-center align-center">
            <v-img width="250" class="mx-auto mb-8"
                src="https://storage.googleapis.com/thiio.thiiomedia.com/Page/4/thiio.png"></v-img>
            <v-sheet border="md" rounded="lg" elevation="4" class="pa-6 mx-auto w-100">
                <v-form fast-fail @submit.prevent="store.login">
                    <v-text-field v-model="store.email" name="email" label="Email"></v-text-field>
    
                    <v-text-field v-model="store.password" name="password" label="Password"
                        :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'"
                        @click:append-inner="toggleShowPassword">
                    </v-text-field>
    
                    <v-btn type="submit" color="primary" block class="mt-2">Sign in</v-btn>
    
                </v-form>
                <div class="mt-2">
                    <p class="text-body-2">Don't have an account? <router-link to="/register">Sign Up</router-link></p>
                </div>
            </v-sheet>
        </v-col>
    </v-row>

</template>

<script setup>
import { ref } from 'vue';
import { authStore } from './../../store/auth'

const store = authStore()

const showPassword = ref(false)

const toggleShowPassword = () => showPassword.value = !showPassword.value

</script>