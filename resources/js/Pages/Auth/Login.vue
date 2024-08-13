<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4">
                    <h1 class="card-title text-center mb-4">Вход</h1>
                    <form @submit.prevent="submitForm">
                        <div v-if="errors.login" class="alert alert-danger mt-3 p-4 text-bold">
                            {{ errors.login }}
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Электронная почта</label>
                            <input v-model="form.email" type="email" id="email" class="form-control" required />
                            <div v-if="errors.email" class="text-danger mt-1">{{ errors.email }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input v-model="form.password" type="password" id="password" class="form-control"
                                required />
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Войти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const errors = ref({});

const submitForm = () => {
    form.post('/login', {
        onError: (e) => {
            errors.value = e;
        },
        // onSuccess: () => {

        // },
    });
};
</script>