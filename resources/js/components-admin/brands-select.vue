<template>
    <div>
        <button @click="clickBrandBtn" id="btn-cat">
            <template v-show="form.brands.length"> {{ form.brands }}</template>
            <i class="right fa fa-angle-down" id="angle-down"></i>
        </button>
        <div v-show="flagBrand" id="sss">
            <input type="text" v-model="brandSearch"
                   id="input-search"
                   @keyup="searchBrand"
                   placeholder="جستجو...">
            <ul v-show="flagBrand1">
                <li style="line-height: 35px;" @click="selectBrand(brand.name,brand.id)"
                    v-for="(brand,index) in brands"
                    :id="'brand-id'+brand.id">
                    <span>{{ brand.name }}</span>
                    <span style="float: left">{{ brand.name_f }}</span>
                </li>
                <li v-show="!brands.length">
                    <span style="color: red">موردی یافت نشد</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    brands: [],
                },
                output: '',
                search: {
                    name: '',
                },
                categories2: [],
                parents: '',
                parentname: [],
                parpar: [],
                data_results: [],
                brands: [],
                flagBrand: false,
                flagBrand1: true,
                holderBrandId: [],
                brandSearch: '',
            }
        },
        methods: {
            searchBrand() {
                let _this = this;
                if (this.brandSearch === '') {
                    this.fetchBrands();
                } else {
                    axios.get(`/admin/category/search/brand/${this.brandSearch}`).then(response => {
                        _this.brands = response.data;
                    });
                }
            },
            clickBrandBtn() {
                if (this.flagBrand === false) {
                    this.flagBrand = true;
                } else if (this.flagBrand === true) {
                    this.flagBrand = false
                }
            },
            selectBrand(name, id) {
                let existInHolder = false;
                let existBrand = false;

                this.holderBrandId.forEach(function (item) {
                    if (item === id) {
                        existInHolder = true;
                    }
                });

                this.form.brands.forEach(function (item) {
                    if (item === name) {
                        existBrand = true;
                    }
                });

                if (existInHolder) {
                    for (var i = 0; i < this.holderBrandId.length; i++) {
                        if (this.holderBrandId[i] === id) {
                            this.holderBrandId.splice(i, 1);
                        }
                    }

                } else {
                    this.holderBrandId.push(id);
                }

                if (existBrand) {
                    for (var i = 0; i < this.form.brands.length; i++) {
                        if (this.form.brands[i] === name) {
                            this.form.brands.splice(i, 1);
                        }
                    }
                } else {
                    this.form.brands.push(name);
                }
                this.$emit('setHolderBrandId', this.holderBrandId)

            },
            fetchBrands() {
                let _this = this;
                axios.get('/admin/category/fetch/brand').then(res => {
                    _this.brands = res.data;
                });
            },
        },
        mounted: function () {
            this.fetchBrands()
        },
        updated: function () {
            for (var i = 0; i < this.brands.length; i++) {
                $(`#brand-id${this.brands[i].id}`).removeClass("brand-select");
            }

            for (var j = 0; j < this.holderBrandId.length; j++) {
                $(`#brand-id${this.holderBrandId[j]}`).addClass("brand-select");
            }
        }
    }
</script>

<style scoped>

</style>