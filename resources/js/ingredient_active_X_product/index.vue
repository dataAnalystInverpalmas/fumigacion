<script setup>
import Table from './table.vue';
import Modal from './modal.vue';
import { ref,reactive } from 'vue';

const modal = ref(null);
const table = ref(null);
const title = ref(0);
function actions(){
    table.value.getIngredientActiveProduct();
}
function add(){
    modal.value.addProduct();
}
function edit(data){
    modal.value.editProduct(data);
}
function deleteP(data){
 const fecthDele = () =>{
    return new Promise((resolve,reject) =>{
        resolve(modal.value.onDeleteProduct(data));
  });
};
  
fecthDele().then((result)=>{
    if(result){
    table.value.getIngredientActiveProduct();
    }
});
}
function countDataProd(){
    title.value =  table.value.data.length;
    console.log('sssasdas');
}
function getIngredientActive() {
  axios.get('/ingredient_active_table').then(function (response) {
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

</script>
<template>
<prueba></prueba>
    <b-container class="bv-example-row bv-example-row-flex-cols p-5 container-fluid">
        <b-row  align-v="start">

            <div class="card " >
                <di class=" col-12  mt-n4">
                    <div class="shadow-lg text-white fw-bold  color_red
    
    p-3  bg-body rounded d-flex justify-content-between align-items-center">INGREDIENTES POR PRODUCTO
                           
    <b-button @click="add()" variant="default" class="btn fw-bold text-white" >
                          
                          <i class="fas fa-plus"></i>
                      </b-button>     
                        </div>
                        <Modal ref="modal" @create="actions" @edit="actions"></Modal>

                </di v>
                <div class="card-body ">


                    <div class="col">
                   <h6 class="card-subtitle fw-normal text-primary fw-bold mb-4"> 
{{ title }}
Ingredientes activo por producto

                        </h6>

                    </div>         
 <Table ref="table" @edit="edit" @delete="deleteP" @load="countDataProd"></Table>


</div>
   </div>
        </b-row>

    </b-container>
    
</template>
<style>
.color_red {

  background: linear-gradient(120deg, rgba(38,157,238,0.9192051820728291) 34%, rgba(114,56,251,0.76234243697479) 56%);
 
}
</style>

