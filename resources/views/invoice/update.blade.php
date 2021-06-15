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
                    <h1 class="m-0">Update Invoices Page</h1>
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
                            <form action="{{ route('updateInvoice') }}"method="post">
                                    <div class="modal-body">
                                    @csrf
                                        <input type="hidden" name="invoice_id" value="{{ $data->id }}">
                                        <div class="form-group">
                                            <label for="">Date:</label>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ $data->date }}">
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Invoice Address:</label>
                                            <textarea name="invoice_address" id="invoice_address" class="form-control"
                                               >{{ $data->invoice_address }}</textarea>
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Delivery Address:</label>
                                            <textarea name="delivery_address" id="delivery_address" class="form-control"
                                            >{{ $data->delivery_address }}</textarea>
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="">Invoice Number:</label>
                                            <input type="text" name="invoice_number" id="invoice_number"
                                                class="form-control" value={{ $data->invoice_number }}>
                                        </div>
                            
                                        <div class="form-group">
                                        <label for="">Invoice Items:</label>
                                        <div id="item"></div>
                            
                                        <div name="add_name" id="add_name">
                                            <table class="table table-bordered table-hover" id="dynamic_field">
                                                  
                                                (if want to delete the item than check delete)
                                                @foreach ($data->item as $item)
                                                <tr>
                                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                    <td><input type="text" name="desc[]" value="{{ $item->description }}" class="form-control name_list" /></td>
                                                    <td><input type="number" name="cost[]" value="{{ $item->cost }}" class="form-control name_email"/></td>
                                                    <td><input type="number" name="qty[]" value="{{ $item->qty }}" class="form-control name_email"/></td>
                                                    <td>Delete: <input type="checkbox" name='delete[]' class="form-control" value="{{ $item->id}}"</td>  
                                                </tr>
                                                @endforeach

                                                
                                                <tr>
                                                   
                                                    <td><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
                                                </tr> 
                                            </table>
                                        </div>


                                       
                                    </div>
                                    
                            </div>
                            <div class="modal-footer">
                                
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
           $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="ndesc[]"  class="form-control"/></td><td><input type="number" name="ncost[]"  class="form-control"/></td><td><input type="number" name="nqty[]"  class="form-control"/></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
       });

       $(document).on('click', '.btn_remove', function () {
           var button_id = $(this).attr("id");
           $('#row' + button_id + '').remove();
       });

      
   });
</script>
@endsection