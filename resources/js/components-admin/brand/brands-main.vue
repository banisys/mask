<template>
    <div class="container mt-5 pb-5" style="position: relative">
        <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن برند</span>
        <div class="row" style="border: 1px #dedede solid;padding:35px 5px 0 5px;border-radius: 10px">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>دسته بندی :

                                </label>
                                <br>
                                <category-select @fixCat="form.name = $event"></category-select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="col-md-12 control-label">نام لاتین :

                                </label>
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="form.name_e"
                                       autofocus>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="col-md-12 control-label">نام فارسی :

                                </label>
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="form.name_f">
                            </div>
                        </div>

                        <div class="col-md-2" style="margin-top: 32px">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" @click="formSubmit">
                                    ثبت
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 ">
                        </div>
                        <div class="col-md-2">
                            <span style="color: red">{{ error.name_e }} </span>
                        </div>
                        <div class="col-md-2">
                            <span style="color: red"> {{ error.name_f }} </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">نام لاتین</th>
                        <th scope="col">نام فارسی</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="name" class="form-control" v-model="search.name"
                                   @keyup="searchName" placeholder="جستجو بر اساس نام لاتین">
                        </td>
                        <td>

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="(brand,index) in brands.data">
                        <td>{{brand.name}}</td>
                        <td>{{brand.name_f}}</td>

                        <td>
                            <a class="btn btn-sm btn-primary ml-3" @click="showCat(brand.cats,brand.id)"
                               style="color: white">
                                ویرایش دسته
                            </a>
                            <a @click="deleteBrand(brand.id)" style="font-size: 20px;">
                                <i class="fa fa-times" style="color: #dc3545"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row mt-3">
            <pagination :limit="2" :data="brands" @pagination-change-page="fetchBrands" style="margin:auto"></pagination>
        </div>
        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-dialog-scrollable" role="document" style="max-width:100%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="text-align: center">
                                <img v-if="pic" :src="'/images/brand/'+pic">
                                <p v-if="description">{{ description }}</p>


                                <select v-if="modalCats" multiple name="artists2[]" v-model="selected_cats"
                                        style="width: 30%;height:80%">
                                    <option v-for="cat in cats" :value="cat.id">
                                        {{ cat.name }}
                                    </option>
                                </select>
                                <br>
                                <br>
                                <button v-if="modalCats" type="button" class="btn btn-primary" @click="formSubmit2">
                                    ثبت
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected_cats: [],
                category: '',
                cats: [],
                showModal: false,
                form: {
                    name_e: '',
                    name_f: '',
                    image: null,
                    description: '',
                    name: 'انتخاب کنید...',
                },
                search: {
                    id: '',
                    name: '',
                },
                error: {
                    name: '',
                    name_f: '',
                    name_e: '',
                    image: '',
                    description: '',
                },
                brands: [],
                pic: '',
                description: '',
                modalCats: false,
                brandHolder: '',
                editCat: '2',
                // tree
                categories: [],
                output: '',
                holder: {
                    selfName: 'ریشه',
                    selfId: '',
                    parentName: '',
                    parentId: '',
                    grandName: 'ریشه',
                    grandId: '',
                },
                flag: false,
                flag1: true,
                flag2: false,
                roots: [],
                childs: [],
            }
        },
        methods: {
            fetchCat() {
                let _this = this;
                axios.get('/admin/brand/cat').then(res => {
                    _this.cats = res.data;
                });
            },
            onImageChange(e) {
                this.form.image = e.target.files[0];
            },
            empty() {
                this.form.description = "";
            },
            fetchBrands(page = 1) {
                let _this=this
                axios.get('/admin/brand/fetch?page=' + page).then(res => {
                    _this.brands = res.data;
                    console.log(_this.brands)
                });
            },
            deleteBrand(id) {
                let _this = this;
                swal.fire({
                    text: "آیا از پاک کردن اطمینان دارید ؟",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله',
                    cancelButtonText: 'لغو',
                }).then((result) => {
                    if (result.value) {

                        axios.get(`/admin/brand/delete/${id}`)
                            .then((res) => {

                                if (res.data === "cant") {
                                    swal.fire(
                                        {
                                            text: "این برند دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                            type: "warning",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                } else {
                                    swal.fire(
                                        {
                                            text: "این برند با موفقیت حذف شد !",
                                            type: "success",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    _this.fetchBrands();
                                }
                            }).catch(() => {
                            swal.fire(
                                {
                                    text: "درخواست شما انجام نشد !",
                                    type: "error",
                                    confirmButtonText: 'باشه',
                                }
                            )
                        });

                    }
                });
            },
            searchId(page = 1) {
                let data = this;
                if (this.search.id.length > 0) {
                    axios.get('/admin/brand/search?page=' + page, {params: {id: this.search.id}}).then(response => {
                        data.brands = response.data;
                    });
                }
                if (this.search.id.length === 0) {
                    this.fetchBrands();
                }
            },
            searchName(page = 1) {
                let data = this;
                if (this.search.name.length > 0) {
                    axios.get('/admin/brand/search?page=' + page, {params: {name: this.search.name}}).then(response => {
                        data.brands = response.data;
                    });
                }
                if (this.search.name.length === 0) {
                    this.fetchBrands();
                }
            },
            showDescription(id, index) {
                this.modalCats = false;
                this.pic = '';
                let data = this;
                this.showModal = true;

                axios.get(`/admin/brand/description/${id}`).then(function (res) {
                    data.description = res.data;

                }).catch(function (error) {
                });
            },
            showImage(id) {
                this.modalCats = false;
                this.description = '';
                let data = this;
                this.showModal = true;
                this.pic = true;
                axios.get(`/admin/brand/image/${id}`).then(function (res) {
                    data.pic = res.data;
                }).catch(function (error) {
                });
            },
            showCat(cats, brandId) {
                console.log(cats)
                this.description = '';
                this.brandHolder = brandId;
                let _this = this;
                this.pic = false;
                this.modalCats = true;
                this.showModal = true;

                let arr;
                arr = [];
                Object.keys(cats).forEach(key => {
                    arr.push(cats[key].id);
                });
                this.selected_cats = arr;
            },
            formSubmit(e) {
                e.preventDefault();

                if (this.form.name === 'انتخاب کنید...') {
                    swal.fire(
                        {
                            text: "دسته بندی را مشخص کنید .",
                            type: "warning",
                            confirmButtonText: 'باشه',
                        }
                    );
                    return false;
                }

                let data = this;
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };
                let formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('name_e', this.form.name_e);
                formData.append('name_f', this.form.name_f);
                formData.append('image', this.form.image);
                formData.append('description', this.form.description);

                axios.post('/admin/brand/store', formData, config)
                    .then(function (response) {
                        location.reload();
                    })
                    .catch(function (error) {
                        data.error.name_e = "";
                        data.error.name_f = "";
                        data.error.cat_id = "";

                        this.allerros = error.response.data.errors;
                        let x = error.response.data.errors;

                        if (Array.isArray(x.name_e)) {
                            data.error.name_e = this.allerros.name_e[0];
                        }

                        if (Array.isArray(x.name_f)) {
                            data.error.name_f = this.allerros.name_f[0];
                        }

                    });
            },
            formSubmit2(e) {
                e.preventDefault();
                let _this = this;
                let formData = new FormData();
                formData.append('cats', this.selected_cats);
                formData.append('brand', this.brandHolder);

                axios.post('/admin/brand/edit/cat', formData)
                    .then(function (response) {
                        location.reload();
                    });
            },
        },
        mounted() {
            this.fetchBrands()
            this.fetchCat()
        }
    }
</script>

<style>


</style>