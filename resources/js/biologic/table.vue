<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const tableRef = ref(null);

import Modal from './modal.vue';
import 'datatables.net-responsive';
let data = ref([]);
const emit = defineEmits(['edit', 'delete', 'load']);

const columns = ref([
  { data: 'description', title: 'Descripcion' },
  {
    data: null,
    render: '#action',
    title: 'Action',
    width: '20%',
    
  }
]);
const edit = () => {
  Modal.value.editProduct();
};
function increment() {

  columns.value.push(
    {
      data: 'nameSADASDS', title: 'Name',
      sTile: "asdasda", mData: "nameSADASDS"
    },
  );

}
function getBlancoBiologic() {
  axios.get('/biologic_table').then(function (response) {
    data.value = response.data.data;
    emit('load');
  })
    .catch(function (error) {
      debugger;

      console.log(error);
    })
    .finally(function () {
      debugger;

      // always executed
    });
}
function handleClick() {
  alert('hey');
}
onMounted(() => {
  getBlancoBiologic();
  // Puedes ejecutar cualquier otra lógica que necesites aquí
});

defineExpose({ data, getBlancoBiologic });
</script>

<template>


  <div class="table-responsive">
    <DataTables ref="tableRef"
     style="font-size:14px;" 
     class="table-sm table table-bordered table-hover display nowrap" :columns="columns" :data="data" :key="data.id"
     :options="{
/*      dom: 'Blfrt<<\'col-4 \'i><\'col-sm-12 col-7\'p>/>', */
      dom: `<\'row col-sm-12\'<\'col-sm-4 col-md-3\'l><\'col-sm-2 col-md-9\'f>/><\'col-sm-12\'tr>
      <\'row col-sm-12\'<\'col-5 \'i><\'col-9 d-flex justify-content-end\'p>/>`,
      responsive: true,
      autoWidth:false,
      /*  dom:  `<'top'i>rt<'bottom'flp><'clear'> `
      , */

      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
      },
      pageLength: 5,

    }"
     >
      <template #action="products" >

        <div class="text-center">
          <b-button @click.prevent="$emit('edit', products.rowData)" class="mr-2 " variant="primary" size="sm">
            <i class="fas fa-edit"></i></b-button>

          <b-button @click.prevent="$emit('delete', products.rowData)" class="mr-2 " variant="danger" size="sm">
            <i class="far fa-trash-alt"></i>
          </b-button>
        </div>
      </template>
    </DataTables>
  </div>
</template>
