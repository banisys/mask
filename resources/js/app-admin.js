import swal from 'sweetalert2'

require('./bootstrap')

window.swal =swal

Vue.component('categories-main', require('./components-admin/categories-main.vue').default)
Vue.component('categories-list', require('./components-admin/categories-list.vue').default)
Vue.component('categories', require('./components-admin/categories.vue').default)


Vue.component('pagination', require('laravel-vue-pagination'))

new Vue({
    el: '#app-admin',
})
