@extends('layouts.master')

@section('title')
Welcome User
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Invoices Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">
                           
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
                            <h3 class="card-title">Invoice Form Add</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('postInvoice') }}"method="post">

                                <div class="modal-body">
                                    @csrf
                                        <div class="form-group">
                                            <label for="">Date:</label>
                                            <input type="date" name="date" id="date" class="form-control">
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Invoice Address:</label>
                                            <textarea name="invoice_address" id="invoice_address" class="form-control"
                                                placeholder="Enter Invoice Address"></textarea>
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Delivery Address:</label>
                                            <textarea name="delivery_address" id="delivery_address" class="form-control"
                                                placeholder="Enter Delivery Address"></textarea>
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Invoice Number:</label>
                                            <input type="text" name="invoice_number" id="invoice_number"
                                                class="form-control" placeholder="Enter Invoice Number">
                                        </div>
                            
                                        <div class="form-group">
                                        <label for="">Invoice Items:</label>
                                        <div id="item"></div>
                            
                                        <div name="add_name" id="add_name">
                                            <table class="table table-bordered table-hover" id="dynamic_field">
                                            <tr>
                                                <td><input type="text" name="desc[]" placeholder=" Desc" class="form-control name_list" /></td>
                                                <td><input type="number" name="cost[]" placeholder=" Cost" class="form-control name_email"/></td>
                                                <td><input type="number" name="qty[]" placeholder=" Qty" class="form-control name_email"/></td>
                                                <td><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
                                            </tr>
                                            </table>
                                        </div>
                                        
                                    </div>
                                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Add Invoice">
                            </div>
                            </form>
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
<script>
   $(document).ready(function () {

       var i = 1;

       $("#add").click(function () {
           i++;
           $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="desc[]"  class="form-control"/></td><td><input type="number" name="cost[]"  class="form-control"/></td><td><input type="number" name="qty[]"  class="form-control"/></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
       });

       $(document).on('click', '.btn_remove', function () {
           var button_id = $(this).attr("id");
           $('#row' + button_id + '').remove();
       });

     
   });
</script>
@endsection