import { defineStore } from 'pinia'
import { ref } from 'vue'

export const authStore = defineStore('auth', () => {
    const user = ref(null)

    const email = ref(null)
    const name = ref(null)
    const password = ref(null)
    const passwordConfirmation = ref(null)

    const login = () => {

    }

    return { user, name, email, password, passwordConfirmation, login }
})