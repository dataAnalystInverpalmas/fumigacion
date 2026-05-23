<script setup>
import axios from 'axios';
import { ref, onMounted, watchEffect, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { Form, Field, useResetForm } from 'vee-validate';
import useToast from 'toastr';
import Swal from 'sweetalert2'
const emit = defineEmits(['create', 'delete'])
let products = {
    descripcion: ""
};
const props = defineProps(['options', 'value'])

const formProducts = ref(null);
const modalRef = ref(null);
const edit = ref(false);
const form = ref(null);
const myValue = ref(null) // Valor por defecto

const myOptionsProduct = ref(null);
const myOptionsIngredient = ref(null);
const produc = ref(null);
const ingredients = ref(null);

const onValidSubmit = (values, actions) => {
    if (edit.value) {
        onUpdateproduc(values, actions);
    } else {
        createProduct(values, actions);
    }
}
function onPrueba2() {
    $(produc.value.$el).find('select').val(3).trigger('change');

/*     produc.value.value="3";
 *//*     myValue.value.value = 3 */
/*     produc.value.dispatchEvent(new Event('change'))
 *//*     prueba.value = 3;
 */}
const createProduct = (values, { resetForm }) => {
    axios.post('/ingredient_activex_product_table', values)
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
    axios.put(`/ingredient_activex_product_table/${formProducts.value.id}`, values)
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

        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/ingredient_activex_product_table/${values.id_ingredient_act_prod}`).then(() => {
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
            } else {
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
const editProduct = (event, data) => {

    edit.value = true;
    formProducts.value = {
        id_producto: event.id_producto,
        id_ingredient_activ: event.id_ingredient_activ
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
const handleOk = (bvModalEvent) => {
    // Prevent modal from closing
    bvModalEvent.preventDefault()
    // Trigger submit handler
    this.handleSubmit()
}

function getProductsList() {
    axios.get('/products_table').then(function (response) {
        let response2 = response.data.data;
        let obj = [];
        response2.forEach(element => {
            obj.push({
                id: element.id,
                text: element.description
            })
        });
        myOptionsProduct.value = obj;


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
function getIngredientList() {
    axios.get('/ingredient_active_table').then(function (response) {
        let response2 = response.data.data;
        let obj = [];
        response2.forEach(element => {
            obj.push({
                id: element.id,
                text: element.description
            })
        });
        myOptionsIngredient.value = obj;

    })
        .catch(function (error) {
            debugger;

            console.log(error);
        })
        .finally(function () {
            debugger;

        });
}
function onModalShown() {
    if(edit.value){
    $(produc.value.$el).find('select').val(formProducts.value.id_producto
    ).trigger('change');
    $(ingredients.value.$el).find('select').val(formProducts.value.id_ingredient_activ
    ).trigger('change');
    }
}
onMounted(() => {
    getProductsList();
    getIngredientList();
})
/* watch(()=>{
    if (produc.value) {
        produc.value
        console.log("12s");
      }
}
) */

defineExpose({ onPrueba, addProduct, editProduct, onDeleteProduct });

</script>
<template>
    <div tabindex="0">

        <b-modal :tabindex="1" id="modalActions" :header-class="{
            'bg-edit': edit,
            'bg-init': !edit,
            'text-white': true, 'col-12': true, 'justify-content-center': true
        }" ignore-enforce-focus-selector="input" header-bg-variant="" @shown="onModalShown" centered ref="modalRef"
            hide-header-close :title="edit ? 'Editar' : 'Crear ingredientes para el producto'">
            <Form ref="form" @submit="onValidSubmit" id="idFormProduct" :initial-values="formProducts">

                <div class="row p-2">
                    <label for="id_turno" class="col-sm-3 col-form-label text-primary">Producto:</label>
                    <div class="form-group col-sm-8" width="100%">
                        <Field name="id_producto" as="Select2" id="select2" ref="produc" v-model="myValue"
                            :options="myOptionsProduct" :settings="{
            theme: 'bootstrap-5',
            width: '100%',
            containerCssClass: 'select2--small',
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
            settingOption: value, settingOption: value
        }" @change="myChangeEvent($event)" @select="mySelectEvent($event)">
                        </Field>

                    </div>
                </div>
                <div class="row p-2">
                    <label forv="id_turno" class="col-sm-3 col-form-label text-primary">Ingrediente activo:</label>
                    <div class="form-group col-sm-8 ">

                        <Field 
                        ref="ingredients"
                        name="ingredients" as="Select2" v-model="myValue" :options="myOptionsIngredient"
                            :settings="{
            multiple: 'true',
            theme: 'bootstrap-5',
            width: '100%',
            containerCssClass: 'select2--small',
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
            settingOption: value, settingOption: value
        }" @change="myChangeEvent($event)" @select="mySelectEvent($event)" class=" " />

                    </div>
                </div>
            </Form>


            <template #modal-footer="{ ok, cancel, hide }">
                <div class="col-12 text-center">

                    <!-- Emulate built in modal footer ok and cancel button actions -->
                    <b-button class="mr-2" size="sm" type="submit" variant="primary" form="idFormProduct">
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
<style>
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
    background-color: rgb(10 132 148) !important;
}

.bg-edit {
    background-color: #3e8ff4f0 !important;

}
</style>