<script setup>
import Table from './table.vue';
import Modal from './modal.vue';
import { ref,reactive } from 'vue';

const modal = ref(null);
const table = ref(null);
const title = ref(0);
function actions(){
    table.value.getProducts();
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
    table.value.getProducts();
    }
});
}
function countDataProd(){
    title.value =  table.value.data.length;
    console.log('sssasdas');
}


</script>
<template>

    <b-container class="bv-example-row bv-example-row-flex-cols p-5 container-fluid">
        <b-row  align-v="start">

            <div class="card " >
                <div class=" col-12  mt-n4">
                    <div class="shadow-lg text-white fw-bold  color_red
    
    p-3  bg-body rounded d-flex justify-content-between align-items-center">PRODUCTOS
        <div>  
          <!--   <b-button @click="add()" variant="default" class="btn fw-bold text-white" >
                          Agregar blanco biologico
                      </b-button>   -->    
                      <router-link :to="{ name: 'BlancoBiolProductIndex' }" >
<b-button @click="add()" variant="default" class="btn fw-bold text-white" >
                          Agregar blanco biologico
                      </b-button>
                        </router-link>           
    <b-button @click="add()" variant="default" class="btn fw-bold text-white" >
                          
                          <i class="fas fa-plus"></i>
                      </b-button>     
                                                 
   
                    </div>
                        </div>
                        <Modal ref="modal" @create="actions" @edit="actions"></Modal>

                </div>
                <div class="card-body ">


                    <div class="col">
                        <!--           <h5 class="card-title fs-4 fw-semibold">Productos</h5>
 -->
                        <h6 class="card-subtitle fw-normal text-primary fw-bold mb-4"> 
{{ title }}
 productos registrados 

                        </h6>

                    </div>
<!--                     <div class="table-responsive">
 -->
                  
<!--                     </div>
 -->             
 <Table ref="table" @edit="edit" @delete="deleteP" @load="countDataProd"></Table>
<!--  <Table ref="table"></Table>
 -->  

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