
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('catalogo', require('./components/Catalogo.vue'));
Vue.component('pedido', require('./components/Pedido.vue'));
Vue.component('pedidobodega', require('./components/PedidoBodega.vue'));
Vue.component('pedidocliente', require('./components/PedidoCliente.vue'));


import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})


const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
