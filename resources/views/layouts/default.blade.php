<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>One Stop Solution Data Management</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/dropzone/min/dropzone.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
   <!-- Bootstrap Color Picker -->
   <link rel="stylesheet" href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- fullCalendar -->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/fullcalendar/main.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  
  <!-- summernote -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ URL::asset('assets/dist/img/AdminLTELogo.png') }}" alt="OSS" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('layouts.topnav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 
  @include('layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{$title}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{$title}}</a></li>
              <li class="breadcrumb-item active">{{$content}}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- /.content -->
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024-{{now()->format('Y')}}</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ URL::asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ URL::asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ URL::asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- BS-Stepper -->
<script src="{{ URL::asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<!-- dropzonejs -->
<script src="{{ URL::asset('assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ URL::asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ URL::asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/dist/js/adminlte.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fullcalendar/main.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset('assets/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ URL::asset('assets/dist/js/pages/dashboard.js') }}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"> -->
@yield('pagespecificscripts')
<script>
  
  $('#enable_disable').on('switchChange.bootstrapSwitch', function (event, state) {
    if($("#enable_disable").is(':checked')) {
    $(this).val('0');
    } else {
      $(this).val('1');
    }
  });
  
  
    $(document).ready(function () {
      var i=0;
      $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      
      })
      var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');
    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
            $('#country').on('change', function () {
                var idCountry = this.value;
                $("#state").html('');
                $.ajax({
                    url: "{{route('fetchState')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function (key, value) {
                            $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('#city').html('<option value="">-- Select City --</option>');
                    }
                });
            });
            /*------------------------------------------
            State Dropdown Change Event
            --------------------------------------------*/
            $('#state').on('change', function () {
                var idState = this.value;
                $("#city").html('');
                $.ajax({
                    url: "{{route('fetchCity')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    $('#birth_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    
      
    $('body').on('focus',".child_dob", function(){
    $(this).datetimepicker({
      format: 'yyyy-MM-DD',
    });
});
    
   
    $('#policy_start_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    $('#ppt_end_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    $('#policy_end_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    
    $('#spouse_dob').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    $('#purchase_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    $('#anniversary_date').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    $('#nominee_dob').datetimepicker({
        format: 'yyyy-MM-DD',
    });
  $('#rolesTable').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
  });
  </script>

</body>
</html>
