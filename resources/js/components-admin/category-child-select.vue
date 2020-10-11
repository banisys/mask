<template>
    <div>
        <button @click="clickCatBtn" id="btn-cat">
            {{ form.catName }}
            <i class="right fa fa-angle-down" id="angle-down"></i>
        </button>
        <div v-if="flag" id="sss">
            <ul v-if="flag1">
                <li style="line-height: 35px;"
                    @click="fetchChild(root.id,root.name)"
                    v-for="(root,index) in roots">
                    {{ root.name }}
                    <i id="angle-left" class="right fa fa-angle-left"></i>
                </li>
            </ul>
            <ul v-if="flag2">
                <li style="color: #a0a0a0" @click="back(holder.parentName)">
                    <i class="right fa fa-angle-right"
                       style="float: right;margin:11px 0 0 5px;"></i>
                    {{ holder.parentName }}
                </li>
                <li v-if="!childs.length" style="margin-top: 10px;"
                    @click="fixCat()">
                    <span
                                                                    style="border-radius: 46px;color: white;margin-right: 15px;padding: 4px 13px;background-color: #007ac8;">
                                                                 {{ holder.selfName }}
                    </span>

                </li>
                <li v-for="(child,index) in childs"
                    @click="fetchChild(child.id,child.name)"
                    style="margin-right: 10px;">
                    {{ child.name }}
                    <i id="angle-left" v-if="child.children_recursive.length"
                       class="right fa fa-angle-left"></i>
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
                    name: '',
                    discount: 0,
                    price: '',
                    roles: '',
                    image: '',
                    brand: '',
                    catName: 'انتخاب کنید...',
                    cat: '',
                    status: '',
                    seo_title: '',
                    seo_key: '',
                    seo_description: '',
                    afterDiscount: '',
                    code: '',
                },
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
            clickCatBtn() {
                if (this.flag === false) {
                    this.flag = true;
                } else if (this.flag === true) {
                    this.flag = false
                }
            },
            fetchRootCat() {
                let data = this;
                axios.get(`/admin/brand/fetch/cat/root`).then(res => {
                    data.roots = res.data;
                });
                this.holder.parentName = 'ریشه';
                this.holder.parentId = '';
                this.holder.grandName = 'ریشه';
                this.holder.grandId = '';
            },
            fetchChild(id, name) {
                let data = this;

                this.holder.grandName = this.holder.parentName;
                this.holder.grandId = this.holder.parentId;

                this.holder.parentName = this.holder.selfName;
                this.holder.parentId = this.holder.selfId;

                this.holder.selfName = name;
                this.holder.selfId = id;
                axios.get(`/admin/brand/fetch/cat/child/${id}`).then(res => {
                    data.childs = res.data;
                    data.flag1 = false;
                    data.flag2 = true;
                });
            },
            back(parent) {
                let data = this;
                if (parent === 'ریشه') {
                    this.flag1 = true;
                    this.flag2 = false;
                    this.holder.selfName = 'ریشه';
                    this.holder.selfId = '';
                    this.holder.parentName = '';
                    this.holder.parentId = '';
                    this.holder.grandName = '';
                    this.holder.grandId = '';
                    axios.get('/admin/category/fetch/cat/root').then(res => {
                        data.roots = res.data;
                    });
                } else {
                    axios.get(`/admin/category/fetch/cat/child/select/${this.holder.parentId}`).then(res => {
                        data.childs = res.data;
                        data.holder.selfName = data.holder.parentName;
                        data.holder.selfId = data.holder.parentId;
                        data.holder.parentName = data.holder.grandName;
                        data.holder.parentId = data.holder.grandId;
                    });
                }
            },
            async fixCat() {
                let _this = this;
                this.form.catName = this.holder.selfName;
                this.flag = false;
                await axios.get(`/admin/product/fetch/cat/id/${this.holder.selfName}`).then(res => {
                    _this.$emit('fixCat',res.data)
                });
            },
        },
        mounted: function () {
            this.fetchRootCat();
        },
        updated: function () {
            if (this.holder.parentName === this.holder.selfName) {
                this.holder.parentName = 'ریشه'
                this.holder.parentId = ''
                this.holder.grandName = 'ریشه'
                this.holder.grandId = ''
            }
        }
    }
</script>

<style scoped>

</style>