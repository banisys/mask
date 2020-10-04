import swal from 'sweetalert2'

require('./bootstrap')

window.swal =swal

Vue.component('login', require('./components-site/login.vue').default)



Vue.component('pagination', require('laravel-vue-pagination'))
new Vue({
    el: '#app',
})
