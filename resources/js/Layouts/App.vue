<template>
    <div class="min-vh-100 d-flex flex-column justify-content-between">
        <header class="bg-success text-white py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Balance service</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/">Главная</a>
                        </li>
                        <template v-if="auth">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/history">История операций</a>
                            </li>
                            <li class="nav-item">
                                <button @click="logout" class="btn bg-danger text-white border-0">Выход</button>
                            </li>
                        </template>
                        <template v-else>
                            <li v-if="!auth" class="nav-item">
                                <a class="nav-link text-white" href="/login">Вход</a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="page mb-auto">
            <slot></slot>
        </main>
        <footer class="bg-dark text-white py-2">
            <div class="container text-center">
                <p class="mb-0"> 2024 Сервис управления балансом пользователей</p>
                <p class="small">Тестовое задание. Сделано с любовью</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const auth = computed(() => page.props.auth)

const logout = () => {
  router.post('/logout')
}

</script>

<style scoped>
header {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.nav-link{
    cursor:pointer
}
</style>
