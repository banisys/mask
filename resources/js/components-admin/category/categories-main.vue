<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <span style="position: absolute;margin-right:10px;top: -14px;background-color: #f4f6f9;color: #9f9f9f;">افزودن دسته بندی</span>
                    <div style="border: 1px #dedede solid;padding:35px 5px 15px 5px;border-radius: 10px" class="row">

                        <div class="col-md-4">
                            <div class="form-group">

                                <label>دسته والد :</label>
                                <br>
                                <category-select @fixCat="form.name = $event"></category-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>نام دسته :</label>
                                <input type="text" class="form-control" v-model="form.title">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>برند :</label><br>
                                <brands-select @setHolderBrandId="holderBrandId=$event"></brands-select>
                            </div>
                        </div>

                        <div class="col-md-1" style="margin-top: 32px">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" @click="formSubmit">
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="widget" style="text-align: right">
                    <ul id="categories">
                        <template v-for="(cat,key,index) in cats">
                            <li style="font-size:14px;">
                                <input @keyup.enter.prevent="editCat($event,cat.id)"
                                       :value="cat.name"
                                       style="border: unset;background-color: #f4f6f9;color: #c40316;font-weight: bold;display:inline-block; ">
                                <categories-list :cat="cat"></categories-list>
                            </li>
                            <hr v-if="cats.length !== key+1"
                                style="margin-top: .7rem;margin-bottom: .7rem">
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: 'انتخاب کنید...',
                    title: '',
                    description: '',
                    image: null,
                    type: '',
                    brands: [],
                },
                categories: [],
                output: '',
                search: {
                    name: '',
                },
                categories2: [],
                parents: '',
                parentname: [],
                parpar: [],
                error: {
                    name: '',
                    parent: '',
                },
                data_results: [],
                showModal: false,
                cats: [],
                catHolder: '',
            }
        },
        methods: {
            editCat(e, id) {
                if (e.target.value == '') {
                    this.deleteCategory(id);
                } else {
                    let formData = new FormData();
                    formData.append('name', e.target.value);
                    formData.append('id', id);

                    axios.post('/admin/category/edit', formData)
                        .then(function (response) {
                            location.reload();
                        });
                }
            },
            deleteCategory(id) {
                let obj = this;
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
                        axios.get(`/admin/category/delete/${id}`)
                            .then((res) => {
                                if (res.data === "cant") {
                                    swal.fire(
                                        {
                                            text: "این دسته دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                            type: "warning",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    setTimeout(function () {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    location.reload();
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
            fetchCats() {
                let _this = this;
                axios.get('/admin/category/fetch/search/cats').then(function (res) {
                    _this.cats = res.data
                })
            },
            fetchCategories() {
                let data = this;
                axios.get('/admin/category/fetch')
                    .then(res => {
                        data.categories = res.data;
                    });
            },
            formSubmit(e) {
                e.preventDefault()
                if (this.form.name === 'انتخاب کنید...' || this.form.title === '') {
                    swal.fire(
                        {
                            text: "دسته والد و نام دسته را وارد کنید",
                            type: "warning",
                            confirmButtonText: 'باشه',
                        }
                    )
                } else {
                    let _this = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                    let formData = new FormData();
                    formData.append('name', this.form.title);
                    formData.append('description', this.form.description);
                    formData.append('parent', this.form.name);
                    formData.append('image', this.form.image);
                    formData.append('type', this.form.type);
                    formData.append('brand_id', this.holderBrandId);

                    axios.post('/admin/category/store', formData, config)
                        .then(function (response) {
                            location.reload();
                        })
                }
            },
        },
        mounted() {
            this.fetchCats()
        }
    }
</script>

<style>
    #input-search {
        display: block;
        border-bottom: 1px solid gray;
        border-left: unset;
        border-right: unset;
        border-top: unset;
        width: 100%;
        margin-bottom: 10px;
    }

    .brand-select {
        line-height: 35px;
        padding: 0px 10px;
        border-radius: 5px;
        background-color: #358fdc;
        color: white;
        margin-top: 2px;
        margin-bottom: 2px;
        transition: all 0.3s;
    }

    #categories {
        cursor: pointer;
        user-select: none
    }

    #categories > li {
        position: relative;
    }

    #categories > li ul > li {
        position: relative;
    }

    #area {
        text-align: right
    }

    #price {
        text-decoration-line: line-through;
        display: inline-block;
        float: left;
        font-size: 14px;
        margin-right: 12px;
    }

    .price {
        display: inline-block;
        float: right;
    }

    .pro_name {
        line-height: 28px;
    }

    .nav-link {
        padding: 5px 10px !important;
    }

    .dropdown-menu-right, .dropdown-menu {
        text-align: right
    }

    li {
        list-style: none
    }

    #btn-cat {
        position: relative;
        background-color: white;
        border: 1px solid #ced4da;
        width: 100%;
        padding: 8px 8px 0 8px;
        border-radius: 5px;
        text-align: right;
        color: #484848;
        height: 41px;
        overflow: hidden;
    }

    #angle-down {
        float: left;
        margin: 6px 2px;
        color: #636363;
    }

    #sss {
        position: absolute;
        list-style: none;
        top: 73px;
        z-index: 99;
        background-color: white;
        padding: 5px 15px;
        width: 100%;
        line-height: 35px;
        border: 1px solid #c8c8c8;
        overflow-x: hidden;
        max-height: 350px;
    }

    #angle-left {
        float: left;
        margin-top: 10px;
        color: #636363;
    }

    #sss li {
        cursor: pointer
    }

    .fa {
        font-size: 1.1rem
    }

    .modal-mask {
        position: fixed !important;
        z-index: 9998 !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100vh !important;
        background-color: rgba(0, 0, 0, .5) !important;
        display: table !important;
        transition: opacity .3s ease !important;
    }

    .modal-content {
        max-height: calc(100vh - -3.5rem) !important;
        height: 100vh
    }

    .fa {
        font-size: 1.1rem;
    }

    label {
        font-weight: unset !important;
    }

    button:focus {
        outline: rgba(122, 186, 255, 0.68) solid 2px !important;
    }

</style>