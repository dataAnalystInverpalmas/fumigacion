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
const myOptionsUnitMea = ref(null);
const myOptionsTypeProduct = ref(null);
const unidMed = ref(null);
const tipoProduc = ref(null);
const onValidSubmit = (values, actions) => {
    if (edit.value) {
        onUpdateproduc(values, actions);
    } else {
        createProduct(values, actions);
    }
}
const createProduct = (values, { resetForm }) => {
    axios.post('/products_table', values)
        .then((response) => {
            resetForm();
            modalRef.value.hide('modalActions');
            emit('create');

            /*      users.value.data.unshift(response.data);
            $('#userFormModal').modal('hide');
            resetForm(); */
            /*     useToast.success('Producto creado correctamente!',
                {
                    position: 'top'
                }); */
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
                title: `Producto creado correctamente `
            })
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })

};
const onUpdateproduc = (values, { resetForm }) => {
    axios.put(`/products_table/${formProducts.value.id}`, values)
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
                title: `Producto actualizado correctamente `
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
            title: '<h4 class="text-muted fw-bold" >¿Esta seguro de eliminar el producto?</h4>',
            icon: "error",
            width: "26em",
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancel',

        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/products_table/${values.id}`).then(() => {
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
                        title: `Producto borrado correctamente `
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
const editProduct = (data) => {
    edit.value = true;
/*      form.value.resetForm();
 */  formProducts.value = {
        id: data.id,
        name: data.nombre,
        dosis: data.dosis,
        valueUnit: data.valor_unitario,
        code: data.codigo,
        Categor: data.categoria,
        id_tipo_producto: data.id_tipo_producto,
        id_unidad_medida: data.id_unidad_medida
        
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
function getUnitMedList() {
    axios.get('/unit_meansure').then(function (response) {
        let response2 = response.data.data;
        let obj = [];
        response2.forEach(element => {
            obj.push({
                id: element.id,
                text: element.description
            })
        });
        myOptionsUnitMea.value = obj;

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
    $(unidMed.value.$el).find('select').val(formProducts.value.id_unidad_medida
    ).trigger('change');
    $(tipoProduc.value.$el).find('select').val(formProducts.value.id_tipo_producto
    ).trigger('change');
    }
}
function getTypeProductList() {
    axios.get('/type_product_table').then(function (response) {
        let response2 = response.data.data;
        let obj = [];
        response2.forEach(element => {
            obj.push({
                id: element.id,
                text: element.description
            })
        });
        myOptionsTypeProduct.value = obj;

    })
        .catch(function (error) {
            debugger;

            console.log(error);
        })
        .finally(function () {
            debugger;

        });
}
onMounted(() => {
    getUnitMedList();
    getTypeProductList();
})
defineExpose({ onPrueba, addProduct, editProduct, onDeleteProduct });

</script>
<template>

    <div>


        <b-modal id="modalActions" :header-class="{
            'bg-edit': edit,
            'bg-init': !edit,
            'text-white': true, 'col-12': true, 'justify-content-center': true
        }" header-bg-variant="" 
        @shown="onModalShown" 
        centered ref="modalRef" hide-header-close :title="edit ? 'EDITAR' : 'Crear producto'">

            <Form ref="form" @submit="onValidSubmit" id="idFormProduct" :initial-values="formProducts">
                <!-- <b-form-input id="name-input" v-model="products.descripcion" :state="nameState"
                        required></b-form-input> -->
                <div class="row">

                    <div class="form-group col-sm-6 ">
                        <label for="nombre" class="col-sm-3 col-form-label text-primary">Nombre:</label>
                        <div class="form-group  ">
                            <Field name="name" class="form-control form-control-sm"></Field>

                        </div>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-3 col-form-label text-primary">Dosis:</label>
                        <div class="form-group ">
                            <Field name="dosis" class="form-control form-control-sm"></Field>

                        </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-8 col-form-label text-primary">Valor unitrio:</label>
                        <div class="form-group ">
                            <Field name="valueUnit" class="form-control form-control-sm"></Field>

                        </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-4 col-form-label text-primary">Codigo:</label>
                        <div class="form-group ">
                            <Field name="code" class="form-control form-control-sm"></Field>

                        </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-3 col-form-label text-primary">Categoria:</label>
                        <div class="form-group ">
                            <Field name="Categor" class="form-control form-control-sm"></Field>

                        </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-8 col-form-label text-primary">Unidad medida:</label>
                        <div class="form-group ">
                            <!--                             <Field name="undMed" class="form-control form-control-sm"></Field>
 -->
                            <Field ref="unidMed" name="id_unidad_medida" as="Select2" id="select_id_unidad_medida"  v-model="myValue"
                                :options="myOptionsUnitMea" :settings="{
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
                    <div class="form-group col-sm-6 ">
                        <label for="description" class="col-sm-8 col-form-label text-primary">Tipo producto</label>
                        <div class="form-group ">
                            <!--                             <Field name="undMed" class="form-control form-control-sm"></Field>
 -->
                            <Field name="id_tipo_producto" as="Select2" id="select2_id_tipo_producto" ref="tipoProduc" v-model="myValue"
                                :options="myOptionsTypeProduct" :settings="{
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