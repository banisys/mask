import swal from 'sweetalert2'

require('./bootstrap')

window.swal =swal

Vue.component('categories-main', require('./components-admin/category/categories-main.vue').default)
Vue.component('categories-list', require('./components-admin/category/categories-list.vue').default)
Vue.component('category-select', require('./components-admin/category-select.vue').default)

Vue.component('brands-select', require('./components-admin/brands-select.vue').default)


Vue.component('pagination', require('laravel-vue-pagination'))

new Vue({
    el: '#app-admin',
})
