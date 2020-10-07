<template>
    <div>
        <button @click="clickCatBtn" id="btn-cat">
            {{ form.name }}
            <i class="right fa fa-angle-down" id="angle-down"></i>
        </button>
        <div v-if="flag" id="sss">
            <ul v-if="flag1">
                <li style="color: black;font-weight: bold;background-color: #f1f1f1;padding-right: 6px;border-radius: 6px"
                    @click="fixRoot()">
                    ریشه
                </li>
                <li style="line-height: 35px;" @click="fetchChild(root.id,root.name)"
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
                <li style="color: black;font-weight: bold;background-color: #f1f1f1;padding-right: 6px;border-radius: 6px"
                    @click="fixCat()">{{ holder.selfName }}
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
                    name: 'انتخاب کنید...',
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
                search: {
                    name: '',
                },
                categories2: [],
                parents: '',
                parentname: [],
                parpar: [],
                data_results: [],
                cats: [],
                catHolder: '',
            }
        },
        methods: {
            fetchCategories() {
                let data = this;
                axios.get('/admin/category/fetch')
                    .then(res => {
                        data.categories = res.data;
                    });
            },
            clickCatBtn() {
                if (this.flag === false) {
                    this.flag = true;
                } else if (this.flag === true) {
                    this.flag = false
                }
            },
            fetchRootCat(type) {
                let data = this;
                axios.get(`/admin/category/fetch/cat/root/${type}`).then(res => {
                    data.roots = res.data;
                });
                this.holder.parentName = 'ریشه';
                this.holder.parentId = '';
                this.holder.grandName = 'ریشه';
                this.holder.grandId = '';
            },
            fetchChild(id, name) {
                let data = this;
                let type = 'محصول';

                data.holder.grandName = data.holder.parentName;
                data.holder.grandId = data.holder.parentId;

                data.holder.parentName = data.holder.selfName;
                data.holder.parentId = data.holder.selfId;

                data.holder.selfName = name;
                data.holder.selfId = id;
                axios.get(`/admin/category/fetch/cat/child/${id}/${type}`).then(res => {
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
            fixCat() {
                this.form.name = this.holder.selfName;
                this.flag = false;
                this.$emit('fixCat', this.holder.selfName)
            },
            fixRoot() {
                this.form.name = 'ریشه'
                this.flag = false
                this.$emit('fixCat', 'ریشه')
            },
            searchName() {
                let data = this;
                if (this.search.name.length > 0) {
                    axios.get('/admin/category/search', {params: {name: this.search.name}}).then(response => {
                        data.categories2 = response.data;
                    });
                }
                if (this.search.name.length === 0) {
                    this.fetchCategories2();
                }
            },
        },
        mounted: function () {
            this.fetchRootCat('محصول');
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
</style>