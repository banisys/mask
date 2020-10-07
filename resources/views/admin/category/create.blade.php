@extends('layouts.admin.admin')
@section('content')
    <categories-main></categories-main>
@endsection

@section('script')
    <script>
        $("#side_category").addClass("menu-open");
        $("#side_category_add").addClass("active");
    </script>
@endsection

@section('style')
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

        label {
            font-weight: unset !important;
        }

        button:focus {
            outline: rgba(122, 186, 255, 0.68) solid 2px !important;
        }

        body {
            height: 100vh !important;
        }
    </style>
@endsection
