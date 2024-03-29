<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="/layout/style.css">
    <script src="{{ asset('/js/app.js')}}"></script>

</head>
<body>
<form method="POST" action="{{ url('/register/store') }}" ref="register" id="area">
    @csrf
    <section class="logIn2 px-0 container-fluid d-lg-flex justify-content-lg-center align-items-lg-center flex-wrap">
        <div class="col-12 col-lg-8 logIn-container d-flex flex-row flex-wrap justify-content-center px-0">
            <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center logIn-image">
                <img class="col-10 px-0" src="/dress/images/login.svg">
            </div>
            <div class="col-12 col-lg-6 logIn-form px-5 px-lg-3 pt-0 pb-5 py-lg-0">
                <div class="login-logo col-4 col-lg-3  mt-3 px-0 " style="height: fit-content">
                    <img src="../images/logo.jpg" alt="" class="col-12 pl-0">
                </div>
                <div class="col-12 px-5 px-lg-6 log-in-form-log d-flex flex-row-reverse flex-wrap">

                    <div class="col-12 text-right login-title pr-0 mt-4">
                        <h2>ثبت نام</h2>
                    </div>
                    <div class="col-12  px-0 pl-lg-3 mt-5" style="direction: rtl">
                        <span style="color: red"> @{{ error.mobile }} </span>
                        <input v-model="register.mobile" name="mobile"
                               class="col-12 mt-2 mt-lg-0 px-0 " id="log-in-email" type="text"
                               placeholder="شماره همراه">
                        <label for="log-in-email">شماره همراه</label>
                    </div>
                    <div class="col-12 px-0 pl-lg-3 mt-5" style="direction: rtl">
                        <span style="color: red"> @{{ error.password }} </span>
                        <input v-model="register.password" name="password"
                               class="col-12 px-0" id="log-in-pass" type="password" placeholder="کلمه عبور">
                        <label for="log-in-pass">کلمه عبور</label>
                    </div>
                    <div class="col-12 px-0 pl-lg-3 mt-5" style="direction: rtl">
                        <span style="color: red"> @{{ error.password_confirmation }} </span>
                        <input v-model="register.password_confirmation" name="password_confirmation"
                               class="col-12 px-0" id="log-in-pass2" type="password" placeholder="تکرار کلمه عبور">
                        <label for="log-in-pass2">تکرار کلمه عبور</label>
                    </div>
                    <div class="col-10 col-lg-9  px-0 px-lg-3 mt-5 mt-lg-4">
                        <button class="py-1 col-10 px-5 mx-auto d-block" @click.stop.prevent="registerValidation">ثبت نام
                        </button>
                        <p class="mobile-login-register-txt mt-4 col-10 mx-auto ">قبلا عضو شده اید ؟؟</p>
                        <a style="background-color: #d73b6a;color: white;border: none;border-radius: 5px;padding: 7px 20px !important;transition: 0.2s;text-align: center;"
                           href="{{ url('/login') }}" class="py-1 col-10 px-5 mx-auto d-block mobile-login-register">ورود</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</form>
<script>
    new Vue({
        el: '#area',
        data: {
            register: {
                mobile: '',
                password: '',
                password_confirmation: '',
            },
            login: {
                mobile: "",
                password: '',
            },
            error: {
                mobile: '',
                password: '',
            },
            error_register: [],
            error_login: [],
        },
        methods: {
            registerValidation(e) {
                e.preventDefault();
                let _this = this;
                axios.post('/validation/register', {
                    mobile: this.register.mobile,
                    password: this.register.password,
                    password_confirmation: this.register.password_confirmation,
                }).then(function (res) {
                    _this.$refs.register.submit();
                }).catch(function (error) {
                    _this.error.mobile = "";
                    _this.error.password = "";
                    _this.error.password_confirmation = "";

                    _this.error_register = error.response.data.errors;

                    x = error.response.data.errors;

                    if (Array.isArray(x.mobile)) {
                        _this.error.mobile = _this.error_register.mobile[0];
                    }
                    if (Array.isArray(x.password)) {
                        _this.error.password = _this.error_register.password[0];
                    }
                });
            },
            loginValidation(e) {
                e.preventDefault();
                let _this = this;
                axios.post('/validation/login', {
                    mobile: this.login.mobile,
                    password: this.login.password,
                }).then(function (res) {
                    if (res.data.error === 'not match') {
                        _this.error.mobile = "شماره همراه یا پسورد همخوانی ندارد.";
                    } else {
                        window.location.href = "/panel/account";
                    }
                }).catch(function (error) {
                    _this.error.mobile = "";
                    _this.error.password = "";

                    _this.error_login = error.response.data.errors;

                    x = error.response.data.errors;

                    if (Array.isArray(x.mobile)) {
                        _this.error.mobile = _this.error_login.mobile[0];
                    }
                    if (Array.isArray(x.password)) {
                        _this.error.password = _this.error_login.password[0];
                    }
                });
            },
        },
        mounted: function () {
        }
    });
</script>
</body>
</html>
