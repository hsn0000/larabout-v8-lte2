<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('themes/img/AdminLTELogo.png') }}" rel="shortcut icon">

        <title>{!! isset($page_tittle) ? trim(strip_tags($page_tittle)).' ~ ' : null !!}{{ $site_name ?? env('APP_NAME') }}</title>

        <script type="application/javascript">
            const base_url = '{{ config('app.url') }}';
            const csrf_token = '{{ csrf_token() }}';
            const storage_url = '{{ config('app.storage_url') }}';
        </script>

        {{-- <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script> --}}

        <link rel="stylesheet" href="{{ asset('themes/css/app.css') }}">

        @yield('custom_css')
    </head>
    <body class="hold-transition fixed skin-blue">
        <div class="page-loader">
            <div class="loader-container">
                @include('layouts.loading')
            </div>
        </div>
        <!-- Site wrapper -->
        <div class="wrapper">

            @include('layouts.header')

            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{!! isset($mod_alias) ? modules()->generate_title($mod_alias,icon:false) : null !!}</h1>
                    {!! isset($mod_alias) ? modules()->generate_breadcrumb($mod_alias) : null !!}
                </section>

                <!-- Main content -->
                <section class="content">

                    {!! General()->flash_message() !!}

                    @yield('content')

                </section>
                <!-- /.content -->
            </div>

            <!-- /.content-wrapper -->

            @include('layouts.footer')
        </div>
        <!-- ./wrapper -->

        <div class="modal fade" id="auto-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer" style="display: none;">
                        <button type="button" class="btn btn-default" id="modal-btn-close" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="modal-btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('themes/js/app.js') }}"></script>
        @yield('custom_js')
    </body>
</html>
