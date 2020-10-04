<template>
    <div>
        <div v-show="flag1" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 px-0 pb-3 a-main-container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center py-2 a-h3">ورود / ثبت‌نام</h3>
                            <p class="text-center my-4 a-paragraph mx-3">برای ورود و یا ثبت‌نام در سایت شماره موبایل خود
                                را
                                وارد
                                نمایید تا کد تاییدی برای شما پیامک
                                شود</p>

                            <input class="text-center col-11 form-control mx-auto a-input" v-model="mobile" type="text"
                                   autofocus>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <span class="a-error">{{ error }}</span>
                        </div>
                        <div class="col-md-4 text-left">
                            <button class="btn btn-sm ml-4 a-btn" @click="getCode($event)">بعدی</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>

        <div v-show="flag2" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 px-0 pb-3 a-main-container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center py-2 a-h3">کد تایید ثبت‌نام</h3>
                            <p class="text-center my-4 a-paragraph mx-3">
                                کاربر با موفقیت ایجاد شد. لطفا کد پیامک شده برای شماره {{ mobile }} را وارد نمایید.
                            </p>

                            <input class="text-center col-11 form-control mx-auto a-input" v-model="code" type="text">

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button class="btn btn-sm ml-4 a-btn a-btn2" @click="back()">قبلی</button>
                        </div>
                        <div class="col-md-6 text-left">
                            <button class="btn btn-sm ml-4 a-btn-back" @click="login($event)">بعدی</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mobile: '',
                code: '',
                flag1: true,
                flag2: false,
                error: '',
            }
        },
        methods: {
            getCode(e) {
                e.preventDefault()
                let _this = this

                if (this.mobile.length !== 11) {
                    this.error = 'شماره همراه را به صورت صحیح وارد کنید'
                    return false
                }

                axios.post('/login/send/code', {
                    mobile: this.mobile,
                }).then(function (res) {
                    console.log(res.data)
                    // window.location.href = '/'
                    _this.flag1 = false
                    _this.flag2 = true
                    _this.error = ''
                }).catch(function (error) {

                })
            },
            login(e) {
                e.preventDefault()
                let _this = this
                axios.post('/login/check/code', {
                    code: this.code,
                    mobile: this.mobile,
                }).then(function (res) {
                    console.log(res.data)
                    // window.location.href = '/'
                }).catch(function (error) {

                })
            },
            back() {
                this.flag1 = true
                this.flag2 = false
            },
        },
        mounted() {

        }
    }
</script>

<style scoped>
    * {
        direction: rtl;
        text-align: right
    }

    .a-paragraph {
        font-size: 15px;
        color: #adadad;
    }

    .a-h3 {
        background: #e2e2e2;
    }

    .a-main-container {
        border: 1px solid #d4d4d4;
        border-radius: 4px;
    }

    .a-btn {
        color: gray;
        border: 1px solid #d6d6d6;
    }

    .a-btn2 {
        margin-right: 25px;
    }

    .a-input {
        border: 1px solid #aaaaaa;
        direction: ltr;
    }

    .a-error {
        font-size: 13px;
        margin-right: 15px;
        color: #dc3545;
    }
</style>