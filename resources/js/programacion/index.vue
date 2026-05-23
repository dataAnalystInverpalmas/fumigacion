<script setup>
import Table from './table.vue';

</script>
<template>
      <div>

     <b-form-rating v-model="value"></b-form-rating>
    <p class="mt-2">Value: {{ value }}</p>
  </div>
    <h1>HOLA FUMIGACIONES</h1>
    <Table></Table>
</template>
