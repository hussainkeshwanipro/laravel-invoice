@extends('layouts.master')

@section('title')
Welcome User
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="content-header">
        <div class="container-fluid">
            @if(Session::has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoices Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">
                            <a href="{{ route('addInvoice') }}" class="btn btn-success">Add
                                Invoice</a>


                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Address</th>
                                        <th>Delivery Address</th>
                                        <th>Invoice No. (Unique)</th>
                                        <th>Invoice Items
                                        <th>Action</th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    

                                    @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>{{ $key->date }}</td>
                                        <td>{{ $key->invoice_address }}</td>
                                        <td>{{ $key->delivery_address }}</td>
                                        <td>{{ $key->invoice_number }}</td>
                                        <td>

                                            @foreach($key->item as $item)
                                            <li>Id: {{ $item->id}}</li>
                                            <li>Description: {{ $item->description }}</li>
                                            <li>Cost: {{ $item->cost }}</li>
                                            <li>Qty. : {{ $item->qty }}</li>
                                            <li>Total: {{ $item->cost * $item->qty }}</li>
                                            <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="invoice/delete/{{ $key->id }}" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-trash" aria-hidden="true"></i></a>

                                            <a href="invoice/edit/{{ $key->id }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>

                                            <a href="invoice/pdf/{{ $key->id }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-file-pdf"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection

@section('js')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
</script>


@endsection