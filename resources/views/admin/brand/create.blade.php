@extends('layouts.admin.admin')
@section('content')
    <brands-main></brands-main>
@endsection
@section('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#side_brand").addClass("menu-open");
        $("#side_brand_add").addClass("active");
    </script>
@endsection
@section('style')

    <style>
        .multiselect-container {
            direction: ltr !important;
            width: 100% !important;
        }

        .multiselect-container label {
            display: block !important;
            text-align: right !important;
            color: #717171 !important;
            margin-top: 5px !important;

        }

        .multiselect {
            width: 100% !important;
            text-align: right !important;
            background-color: white;
            min-height: 26px !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .btn-group {
            width: 100% !important;
        }
    </style>
    <style>
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
    </style>
    <style>
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
        }

        #angle-down {
            float: left;
            margin: 6px 2px;
            color: #636363;
        }

        #sss {
            position: absolute;
            list-style: none;
            top: 74px;
            z-index: 99;
            background-color: white;
            padding: 5px 15px;
            width: 100%;
            line-height: 35px;
            box-shadow: 0px 10px 21px 0px rgba(0, 0, 0, 0.75);
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

        label {
            font-weight: unset !important;
        }

        button:focus {
            outline: rgba(122, 186, 255, 0.68) solid 2px !important;
        }
    </style>
@endsection
