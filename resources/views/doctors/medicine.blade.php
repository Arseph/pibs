@extends('layouts.app')

@section('content')
<style>
    label {
        padding: 0px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .disAble {
        pointer-events:none;
    }
    .dropdown-left-manual {
      right: 0;
      left: auto;
      padding-left: 1px;
      padding-right: 1px;
    }
</style>
<div class="container-fluid">
    <div class="box box-success">
        <div class="box-body">
           <div class="box-header with-border">
	            <div class="pull-right">
	                <form action="{{ asset('medicine-profile') }}" method="POST" class="form-inline">
	                    {{ csrf_field() }}
	                    <div class="form-group-md" style="margin-bottom: 10px;">
	                        <input type="text" class="form-control" name="keyword" placeholder="Search medicine..." value="{{Session::get('keyword')}}">
	                        <button type="submit" class="btn btn-success btn-sm btn-flat">
	                            <i class="fa fa-search"></i> Search
	                        </button>
	                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
	                            <i class="fa fa-eye"></i> View All
	                        </button>
	                        <a data-toggle="modal" class="btn btn-info btn-sm btn-flat" data-target="#medicineModal">
	                            <i class="fas fa-capsules"></i> Add Medicine
	                        </a>
	                    </div>
	                </form>
	            </div>
	            <h3>List of medicines</h3>
	        </div>
            <div class="box-body">
            <br>
            @if(count($data)>0)
                <div class="table-responsive">
	                    <table class="table table-striped table-hover">
	                        <tr class="bg-black">
	                            <th>Name</th>
                              <th>Price</th>
	                            <th>Expiration Date</th>
                              <th></th>
	                        </tr>
	                        
	                        @foreach($data as $row)
	                        <tr>
	                            <td style="white-space: nowrap;">
	                                <a
	                                    class="title-info update_info"
	                                    href="#"
	                                >
	                                    {{ $row->name }}
	                                </a>
	                            </td>
                              <td>{{ $row->price }}</td>
	                            <td>{{ $row->exp_date }}</td>
	                            <td><div class="btn-group" role="group">
								  <button type="button" class="btn-edit btn btn-warning" data-id="{{$row->id}}">Edit</button>
								  <button type="button" class="btn-delete btn btn-danger" data-id="{{$row->id}}">Remove</button>
								</div></td>
	                        </tr>
	                        @endforeach
	                    </table>
	                    
	                </div>
	            @else
	                <div class="alert alert-warning">
	                    <span class="text-warning">
	                        <i class="fa fa-warning"></i> No medicines found!
	                    </span>
	                </div>
	            @endif
	        </div>
        </div>
    </div>
</div>

<div id="medicineModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Medicine</h4>
      </div>
      <div class="modal-body">
      	<form id="medicine_form" method="POST">
      		{{ csrf_field() }}
      		<input type="hidden" name="medicine_id">
	        <div class="form-group">
		     	<label class="required-field">Medicine name:</label>
		        <input type="text" class="form-control" value="" name="name" required>
		    </div>
		    <div class="form-group">
		     	<label class="required-field">Price:</label>
		        <input type="text" class="form-control" value="" name="price">
		    </div>
	        <div class="form-group">
	            <label class="required-field">Expiration Date:</label>
	            <input type="date" class="form-control" value="" min="1910-05-11" name="exp_date" required>
	        </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
      </div>
      	</form>
    </div>

  </div>
</div>
@endsection
@section('js')
<script>
	@if(Session::get('action_made'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get('action_made'); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
            Session::put("action_made",false);
        ?>
    @endif
    @if(Session::get('delete_action'))
        Lobibox.notify('error', {
            title: "",
            msg: "<?php echo Session::get('delete_action'); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
            Session::put("delete_action",false);
        ?>
    @endif
    $(document).ready(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('.daterange').daterangepicker({
            "singleDatePicker": true
        });
    });
    $('#medicine_form').on('submit',function(e){
		e.preventDefault();
		$('#medicine_form').ajaxSubmit({
            url:  "{{ url('medicine-store') }}",
            type: "POST",
            success: function(data){
                setTimeout(function(){
                    window.location.reload(false);
                },500);
            },
            error : function(data){
                Lobibox.notify('error', {
                    title: "",
                    msg: "Something Went Wrong. Please Try again.",
                    size: 'mini',
                    rounded: true
                });
            }
        });
		
	});
	$( ".btn-edit" ).click(function() {
        var iddoc = $(this).data('id');
        console.log(iddoc)
    		var url = "{{ url('/medicine-information') }}";
        $.ajax({
            url: url+"/"+iddoc,
            type: 'GET',
            async: false,
            success : function(data){
               var val = JSON.parse(data);
               $("input[name=medicine_id]").val(val['id']);
               $("input[name=name]").val(val['name']);
               $("input[name=price]").val(val['price']);
               $("input[name=exp_date]").val(val['exp_date']);
               $('#medicineModal').modal('show');
            }
        });
    });
    $('#medicineModal').on('hidden.bs.modal', function () {
               $("input[name=medicine_id]").val('');
               $("input[name=name]").val('');
               $("input[name=price]").val('');
               $("input[name=exp_date]").val('');
    });
    $( ".btn-delete" ).click(function() {
        var idpat = $(this).data('id');
		var url = "{{ url('/medicine-delete') }}";
        $.ajax({
            url: url+"/"+idpat,
            type: 'GET',
            async: false,
            success : function(data){
               setTimeout(function(){
                    window.location.reload(false);
                },500);
            },
            error : function(data){
                Lobibox.notify('error', {
                    title: "",
                    msg: "Something Went Wrong. Please Try again.",
                    size: 'mini',
                    rounded: true
                });
            }
        });
    });
</script>
@endsection