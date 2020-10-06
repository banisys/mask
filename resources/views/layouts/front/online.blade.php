<!DOCTYPE html>
<html class="no-js" lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>فروشگاه 19 آنلاین</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/online/assets/img/favicon.ico')}}">
    <meta name="theme-color" content="#c40316">

    <script src="{{ asset('/js/online/app.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/online/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('/online/assets/css/style.css')}}">
    <style>
        .categories_menu_toggle ul li ul.categories_mega_menu > li:first-child {
            padding-right: 15px !important;
        }
    </style>
    @yield('style')
</head>

<body>

<header id="header" style="position: relative">


    <div @click="flagMega=!flagMega" v-show="flagMega"
         style="width: 100%;height: 100vh;background-color: white;opacity:0.2;position: absolute;top: 0px;left: 0;z-index:998"></div>
    <div @click="flagMega=!flagMega" v-show="flagMega"
         style="width: 100%;height: 100vh;background-color: black;opacity: .5;position: absolute;top: 162px;left: 0;z-index:998"></div>
    <div v-show="flagMega" id="megaContainer"
         style="position: absolute;top: 150px;width: 100%;z-index: 999;padding: 12px 10px;">
        <div class="container"
             style="background-color: white;border-bottom-right-radius: 6px;border-bottom-left-radius: 6px;padding-top:20px;border: 2px solid #c40316;">
            <div class="row">

                <div class="col-2">
                    <ul class="nav nav-tabs flex-column" id="myTab" role="tablist"
                        style="background-color: #f6f6f6;height: min-content;border-left: 1px solid #dedede;">
                        <li class="nav-item" v-for="(megaCat,index) in megaCats" style="padding-bottom:5px;">
                            <a class="nav-link mega-cat-item" data-toggle="tab" :href="'#mega'+megaCat.id" role="tab"
                               @mouseover="hoverMegaCat(megaCat.id)"
                               :aria-controls="'#mega'+megaCat.id" :id="'mega-cat'+megaCat.id">
                                <img v-if="megaCat.image"
                                     :src="'/images/mega/'+megaCat.image"
                                     style="width:19px;margin-left:5px;">
                                @{{ megaCat.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-10" style="padding: 0 15px;" @mouseover="hoverMegaContainer()">
                    <div class="tab-content" style="margin: unset">
                        <div class="tab-pane" v-for="(megaCat,index,key) in megaCats"
                             :class="activeFirstMega(index)"
                             :id="'mega'+megaCat.id"
                             role="tabpanel">
                            <ul>
                                <li class="col-3 px-0 float-left maga-item" v-for="item in megas[megaCat.id]"
                                    @click="selectResult(item.name,item.type)"
                                    style="list-style: none;margin-bottom: 10px;font-size:13px;cursor: pointer;">
                                    @{{ item.title }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="main_header">
        <div class="container">
            <div class="header_middle sticky-header">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-6">
                        <div class="logo">
                            <a href="{{url('/')}}"><img src="/online/assets/img/logo/logo.png"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">

                        <div class="search_container">
                            <form action="#">
                                <div class="search_box">

                                    <input @keyup="autoComplete"
                                           v-model="searchquery"
                                           placeholder="جستجوی محصول ..." type="text">
                                    <i class="fa fa-search"
                                       style="position: absolute;top: 12px;left: 11px;font-size: 26px;color: #222222;"></i>
                                    <i class="ion-ios-close-empty"
                                       v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                       @click="searchClose"
                                       style="position: absolute;left:136px;top: 1px;font-size: 30px;cursor: pointer;padding: 10px"></i>
                                    <div
                                        v-if="data_results.product.length || data_results.category.length || data_results.brand.length"
                                        style="position: absolute;width: 100%;z-index: 100;top: 52px;">
                                        <ul class="list-group down-select">
                                            <li class="list-group-item" v-for="(result,index) in data_results.product"
                                                @click="selectResult(result.name,'product')"
                                                style="text-align: right;cursor: pointer">
                                                <span class="auto_search">محصول</span>
                                                <span class="auto_search2">@{{ result.name }}</span>
                                            </li>
                                            <li class="list-group-item" v-for="(result,index) in data_results.category"
                                                @click="selectResult(result.name,'cat')"
                                                style="text-align: right;cursor: pointer">
                                                <span class="auto_search">دسته ها</span>
                                                <span class="auto_search2">@{{ result.name }}</span>
                                            </li>
                                            <li class="list-group-item" v-for="(result,index) in data_results.brand"
                                                @click="selectResult(result.name,'brand')"
                                                style="text-align: right;cursor: pointer">
                                                <span class="auto_search">برند</span>
                                                <span class="auto_search2">@{{ result.name }}</span>
                                                <span style="margin-right:50px;font-size: 14px;color: #b9b9b9;">@{{ result.name_f }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div @click="searchClose" v-if="flag"
                                         style="background-color: black;opacity:.3;position: fixed;width: 100%;height: 100%;top: 82px;left: 0;z-index:9"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="header_configure_area" style="justify-content: center;">
                            <div style="margin-left: 40px;margin-top: 7px;">
                                <ul class="header_list border_list list_none header_dropdown text-center text-md-right ml-3"
                                    style="text-align: initial;border: 1px solid #d7d7d7;display: inline-block;padding: 4px 10px;border-radius:4px;padding-left: 5px">
                                    @auth
                                        <i class="fa fa-user"
                                           style="margin-left: 5px;color: #222222;font-size: 25px"></i>
                                        <li class="dropdown mx-1" style="padding-left: 0;display: inline-block">
                                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">پروفایل
                                                کاربری</a>
                                            <div class="dropdown-menu shadow dropdown-menu-right">
                                                <ul style="text-align: initial;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{url('/panel/account')}}">پروفایل
                                                            کاربری</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('/favourites')}}">لیست
                                                            علاقه مندی</a>
                                                    </li>
                                                    <li><a class="dropdown-item">
                                                            <form method="POST" action="{{ route('logout') }}">
                                                                @csrf
                                                                <button
                                                                    style="background-color: unset;border: unset;color: #dc3545;font-size:16px;margin-top:4px"
                                                                    type="submit">
                                                                    خروج
                                                                </button>
                                                            </form>
                                                        </a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    @else

                                        <div>
                                            <i class="fa fa-user"
                                               style="margin-left: 5px;color:#222222;font-size: 25px;"></i>
                                            <a href="{{ route('login') }}" class="mr-2"
                                               style="color:#222222;font-size: 13px;">ورود</a>
                                            <span style="color: #545454;font-size: 13px;">/</span>
                                            <a href="{{ route('login') }}" class="ml-2"
                                               style="color:#222222;font-size: 13px;padding-left: 5px">ثبت
                                                نام</a>
                                        </div>
                                    @endauth
                                </ul>
                            </div>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span class="cart_price">
                                        <i class="ion-ios-arrow-down"></i>
                                    </span>
                                    <span class="cart_count">@{{ countCart }}</span>

                                </a>

                                <div class="mini_cart" v-if="carts.length">
                                    <div class="mini_cart_inner">
                                        <template v-for="(cart, name, index) in carts">
                                            <div class="cart_item">
                                                <div class="cart_img">
                                                    <a href="#">
                                                        <img :src="'/images/product/'+cart.product.image">
                                                    </a>
                                                </div>
                                                <div class="cart_info">
                                                    <a href="#">@{{ cart.product.name }}</a>
                                                    <p>
                                                        <span> @{{ numberFormat(cart.price*cart.number) }} تومان </span>
                                                        <span style="color: grey">  - تعداد : @{{ cart.number }} </span>
                                                    </p>
                                                </div>
                                                <div class="cart_remove">
                                                    <a @click="deleteCart(cart.id)">
                                                        <i class="ion-android-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="mini_cart_table">
                                        <div class="cart_total mt-10">
                                            <span>جمع کل:</span>
                                            <span class="price">@{{ numberFormat(totalCart) }} تومان</span>
                                        </div>
                                    </div>
                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="{{url('/cart')}}">مشاهده سبد</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="mini_cart" v-else>
                                    <p class="my-3" style="text-align: center;">سبد خرید خود را تشکیل دهید</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header_bottom">
                <div class="row align-items-center">
                    <div class="column1 col-lg-3 col-md-6">
                        <div class="categories_menu categories_three">
                            <div class="categories_title">
                                <h2 class="categori_toggle">دسته بندی کالا ها</h2>
                            </div>
                            <div class="categories_menu_toggle">
                                <ul>
                                    <template v-for="(root,index) in roots">
                                        <li class="menu_item_children"><a href="#">@{{ root.name }}<i
                                                    class="fa fa-angle-left"></i></a>
                                            <ul class="categories_mega_menu d-flex flex-column bd-highlight py-0" style="width: 100%;    border: 1px solid #d2d2d2;">
                                                <template v-for="(cat,index) in root.children_recursive">
                                                    <li class="menu_item_children bd-highlight py-2"
                                                        @click="selectResult(cat.name,'cat')"
                                                        style="width: 100%;cursor: pointer">
                                                        @{{ cat.name }}
                                                    </li>
                                                </template>
                                            </ul>
                                        </li>
                                    </template>

                                </ul>
                            </div>


                        </div>
                    </div>
                    <div class="column2 col-lg-6 ">
                        <div class="main_menu menu_position">
                            <nav>
                                <ul>
                                    <li><a href="contact.html">صفحه اصلی</a></li>
                                    <li><a href="contact.html">وبلاگ</a></li>
                                    <li><a href="contact.html">نحوه ارسال</a></li>
                                    <li><a href="about.html">درباره ما</a></li>
                                    <li><a href="contact.html"> تماس با ما</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</header>


@yield('content')

<footer class="footer_widgets">
    <div class="footer_top pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-sm-7">
                    <div class="widgets_container contact_us">
                        <h3>دریافت برنامه</h3>
                        <div class="aff_content">
                            <p>برنامه <strong>آنتومی</strong> هم اکنون در گوگل پلی و اپل استور آماده دریافت است.</p>
                        </div>
                        <div class="app_img">
                            <figure class="app_img">
                                <a href="#"><img src="/online/assets/img/icon/icon-appstore.png" alt=""></a>
                            </figure>
                            <figure class="app_img">
                                <a href="#"><img src="/online/assets/img/icon/icon-googleplay.png" alt=""></a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="widgets_container widget_menu">
                        <h3>اطلاعات</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="about.html">درباره ما</a></li>
                                <li><a href="#">نحوه ارسال</a></li>
                                <li><a href="#">محصولات جدید</a></li>
                                <li><a href="#">محصولات برتر</a></li>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>حساب کاربری</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="cart.html">سبد خرید</a></li>
                                <li><a href="wishlist.html">علاقه‌مندی‌ها</a></li>
                                <li><a href="#">کاهش قیمت‌ها</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                                <li><a href="#">سفارشات بین المللی</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>خدمات مشتری</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">نقشه سایت</a></li>
                                <li><a href="my-account.html">حساب کاربری</a></li>
                                <li><a href="#">نحوه ارسال</a></li>
                                <li><a href="#">سابقه خرید</a></li>
                                <li><a href="wishlist.html">علاقه‌مندی‌ها</a></li>
                                <li><a href="#">ویژه ها</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-7 col-sm-12">
                    <div class="widgets_container">
                        <h3>اطلاعات تماس</h3>
                        <div class="footer_contact">
                            <div class="footer_contact_inner">
                                <div class="contact_icone">
                                    <img src="/online/assets/img/icon/icon-phone.png" alt="">
                                </div>
                                <div class="contact_text">
                                    <p>تلفن تماس 24 ساعته: <br> <strong class="ltr-text">(+98) 123 456 789</strong></p>
                                </div>
                            </div>
                            <p>تبریز، چهار راه آبرسان، فلکه دانشگاه، برج تجاری بلور، طبقه 456، واحد 45</p>
                        </div>

                        <div class="footer_social">
                            <ul>
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<script src="{{asset('/online/assets/js/plugins.js')}}"></script>
<script src="{{asset('/online/assets/js/main.js')}}"></script>
<script>
    var app = new Vue({
        el: '#header',
        data: {
            flag: false,
            products: {},
            searchquery: '',
            data_results: {
                product: {},
                category: {},
                brand: {},
            },
            focus: 0,
            carts: [],
            countCart: 0,
            totalCart: 0,
            flagMega: false,
            megaCats: [],
            megas: [],
            magaCatPrevHolder: '',
            magaCatHolder: '',
            roots: []
        },
        methods: {
            fetchRootCat() {
                let _this = this;
                axios.get(`/category/fetch/cat/root`).then(res => {
                    _this.roots = res.data;
                    console.log(_this.roots);
                });
            },
            searchClose() {
                this.flag = false;
                this.data_results.product = {};
                this.data_results.category = {};
                this.data_results.brand = {};
                this.searchquery = '';
            },
            hoverMegaCat(id) {
                $(`#mega-cat${this.magaCatPrevHolder}`).css({"color": "black"});
                this.magaCatPrevHolder = this.magaCatHolder;
                this.magaCatHolder = id;
            },
            hoverMegaContainer() {
                $(`#mega-cat${this.magaCatHolder}`).css({"color": "#c40316"});
            },
            activeFirstMega(index) {
                if (index === 0) {
                    return 'active show';
                }
            },
            autoComplete(event) {
                event.preventDefault();
                if (this.searchquery.length === 0) {
                    this.data_results.product = [];
                    this.data_results.category = [];
                    this.data_results.brand = [];
                    this.flag = false;
                    return false;
                }
                li_count = $('.down-select li').length;

                switch (event.keyCode) {
                    case 13:
                        name = $('.select_search .auto_search2').text();
                        cat = $('.select_search .auto_search').text();
                        if (cat === 'دسته ها') {
                            type = 'cat';
                        }
                        if (cat === 'محصول') {
                            type = 'product';
                        }
                        if (cat === 'برند') {
                            type = 'brand';

                        }
                        this.selectResult(name, type);
                        break;

                    case 38:
                        if (this.focus === 1) {
                            return false;
                        }
                        this.focus--;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        this.searchquery = $(`.down-select li:nth-child(${this.focus})`).text();

                        return false;

                    case 40:
                        if (this.focus === li_count) {
                            return false;
                        }
                        this.focus++;
                        $(`.down-select li`).removeClass("select_search");
                        $(`.down-select li:nth-child(${this.focus})`).addClass("select_search");
                        this.searchquery = $(`.down-select li:nth-child(${this.focus})`).text();
                        return false;
                    case 37:
                        return false;

                    case 39:
                        return false;

                }
                let data = this;
                if (this.searchquery.length > 2) {
                    this.flag = true;
                    axios.get('/autocomplete/search', {
                        params: {
                            searchquery: data.searchquery,
                        }
                    }).then(response => {
                        data.data_results.product = response.data.product;
                        data.data_results.category = response.data.category;
                        data.data_results.brand = response.data.brand;
                    });
                }
            },
            selectResult(name, type) {
                window.location.href = `/auto/search/${type}/${name}`;
            },
            showSearchBar() {
                this.flag = true;
                setTimeout(function () {
                    $("#search_input").select();
                }, 500);
            },
            closeSearchBar() {
                this.flag = false;
            },
            fetchCart() {
                let data = this;
                data.totalCart = 0;
                axios.get('/fetch/cart').then(res => {
                    data.carts = res.data;
                    data.countCart = res.data.length;
                    for (const [key, value] of Object.entries(res.data)) {
                        data.totalCart += value.total;
                    }
                });
            },
            numberFormat(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            deleteCart(id) {
                let data = this;
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
                        axios.get(`/cart/delete/${id}`).then(res => {
                            data.fetchCart();
                        });
                    }
                });
            },
            fetchMegaCats() {
                axios.get('/mega/cat/fetch').then(res => {
                    this.$data.megaCats = res.data;
                });

            },
            fetchMegas() {
                axios.get('/megas/fetch').then(res => {
                    this.$data.megas = res.data;
                });
            },
            megaDisplay() {
                this.flagMega = true;
            },
        },
        mounted: function () {
            this.fetchCart();
            this.fetchMegaCats();
            this.fetchMegas();
            this.fetchRootCat();
        }
    });
</script>
<script>
    setTimeout(function () {
        $('#megaContainer .nav-item a').hover(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    }, 1000);
</script>
@yield('script')
</body>
</html>
