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
	                <form action="{{ asset('schedule-profile') }}" method="POST" class="form-inline">
	                    {{ csrf_field() }}
	                    <div class="form-group-md" style="margin-bottom: 10px;">
	                        <input type="date" class="form-control" name="keyword" placeholder="Search my schedule..." value="{{Session::get('keyword')}}">
	                        <button type="submit" class="btn btn-success btn-sm btn-flat">
	                            <i class="fa fa-search"></i> Search by schedule date
	                        </button>
	                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
	                            <i class="fa fa-eye"></i> View All
	                        </button>
	                        <a data-toggle="modal" class="btn btn-info btn-sm btn-flat" data-target="#myscheduleModal">
	                            <i class="fas fa-head-side-mask"></i> Add my schedule
	                        </a>
	                    </div>
	                </form>
	            </div>
	            <h3>List of my schedules</h3>
	        </div>
            <div class="box-body">
            <br>
            @if(count($data)>0)
                <div class="table-responsive">
	                    <table class="table table-striped table-hover">
	                        <tr class="bg-black">
	                            <th>Schedule date</th>
                              <th>Start time</th>
	                            <th>End time</th>
                              <th>Appointment Fee</th>
	                            <th></th>
	                        </tr>
	                        
	                        @foreach($data as $row)
	                        <tr>
	                            <td style="white-space: nowrap;">
	                                <a
	                                    class="title-info update_info"
	                                    href="#"
	                                >
	                                    <b><?php echo
                                      \Carbon\Carbon::parse($row->schedule_date)->format('F d, Y');
                                      ?></b>
	                                </a>
	                            </td>
	                            <td>{{ \Carbon\Carbon::parse($row->start_time)->format('h:i A') }}</td>
	                            <td>{{ \Carbon\Carbon::parse($row->end_time)->format('h:i A') }}</td>
                              <td>{{$row->appointment_fee}}</td>
	                            <td><div class="btn-group" role="group">
                                @if($row->status == 'not booked')
                                <button type="button" class="btn-not-book btn btn-info" data-id="{{$row->id}}" disabled>Not Booked</button>
                                @else
                                <button type="button" class="btn-booked btn btn-success" data-id="{{$row->id}}">Booked</button>
                                @endif
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
	                        <i class="fa fa-warning"></i> No schedules found!
	                    </span>
	                </div>
	            @endif
	        </div>
        </div>
    </div>
</div>

<div id="myscheduleModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">myschedule</h4>
      </div>
      <div class="modal-body">
      	<form id="myschedule_form" method="POST">
      		{{ csrf_field() }}
      		<input type="hidden" name="myschedule_id">
	        <div class="form-group">
	            <label class="required-field">Schedule Date:</label>
	            <input type="date" class="form-control" value="" min="{{ date('Y-m-d') }}" name="schedule_date" required>
	        </div>
	        <div class="form-group">
	            <label class="required-field">Start time:</label>
	            <div class="input-group clockpicker">
                <input type="text" class="form-control" name="start_time" placeholder="Start Time" value="" required>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
	        </div>
          <div class="form-group">
              <label class="required-field">End time:</label>
              <div class="input-group clockpicker">
                <input type="text" class="form-control" name="end_time" placeholder="End Time" value="" required>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
          </div>
          <div class="form-group">
            <label class="required-field">Appointment Fee:</label>
              <input type="text" class="form-control" value="" name="appointment_fee" required>
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
        $('.clockpicker').clockpicker({
          donetext: 'Done',
          twelvehour: true
       });
    });
    $('#myschedule_form').on('submit',function(e){
		e.preventDefault();
		$('#myschedule_form').ajaxSubmit({
            url:  "{{ url('myschedule-store') }}",
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
    		var url = "{{ url('/myschedule-information') }}";
        $.ajax({
            url: url+"/"+iddoc,
            type: 'GET',
            async: false,
            success : function(data){
               var val = JSON.parse(data);
               $("input[name=myschedule_id]").val(val['id']);
               $("input[name=schedule_date]").val(val['schedule_date']);
               $("input[name=start_time]").val(val['start_time']);
               $("input[name=end_time]").val(val['end_time']);
               $("input[name=appointment_fee]").val(val['appointment_fee']);
               $('#myscheduleModal').modal('show');
            }
        });
    });
    $('#myscheduleModal').on('hidden.bs.modal', function () {
       $("input[name=myschedule_id]").val('');
       $("input[name=schedule_date]").val('');
       $("input[name=start_time]").val('');
       $("input[name=end_time]").val('');
       $("input[name=appointment_fee]").val('');
    });
    $( ".btn-delete" ).click(function() {
        var idpat = $(this).data('id');
		var url = "{{ url('/myschedule-delete') }}";
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