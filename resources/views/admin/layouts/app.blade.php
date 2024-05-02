<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.links')
    @include('admin.partials.head')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.inc.nav')

        <!-- Main Sidebar Container -->
        @include('admin.inc.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 ">
                            @yield('title')
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid" id="container-fluid">
                    @yield('content')
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('admin.inc.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @stack('js')
    <!-- jQuery -->
    @include('admin.layouts.js')
    {{-- <script>
        document.getElementById("side_instances").addEventListener("click", function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/instances", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("container-fluid").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    </script> --}}

</body>

</html>
