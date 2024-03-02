import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const navigationStore = defineStore('navigation', () => {
    const drawer = ref(true)
    const items = ref([])

    const toggleDrawer = () => drawer.value = !drawer.value

    const getDrawer = computed(() => drawer.value)
    const getItems = computed(() => items.value)

    const pushNavigation = (item) => items.value.push(item)

    return { drawer, items, toggleDrawer, getDrawer, getItems, pushNavigation }
})