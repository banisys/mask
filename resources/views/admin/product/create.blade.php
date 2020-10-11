@extends('layouts.admin.admin')
@section('content')
<product-create-main></product-create-main>
@endsection

@section('script')
    <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js')}}"></script>
    <script>
        CKEDITOR.replace('editor1', {
            customConfig: "{{ asset('/js/ckeditor/config.js')}}",
            height: 500
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(300);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#side_product").addClass("menu-open");
        $("#side_product_add").addClass("active");
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css" type="text/css"/>
    <style>
        .bootstrap-tagsinput .tag {
            border-radius: 5px;
            padding: 1px 8px;
        }

        .bootstrap-tagsinput {
            width: 100%;

            padding-top: 9px;
        }

        .yy .active {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
            color: #101010 !important;
            background-color: #ffffff !important;
            font-weight: bold;
        }

        .nav-pills .nav-link {
            color: #c2c7d0;
        }

        #cke_editor1, #cke_editor2 {
            width: 99%
        }

    </style>
    <style>
        .del {
            color: rgb(220, 53, 69);
            position: absolute !important;
            left: 3px !important;
            bottom: 4px !important;
            font-size: 23px !important;
        }

        .uploader {
            width: 100%;
            background: #ffffff;
            color: #a8a8a8;
            padding: 40px 15px;
            text-align: center;
            border-radius: 15px;
            border: 3px dashed #a8a8a8;
            font-size: 20px;
            position: relative;
        }

        .uploader.dragging {
            background: #fff;
            color: #cecece;
            border: 3px dashed #cecece;
        }

        .uploader.dragging .file-input label {
            background: #a8a8a8;
            color: #545454;
        }

        .uploader i {
            font-size: 85px;
        }

        .uploader .file-input {
            width: 200px;
            margin: auto;
            height: 68px;
            position: relative;
        }

        .uploader .file-input label, .uploader .file-input input {
            background: #a8a8a8;
            color: #ffffff;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 7px;
            cursor: pointer;
        }

        .uploader .file-input input {
            opacity: 0;
            z-index: -2;
        }

        .uploader .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .uploader .images-preview .img-wrapper {
            width: 160px;
            display: flex;
            flex-direction: column;
            margin: 10px;
            height: 150px;
            justify-content: space-between;
            background: #fff;
            box-shadow: 5px 5px 20px #3e3737;
        }

        .uploader .images-preview .img-wrapper img {
            max-height: 105px;
        }

        .uploader .images-preview .details {
            font-size: 12px;
            background: #fff;
            color: #000;
            display: flex;
            flex-direction: column;
            align-items: self-start;
            padding: 3px 6px;
        }

        .uploader .images-preview .details .name {
            overflow: hidden;
            height: 18px;
        }

        .uploader .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;
        }

        .uploader .upload-control button, .uploader .upload-control label {
            background: #cecece;
            border: 2px solid #cecece;
            border-radius: 3px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .uploader .upload-control label {
            padding: 2px 5px;
            margin-right: 10px;
        }

        .nav-pills .nav-link:not(.active):hover {
            color: #ffffff !important;
        }
    </style>

    <style>
        li {
            list-style: none
        }

        #btn-cat {
            position: relative;
            background-color: white;
            border: 1px solid #dee2e6;
            width: 100%;
            padding: 8px 8px 0 8px;
            border-radius: 7px;
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
            top: 71px;
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

    </style>
@endsection

