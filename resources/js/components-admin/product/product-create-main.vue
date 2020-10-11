<template>
    <div class="container mt-4">
        <div class="row mb-4" v-if="progress">
            <progress :value="percent" max="100" style="width: 100%"></progress>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                         style="padding-bottom: 0;background-color: #343a40;border-bottom: 0;padding-left: 0;">
                        <ul class="nav nav-pills yy">
                            <li class="nav-item">
                                <a class="nav-link active" href="#public"
                                   data-toggle="tab">ویژگی های عمومی</a></li>

                            <li class="nav-item"><a class="nav-link" href="#gallery" data-toggle="tab">
                                تصاویر</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#description" data-toggle="tab">
                                نقد و بررسی</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#seo" data-toggle="tab">
                                بهینه سازی</a>
                            </li>
                            <li class="nav-item" style="margin: auto;margin-left:0px;">
                                <button type="submit" @click="formSubmit"
                                        style="background-color: #099020;border: unset;color: white;width:60px;height: 40px;border-top-right-radius: 10px;">
                                    ثبت
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="public">
                                <div class="container">
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>دسته بندی :</label>
                                                <br>
                                                <category-child-select @fixCat="fixCat($event)"></category-child-select>
                                            </div>
                                            <span style="color: red"> {{ error.cat }} </span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label for="exampleFormControlSelect3">برند :</label>
                                                <select class="form-control" id="exampleFormControlSelect3"
                                                        v-model="form.brand" @change="changeBrand()">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option v-for="brand in brands" :value="brand.id">
                                                        {{ brand.name }} - {{ brand.name_f }}
                                                    </option>
                                                    <option value="" v-if="flag_brand">دسته بندی را انتخاب کنید
                                                    </option>
                                                </select>
                                            </div>
                                            <span style="color: red"> {{ error.brand }} </span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label">نام :</label>
                                                <input type="text" class="form-control"
                                                       v-model="form.name">
                                            </div>
                                            <span style="color: red"> {{ error.name }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label" style="max-width: 100%;">قیمت
                                                    پایه :</label>
                                                <input type="number" class="form-control" v-model="form.price">
                                            </div>
                                            <span style="color: red"> {{ error.price }} </span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label class="col-md-4 control-label" style="max-width: 100%;">قیمت پس
                                                    از تخفیف
                                                    :</label>
                                                <input @keyup="calDiscount"
                                                       type="number" class="form-control" v-model="form.afterDiscount">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 4px">
                                                <label class="col-md-4 control-label">تخفیف :</label>
                                                <input @keyup="calDiscountPrice" type="number" class="form-control"
                                                       v-model="form.discount">
                                            </div>
                                            <span style="color: red"> {{ error.discount }} </span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom: 0">
                                                <label for="exampleFormControlSelect3">وضعیت :</label>
                                                <select class="form-control" id="exampleFormControlSelect3"
                                                        v-model="form.status">
                                                    <option value="" disabled hidden>انتخاب کنید...</option>
                                                    <option value="1">نمایش در سایت</option>
                                                    <option value="0">عدم نمایش در سایت</option>
                                                </select>
                                            </div>
                                            <span style="color: red"> {{ error.status }} </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 mt-4">
                                            <div class="form-group float-left">
                                                <img id="blah" class="ml-3"/>
                                                <label for="fileImage" id="label_file" class="btn btn-success"
                                                       style="font-weight: lighter;margin-bottom: 0;vertical-align: top;">
                                                    تصویر شاخص
                                                </label>
                                                <span style="color: red"> {{ error.image }} </span>
                                                <input type="file" onchange="readURL(this);" style="display:none;"
                                                       id="fileImage"
                                                       name="fileImage" @change="onImageChange">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="gallery">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="uploader"
                                             @dragenter="OnDragEnter"
                                             @dragleave="OnDragLeave"
                                             @dragover.prevent
                                             @drop="onDrop"
                                             :class="{ dragging: isDragging }">
                                            <div class="upload-control" v-show="images.length">
                                                <label for="file"
                                                       style="background-color: #838383;border: unset;padding: 5px">انتخاب
                                                    عکس</label>
                                            </div>
                                            <div v-show="!images.length">
                                                <i class="fa fa-cloud-upload"></i><br><br>
                                                <p style="font-weight: bold">سایز عکس : 725*1100</p>
                                                <div class="file-input">
                                                    <label for="file">انتخاب عکس</label>
                                                    <input type="file" id="file" @change="onInputChange" multiple>
                                                </div>
                                            </div>
                                            <div class="images-preview" v-show="images.length">
                                                <div class="img-wrapper" v-for="(image, index) in images"
                                                     :key="index" style="position: relative">
                                                    <a @click="deleteImage(index)">
                                                        <i class="fa fa-times del"></i>
                                                    </a>
                                                    <img :src="image">
                                                    <div class="details">
                                                        <span class="name" v-text="files[index].name"></span>
                                                        <span class="size"
                                                              v-text="getFileSize(files[index].size)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="color: red;margin-top: 12px;"> {{ error.pics }} </span>
                                </div>
                            </div>

                            <div class="tab-pane" id="description">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect3">نقد و بررسی :</label>
                                            <textarea type="text" name="editor1"></textarea>
                                        </div>
                                        <span style="color: red;"> {{ error.description }} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="seo">
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">عنوان صفحه
                                                :</label>
                                            <input type="text" class="form-control" v-model="form.seo_title">
                                        </div>
                                        <span style="color: red;"> {{ error.seo_title }} </span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group" style="margin-bottom: 7px">
                                            <label class="col-md-4 control-label" style="max-width: 100%">کلمات
                                                کلیدی :</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="key">
                                        </div>
                                        <span style="color: red;"> {{ error.seo_key }} </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">متای توضیحات :</label>
                                            <textarea type="number" class="form-control"
                                                      v-model="form.seo_description"
                                                      rows="8"></textarea>
                                        </div>
                                        <span style="color: red;"> {{ error.seo_description }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    name: '',
                    discount: 0,
                    price: '',
                    image: '',
                    brand: '',
                    catName: 'انتخاب کنید...',
                    cat: '',
                    status: '',
                    seo_title: '',
                    seo_key: '',
                    seo_description: '',
                    afterDiscount: '',
                },
                error: {name: '', short_desc: ''},
                specifications: '',
                specifications_val: {},
                effect_val: {},
                colors: [],
                product_id: '',
                brands: [],
                attachments: [],
                counter: [],
                isDragging: false,
                dragCount: 0,
                files: [],
                images: [],
                effect_prices: [],
                color_images: [],
                flag_brand: true,
                flag_spec: true,
                flag_spec_exist: false,
                flag_price: true,
                flag_price_exist: false,
                percent: 0,
                progress: false,
            }
        },
        methods: {
            calDiscount() {
                if (this.form.price == '') {
                    swal.fire(
                        {
                            text: 'لطفا ابتدا قیمت پایه را وارد کنید .',
                            type: 'warning',
                            confirmButtonText: 'باشه',
                        }
                    );
                    this.form.afterDiscount = '';
                } else {
                    let per = this.form.price / 100;

                    let x = this.form.afterDiscount / per;
                    let y = 100 - x;
                    this.form.discount = Math.round(y);
                }
            },
            calDiscountPrice() {
                if (this.form.price == '') {
                    swal.fire(
                        {
                            text: 'لطفا ابتدا قیمت پایه را وارد کنید .',
                            type: 'warning',
                            confirmButtonText: 'باشه',
                        }
                    );
                    this.form.discount = 0;
                } else {
                    let per = this.form.price / 100;
                    let x = 100 - this.form.discount;
                    let y = x * per;

                    this.form.afterDiscount = Math.round(y);
                }
            },
            OnDragEnter(e) {
                e.preventDefault();
                this.dragCount++;
                this.isDragging = true;
                return false;
            },
            OnDragLeave(e) {
                e.preventDefault();
                this.dragCount--;
                if (this.dragCount <= 0)
                    this.isDragging = false;
            },
            onInputChange(e) {
                const files = e.target.files;
                Array.from(files).forEach(file => this.addImage(file));
            },
            onInputChange2(e) {
                const files = e.target.files;
                let x = [];
                Array.from(files).forEach(file => x.push(file));
                this.color_images[this.colorCounter] = x;
                this.colorCounter++;
            },
            onDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                this.isDragging = false;
                const files = e.dataTransfer.files;
                Array.from(files).forEach(file => this.addImage(file));
            },
            addImage(file) {
                if (!file.type.match('image.*')) {
                    this.$toastr.e(`${file.name} is not an image`);
                    return;
                }
                this.files.push(file);
                const reader = new FileReader();
                reader.onload = (e) => this.images.push(e.target.result);
                reader.readAsDataURL(file);
            },
            addImage2(file) {
                this.color_images.push(file);
            },
            deleteImage(index) {
                this.images.splice(index, 1);
                this.files.splice(index, 1);
            },
            getFileSize(size) {
                const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
                let i = 0;

                while (size > 900) {
                    size /= 1024;
                    i++;
                }
                return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
            },
            addRow() {
                this.colors.push({});
            },
            deleteRow(index) {
                this.colors.splice(index, 1)
            },
            onImageChange(e) {
                this.form.image = e.target.files[0];
            },
            fieldChange(e) {
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i = 0; i < selectedFiles.length; i++) {
                    this.attachments.push(selectedFiles[i]);
                }
            },
            fetchBrand(y) {

                let _this = this;
                axios.get(`/admin/brand/fetch/${y}`).then(res => {
                    _this.brands = res.data;
                    console.log(_this.brands)
                    _this.flag_brand = false;
                });
            },
            changeBrand() {
                this.flag_price_exist = false;
                let cat = this.form.cat;
                let brand = this.form.brand;
                let data = this;
                axios.get(`/admin/product/effect/price/${cat}/${brand}`).then(res => {
                    data.effect_prices = res.data;

                    if (data.effect_prices.length) {
                        data.flag_price = false;
                    } else {
                        data.flag_price_exist = true;
                        data.flag_price = false;
                    }

                });
            },
            async fixCat(event) {
                this.form.cat = event
                this.fetchBrand(this.form.cat);
            },
            formSubmit(e) {
                e.preventDefault();
                var _this = this;
                let data = this;
                this.progress = true;
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };

                var formData = new FormData

                let seo_key = $("#key").val();
                let description = CKEDITOR.instances["editor1"].getData();

                this.files.forEach(file => {
                    formData.append('pics[]', file, file.name);
                })

                formData.append('image', this.form.image);
                formData.append('name', this.form.name);
                formData.append('brand', this.form.brand);
                formData.append('price', this.form.price);
                formData.append('status', this.form.status);
                formData.append('discount', this.form.discount);
                formData.append('description', description);
                formData.append('cat', this.form.cat);
                formData.append('seo_title', this.form.seo_title);
                formData.append('seo_key', seo_key);
                formData.append('seo_description', this.form.seo_description);

                axios.post('/admin/product/store', formData,
                    {
                        headers: {'content-type': 'multipart/form-data'},
                        onUploadProgress: function (uploadEvent) {
                            _this.percent = Math.round((uploadEvent.loaded / uploadEvent.total) * 100);
                        }
                    }
                ).then(function (res) {
                    window.location.href = `/admin/product/edit/${res.data}`
                }).catch(function (error) {
                    data.progress = false;
                    data.error.name = "";
                    data.error.description = "";
                    data.error.price = "";
                    data.error.image = "";
                    data.error.brand = "";
                    data.error.price = "";
                    data.error.status = "";
                    data.error.discount = "";
                    data.error.cat = "";
                    data.error.seo_title = "";
                    data.error.seo_key = "";
                    data.error.seo_description = "";
                    this.allerros = error.response.data.errors;
                    let x = error.response.data.errors;
                    if (Array.isArray(x.name)) {
                        data.error.name = this.allerros.name[0];
                    }
                    if (Array.isArray(x.cat)) {
                        data.error.cat = this.allerros.cat[0];
                    }
                    if (Array.isArray(x.price)) {
                        data.error.price = this.allerros.price[0];
                    }
                    if (Array.isArray(x.discount)) {
                        data.error.discount = this.allerros.discount[0];
                    }
                    if (Array.isArray(x.brand)) {
                        data.error.brand = this.allerros.brand[0];
                    }
                    if (Array.isArray(x.status)) {
                        data.error.status = this.allerros.status[0];
                    }
                    if (Array.isArray(x.description)) {
                        data.error.description = this.allerros.description[0];
                    }
                    if (Array.isArray(x.image)) {
                        data.error.image = this.allerros.image[0];
                    }
                    if (Array.isArray(x.seo_title)) {
                        data.error.seo_title = this.allerros.seo_title[0];
                    }
                    if (Array.isArray(x.seo_description)) {
                        data.error.seo_description = this.allerros.seo_description[0];
                    }
                    if (Array.isArray(x.seo_key)) {
                        data.error.seo_key = this.allerros.seo_key[0];
                    }
                    if (Array.isArray(x.pics)) {
                        data.error.pics = this.allerros.pics[0];
                    }
                });
            },
        },
        mounted() {
            this.fetchRootCat();
        }
    }
</script>

<style>

</style>