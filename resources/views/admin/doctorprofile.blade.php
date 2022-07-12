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
	                <form action="{{ asset('doctor-profile') }}" method="POST" class="form-inline">
	                    {{ csrf_field() }}
	                    <div class="form-group-md" style="margin-bottom: 10px;">
	                        <input type="text" class="form-control" name="keyword" placeholder="Search doctor..." value="{{Session::get('keyword')}}">
	                        <button type="submit" class="btn btn-success btn-sm btn-flat">
	                            <i class="fa fa-search"></i> Search
	                        </button>
	                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
	                            <i class="fa fa-eye"></i> View All
	                        </button>
	                        <a data-toggle="modal" class="btn btn-info btn-sm btn-flat" data-target="#doctorModal">
	                            <i class="fas fa-head-side-mask"></i> Add doctor
	                        </a>
	                    </div>
	                </form>
	            </div>
	            <h3>List of doctors</h3>
	        </div>
            <div class="box-body">
            <br>
            @if(count($data)>0)
                <div class="table-responsive">
	                    <table class="table table-striped table-hover">
	                        <tr class="bg-black">
	                            <th>Name</th>
                              <th>Specialization</th>
	                            <th>Gender</th>
	                            <th>DOB</th>
	                            <th>Contact</th>
	                            <th>Email</th>
	                            <th></th>
	                        </tr>
	                        
	                        @foreach($data as $row)
	                        <tr>
	                            <td style="white-space: nowrap;">
	                                <a
	                                    class="title-info update_info"
	                                    href="#"
	                                >
	                                    {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}
	                                </a>
	                            </td>
                              <td>{{ $row->specialization }}</td>
	                            <td>{{ $row->gender }}</td>
	                            <td>
	                                @if($row->dob)
	                                <b><?php echo
	                                    \Carbon\Carbon::parse($row->dob)->format('F d, Y');
	                                    ?></b><br>
	                                <small class="text-success">
	                                    <?php echo
	                                    \Carbon\Carbon::parse($row->dob)->diff(\Carbon\Carbon::now())->format('%y years and %m months old');
	                                    ?>
	                                </small>
	                                @endif
	                            </td>
	                            <td>{{ $row->contact }}</td>
	                            <td>{{ $row->email }}</td>
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
	                        <i class="fa fa-warning"></i> No doctors found!
	                    </span>
	                </div>
	            @endif
	        </div>
        </div>
    </div>
</div>

<div id="doctorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Doctor</h4>
      </div>
      <div class="modal-body">
      	<form id="doctor_form" method="POST">
      		{{ csrf_field() }}
      		<input type="hidden" name="doctor_id">
	        <div class="form-group">
		     	<label class="required-field">First name:</label>
		        <input type="text" class="form-control" value="" name="fname" required>
		    </div>
		    <div class="form-group">
		     	<label>Middle name:</label>
		        <input type="text" class="form-control" value="" name="mname">
		    </div>
		    <div class="form-group">
		     	<label class="required-field">Last name:</label>
		        <input type="text" class="form-control" value="" name="lname" required>
		    </div>
		    <div class="form-group">
	            <label class="required-field">Sex:</label>
	            <select class="form-control gender" name="gender" required>
	                <option value="Male">Male</option>
	                <option value="Female">Female</option>
	            </select>
	        </div>
	        <div class="form-group">
	            <label class="required-field">Birth Date:</label>
	            <input type="date" class="form-control" value="" min="1910-05-11" max="{{ date('Y-m-d') }}" name="dob" required>
	        </div>
	        <div class="form-group">
	            <label class="required-field">Civil Status:</label>
	            <select class="form-control civil_status" name="civil_status" required>
	                <option value="Single">Single</option>
	                <option value="Married">Married</option>
	                <option value="Divorced">Divorced</option>
	                <option value="Separated">Separated</option>
	            </select>
	        </div>
          <div class="mt-3">
            <hr>
            <h4>Contact Information</h4>
          </div>
		    <div class="form-group">
	            <label class="required-field">Contact Number:</label>
	            <input type="text" class="form-control" value="" name="contact" required>
	        </div>
	        <div class="has-group">
		        <label class="required-field">Address :</label>
		        <input type="text" name="address" class="form-control others" placeholder="Enter complete address..." />
		    </div>
        <div class="form-group">
          <label class="required-field">Specialization:</label>
            <input type="text" class="form-control" value="" name="specialization" required>
        </div>
		    <div class="form-group">
	            <label class="required-field">Email:</label>
	            <input type="email" class="form-control" value="" name="email" required>
	        </div>
		    <div class="form-group">
	            <label class="required-field">Username:</label>
	            <input type="text" class="form-control" value="" name="username" required>
	        </div>
	        <div class="form-group">
	            <label class="required-field password">Password:</label>
	            <input type="password" class="form-control" value="" name="password" required>
	        </div>
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
            minDate: today,
            "singleDatePicker": true
        });
    });
    $('#doctor_form').on('submit',function(e){
		e.preventDefault();
		$('#doctor_form').ajaxSubmit({
            url:  "{{ url('doctor-store') }}",
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
    		var url = "{{ url('/doctor-information') }}";
        $.ajax({
            url: url+"/"+iddoc,
            type: 'GET',
            async: false,
            success : function(data){
               var val = JSON.parse(data);
               $("input[name=doctor_id]").val(val['id']);
               $("input[name=fname]").val(val['fname']);
               $("input[name=mname]").val(val['mname']);
               $("input[name=lname]").val(val['lname']);
               $("input[name=contact]").val(val['contact']);
               $("input[name=address]").val(val['address']);
               $("input[name=email]").val(val['email']);
               $("input[name=username]").val(val['username']);
               $("input[name=dob]").val(val['dob']);
               $(".civil_status").val(val['civil_status']);
               $(".gender").val(val['gender']);
               $('#doctorModal').modal('show');
               $('input[name=password]').attr('required',false);
               $('.password').removeClass('required-field');
               $('.password').html('Change Password:');
            }
        });
    });
    $('#doctorModal').on('hidden.bs.modal', function () {
        $("input[name=doctor_id]").val('');
               $("input[name=fname]").val('');
               $("input[name=mname]").val('');
               $("input[name=lname]").val('');
               $("input[name=contact]").val('');
               $("input[name=address]").val('');
               $("input[name=email]").val('');
               $("input[name=username]").val('');
               $("input[name=dob]").val('');
               $(".civil_status").val('');
               $(".gender").val('');
               $('input[name=password]').attr('required',true);
               $('.password').addClass('required-field');
               $('.password').html('Password:');
    });
    $( ".btn-delete" ).click(function() {
        var idpat = $(this).data('id');
		var url = "{{ url('/doctor-delete') }}";
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