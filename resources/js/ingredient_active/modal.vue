<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { Form, Field, useResetForm } from 'vee-validate';
import useToast from 'toastr';
import Swal from 'sweetalert2'
const emit = defineEmits(['create', 'delete'])
let products = {
    descripcion: ""
};
const formProducts = ref(null);
const modalRef = ref(null);
const edit = ref(false);
const form = ref(null);
const onValidSubmit = (values, actions) => {
    if (edit.value) {
        onUpdateproduc(values, actions);
    } else {
        createProduct(values, actions);
    }
}
const createProduct = (values, { resetForm }) => {
    axios.post('/ingredient_active_table', values)
        .then((response) => {
            resetForm();
            modalRef.value.hide('modalActions');
            emit('create');
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                timerProgressBar: true,


            });
            Toast.fire({
                icon: 'info',
                title: `Ingrediente activo creado correctamente `
            })
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })

};
const onUpdateproduc = (values, { resetForm }) => {
    axios.put(`/ingredient_active_table/${formProducts.value.id}`, values)
        .then((response) => {
            resetForm();
            modalRef.value.hide('modalActions');
            emit('edit');
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                timerProgressBar: true,


            });
            Toast.fire({
                icon: 'success',
                title: `Ingrediente activo actualizado correctamente `
            })
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
}
const onDeleteProduct = (values) => {
    return new Promise((resolve, reject) => {

    const SwalStyle = Swal.mixin({

        customClass: {
            actions: "d-grid gap-2 d-md-flex justify-content-md-end",
            confirmButton: 'btn btn-success btn-sm !important',
            cancelButton: 'btn btn-danger  btn-sm !important',
        },

        buttonsStyling: false
    });
    SwalStyle.fire({
        title: '<h4 class="text-muted fw-bold" >¿Esta seguro de eliminar el Ingrediente activo?</h4>',
        icon: "error",
        width: "26em",
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancel',

    }).then((result)=>{
        if(result.isConfirmed){
               axios.delete(`/ingredient_active_table/${values.id}`).then(()=>{
                emit('edit');
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                timerProgressBar: true,


            });
            Toast.fire({
                icon: 'success',
                title: `Ingrediente activo borrado correctamente `
            });
               }) 
               resolve(true)
        }else{
            resolve(false)
 
        }
    });
});
}

const addProduct = () => {
    edit.value = false;
    formProducts.value = {
        id: null,
        description: ''
    }
    modalRef.value.show('modalActions');
};
const editProduct = (data) => {
    edit.value = true;
/*      form.value.resetForm();
 */  formProducts.value = {
        id: data.id,
        description: data.description
    }
    modalRef.value.show('modalActions');
};
// Puedes ejecutar cualquier otra lógica que necesites aquí
function onPrueba() {

    emit('create');
    modalRef.value.hide('modalActions');

}
const onCreateProduct = (event) => {
    modalRef.value.hide('modalActions');

    router.push({ path: '/products' });

}
function getProducts() {
  axios.get('/products_table').then(function (response) {
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
const handleOk = (bvModalEvent) => {
    // Prevent modal from closing
    bvModalEvent.preventDefault()
    // Trigger submit handler
    this.handleSubmit()
}
defineExpose({ onPrueba, addProduct, editProduct,onDeleteProduct });

</script>
<template>

    <div>
      

        <b-modal id="modalActions"  :header-class="{
            'bg-edit': edit,
             'bg-init': !edit,
             'text-white':true,  'col-12':true,  'justify-content-center':true}" header-bg-variant=""
        centered ref="modalRef" hide-header-close
            :title="edit ? 'Editar' : 'Crear ingrediente activo'">

            <Form ref="form" @submit="onValidSubmit" id="idFormProduct" :initial-values="formProducts">
                <!-- <b-form-input id="name-input" v-model="products.descripcion" :state="nameState"
                        required></b-form-input> -->
                <div class="row p-2">
                    <label for="description" class="col-sm-3 col-form-label text-primary">Descripcion:</label>
                    <div class="form-group col-sm-8 ">
                        <Field name="description" class="form-control form-control-sm"></Field>

                    </div>
                </div>
            </Form>
            <template #modal-footer="{ ok, cancel, hide }">
                <div class="col-12 text-center">

                    <!-- Emulate built in modal footer ok and cancel button actions -->
                    <b-button class="mr-2" size="sm" type="submit" variant="primary"
                        form="idFormProduct">
                        {{ edit ? 'Actualizar' : 'Guardar' }}
                    </b-button>
                    <b-button size="sm" variant="outline-secondary" @click="cancel()">
                        Cancelar
                    </b-button>
                </div>
                <!-- Button with custom close trigger value -->

            </template>

            <!--             <b-button type="submit">Guardar</b-button>
 -->
        </b-modal>

    </div>
</template>
<style >
.colored-toast.swal2-icon-info {
    background-color: #3fc3ee !important;
}

.colored-toast.swal2-icon-success {
    background-color: #a5dc86 !important;
}

.colored-toast.swal2-icon-error {
    background-color: #f27474 !important;
}

.colored-toast .swal2-title {
    color: white;
}

.colored-toast .swal2-close {
    color: white;
}

.colored-toast .swal2-html-container {
    color: white;
}
.colored-toast .swal2-html-container {
    color: white;
}
.bg-init {
    background-color: rgb(10 132 148) !important ;
}
.bg-edit {
    background-color:#3e8ff4f0 !important;

}
</style>