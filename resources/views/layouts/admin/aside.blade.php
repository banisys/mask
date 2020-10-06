<aside class="main-sidebar" style="background-color: #343a40">
    <div class="sidebar" style="direction: ltr;height: 100vh;padding-left: 0">
        <div style="direction: rtl">
            <br>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" id="ul-side-bar"
                    data-accordion="false">

                    <li class="nav-item has-treeview">
                        <a href="{{url('/admin/dashboard')}}" class="nav-link" id="side_dashboard">
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>

                    <li id="side_category" class="nav-item has-treeview">
                        <a href="#" class="nav-link ">
                            <p>
                                دسته بندی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a id="side_category_add" href="{{ url('/admin/category/create') }}"
                                   class="nav-link">
                                    <p>مدیریت دسته ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview" id="side_brand">
                        <a href="#" class="nav-link">
                            <p>
                                برند ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item inner">
                                <a href="{{ url('/admin/brand/create') }}" class="nav-link" id="side_brand_add">

                                    <p>مدیریت برندها</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="side_product" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <p>
                                محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/product/index') }}" class="nav-link"
                                   id="side_product_index">
                                    <p>لیست</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/product/create') }}" class="nav-link"
                                   id="side_product_add">

                                    <p>افزودن</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="side_exist" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <p>
                                موجودی محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/exist/index') }}" class="nav-link"
                                   id="side_exist_index">
                                    <p>لیست</p>
                                </a>
                            </li>
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/exist/product/code') }}" class="nav-link" id="side_exist_product_code">
                                    <p>کد محصول</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link ">
                            <p>
                                سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item inner">
                                <a href="{{ url('/admin/order/index') }}" class="nav-link ">
                                    <p>لیست</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</aside>
