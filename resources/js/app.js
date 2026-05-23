/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import { createApp } from 'vue';
import 'admin-lte/plugins/jquery/jquery.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import Routes from './routes.js';
 import App from './App.vue';
  import Select2 from 'vue3-select2-component';
import { createRouter, createWebHistory } from 'vue-router';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import { ref } from 'vue';

DataTable.use(DataTablesCore);
import "admin-lte/dist/js/adminlte.min.js";
import { BootstrapVue } from 'bootstrap-vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
//import 'vuetify/styles'
//import { createVuetify } from 'vuetify'
//import * as components from 'vuetify/components'
//import * as directives from 'vuetify/directives'

/*const vuetify = createVuetify({
  components,
  directives,
}) */
/* createApp({
  MODE: 3,
}) */
const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});
/*
const Select3= {
  props: ['options', 'value'],
  mounted() {
    this.$select2 = $(this.$el).select2({
      data: this.options
    }).on('change', (e) => {
      this.$emit('input', $(e.target).val());
    });
  },
  watch: {
    options(newOpts) {
      this.$select2.empty().select2({
        data: newOpts
      });
    },
    value(newValue) {
      if (newValue !== $(this.$el).val()) {
        $(this.$el).val(newValue).trigger('change');
      }
    },
  },
  template: '<select></select>',
};
*/
const app = createApp(App);
app.component('DataTables',DataTable);
app.component('Select2', Select2);

/* import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent); */
/* app.use(vuetify);

 */

app.use(router);
app.use(BootstrapVue);
app.mount('#app');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

 