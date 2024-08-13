<template>
  <div class="container mt-5">
    <h1 class="card-title mb-5">Панель управления</h1>
    <div class="card mb-3">
      <div class="card-header">
        <h3 class="text-dark">Пользоватеь</h3>
      </div>
      <div class="mb-4 p-4">
        <span class="d-block mb-3 text-lg">Логин: {{ user.name }}</span>
        <span class="d-block">Баланс: {{ formatCurrency(balance) }}</span>
      </div>
    </div>
    <div>
      <div class="card mb-5">
        <div class="card-header d-flex align-items-center">
          <h3>Последние операции</h3> 
        </div>
        <div class="mb-4 p-4">
          <OperationList :operations="operations" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import OperationList from '../Components/OperationList.vue'
import { formatCurrency, formatDate } from '@/utils/formatters';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
  user: Object,
  operations: Array
})

const operations = ref(props.operations);
const balance = ref(props.user.balance);

/* Здесь можно было добавить разную логику для отображеня лоадера, состояния ошибки и т.д.
 но в целях экономии времени не стал этого делать */
const fetchOperations = async () => {
  try {
    const response = await axios.get('/getdata');
    operations.value = response.data.operations;
    balance.value = response.data.user.balance
  } catch (error) {
    alert('Ошибка обновления данных:', error);
  }
};

onMounted(() => {
  fetchOperations();
  const intervalId = setInterval(fetchOperations, 30000);

  onUnmounted(() => {
    clearInterval(intervalId);
  });
});

</script>

<style scoped>
.card {
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
</style>