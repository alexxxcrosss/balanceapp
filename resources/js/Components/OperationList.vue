<template>
    <ul v-if="operations && operations.length" class="list-group">
        <li v-for="operation in operations" :key="operation.id"
            class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <div>{{ operation.description }}</div>
                <small class="text-muted">{{ formatDate(operation.created_at) }}</small>
            </div>
            <span v-if="operation.type=='increase'" class="badge bg-success rounded-pill">+{{ formatCurrency(operation.amount) }}</span>
            <span v-if="operation.type=='decrease'" class="badge bg-danger rounded-pill">-{{ formatCurrency(operation.amount) }}</span>
        </li>
    </ul>
    <div v-else class="alert alert-info">Нет операций</div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { formatCurrency, formatDate } from '@/utils/formatters';

defineProps({
    operations: Array,
});

</script>

<style scoped>
.card {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.pagination .page-item.disabled .page-link {
    pointer-events: none;
}
</style>