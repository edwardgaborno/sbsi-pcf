<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="HandheldFriendly" content="true" >
        <meta name="MobileOptimized" content="width">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>@yield('title')</title>
        <meta name="description" content="Scientific Biotech Specialties Web Laboratory Information System" />
        <link rel="icon" href="{{ asset('img/sbsi-32px-favicon-1.png') }}">
        <link href="{{ asset('dist/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('dist/dropify/css/dropify.min.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    </head>
    <body id="page-top">

        @include('sweetalert::alert')

        @yield('content')
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('dist/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        @stack('scripts')
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('dist/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

        <!-- sbsi js -->
        <script src="{{ asset('js/sbsi.js') }}"></script>

        <!-- Sweet alert 2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- dropify -->
        <script src="{{ asset('dist/dropify/js/dropify.min.js') }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset('dist/chart.js/Chart.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
        @yield('scripts')
    </body>
</html>
