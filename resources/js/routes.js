
import Example from './components/ExampleComponent.vue';
import NavBar from './components/NavBar.vue'
import ProgamaIndex from './programacion/index.vue'
import ProductsIndex from './products/index.vue'
import BlancoBioIndex from './biologic/index.vue'
import UnidadMediIndex from './unit_measure/index.vue'
import TipoProductIndex from './type_product/index.vue'
import TipoAplicacionIndex from './type_application/index.vue'
import IngredienteActivoIndex from './ingredient_active/index.vue'
import IngredienteActivoProductIndex from './ingredient_active_X_product/index.vue'
import BlancoBiolXProduct from './blanco_biolog_x_product/index.vue'
import ModalVue from './products/modal.vue'

/* import login from './auth/login'
import register from './auth/register'
import logout from './auth/logout' */
export default [
    {
        path: "/menu",
        name: "example",
        component: Example
    },
    {
        path: "/home",
        name: "homeDashboard",
        component: NavBar
    },
    {
        path: "/programacion",
        name: "programIndex",
        component: ProgamaIndex
    },
    {
        path: "/products",
        name: "ProductsIndex",
        component: ProductsIndex
    },
    {
        path: "/blancoBiol",
        name: "BlancoBioIndex",
        component: BlancoBioIndex
    },
    {
        path: "/unidadaMed",
        name: "UnidadMediIndex",
        component: UnidadMediIndex
    },
    {
        path: "/tipo_product",
        name: "TipoProductIndex",
        component: TipoProductIndex
    },
    {
        path: "/ingrediente_activo",
        name: "IngredienteActivoIndex",
        component: IngredienteActivoIndex
    },
    {
        path: "/ingrediente_activo_product",
        name: "IngredienteActivoProductIndex",
        component: IngredienteActivoProductIndex
    },
    {
        path: "/type_application",
        name: "TipoAplicacionIndex",
        component: TipoAplicacionIndex

    },
    {
        path: "/blanco_biologico_x_product",
        name: "BlancoBiolProductIndex",
        component: BlancoBiolXProduct

    },
    {
        path: "/definition_recet",
        name: "BlancoBiolProductIndex",
        component: BlancoBiolXProduct

    }

    /*   {
          path: "/login",
          name: login,
          component: ""
      } */
]