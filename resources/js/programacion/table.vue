
<script setup>
/* import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5'; */
import { ref } from 'vue';

/* DataTable.use(DataTablesCore);
 */const tableRef = ref(null);

const data = ref([
       
      
    ]);
const columns = ref([
  { data: 'name', title: 'Name' },
  { data: 'position', title: 'Position' },
  { data: 'office', title: 'Office' },
  { data: 'extn', title: 'Extension' },
  { data: 'start_date', title: 'Start date' },
  { data: 'salary', title: 'Salary' },
]);

function increment() {

    columns.value.push(
        { data: 'nameSADASDS', title: 'Name' ,
    sTile:"asdasda", mData:"nameSADASDS"},
);

}

</script>

<template>
    


 <DataTable
 class="table table-hover table-striped"
      width="100%"
 ref="tableRef"
   :columns="columns"
:data="data"
              :key="columns.length"

    />
  <!--   <v-btn  @click="increment" append-icon="$vuetify" variant="tonal">
  Button
</v-btn> -->
     <button  class="btn btn-primary" @click="increment">cambiar columnas</button>
 
<!--     <button @click="increment">cambiar columnas</button>
 -->

 </template>

<style>
@import 'bootstrap';

@import 'datatables.net-bs5';

</style>