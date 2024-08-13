<template>
  <div class="container">
    <div class="row pt-5 mb-4">
      <div class="col-12 col-lg-auto">
        <h1 class="mb-4 mb-lg-0 lh-1">История операций</h1>
      </div>
      <div class="col-12 col-lg-3 ms-auto mb-2 mb-lg-0">
        <input type="text" v-model="filters.search" @input="search" placeholder="Поиск по описанию..."
          class="form-control" />
      </div>
      <div class="col-12 col-lg-auto">
        <div class="dropdown w-100">
          <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            Сортировать
          </button>
          <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuButton1">
            <li>
              <a class="dropdown-item" href="#" @click.prevent="sort('asc')">
                Сначала старые
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" @click.prevent="sort('desc')">
                Сначала новые
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <OperationList :operations="operations.data" />
        <Pagination class="mt-4" :links="operations.meta.links" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import OperationList from '../Components/OperationList.vue'
import Pagination from '../Components/Pagination.vue'

const props = defineProps({
  operations: Object,
  filters: Object,
});

const filters = ref(props.filters);
let searchTimeout = null;

const search = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    fetchData();
  }, 300);
};

const sort = (sortOrder) => {
  filters.value.sortOrder = sortOrder
  fetchData()
};

const fetchData = () => {
  router.get('/history', filters.value, { preserveState: true, replace: true });
}

watch(() => props.filters, (newFilters) => {
  filters.value = newFilters;
}, { deep: true });
</script>