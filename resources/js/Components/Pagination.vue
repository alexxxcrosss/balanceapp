<template>
  <nav aria-label="Page navigation" v-if="links && links.length > 3">
    <ul class="pagination">
      <li v-for="link in links" :key="link.url || link.label" 
          class="page-item" :class="{ 'active': link.active, 'disabled': !link.url }">
        <a class="page-link" href="#" @click.prevent="changePage(link)" v-html="link.label"></a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue';

const props = defineProps({
  links: Array,
})

const changePage = (link) => {
  if (link && link.url) {
    router.get(link.url, {}, {
      replace: true,
    });
  }
}
</script>
