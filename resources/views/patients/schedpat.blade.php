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
                  <form action="{{ asset('patient-schedule') }}" method="POST" class="form-inline">
                      {{ csrf_field() }}
                      <div class="form-group-md" style="margin-bottom: 10px;">
                          <input type="text" class="form-control" name="keyword" placeholder="Search doctor by specialization..." value="{{Session::get('keyword')}}">
                          <button type="submit" class="btn btn-success btn-sm btn-flat">
                              <i class="fa fa-search"></i> Search
                          </button>
                          <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
                              <i class="fa fa-eye"></i> View All
                          </button>
                          <a data-toggle="modal" class="btn btn-info btn-sm btn-flat" data-target="#doctorModal">
                              <i class="fas fa-clock"></i> My schedule
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
                              <td><button type="button" class="btn btn-warning btn-sm btn-flat">
                                  <i class="fa fa-eye"></i> View Schedule
                              </button></td>
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
        <h4 class="modal-title">My Schedules</h4>
      </div>
      <div class="modal-body">
        @if(count($myscheds)>0)
                <div class="table-responsive">
                      <table class="table table-striped table-hover">
                          <tr class="bg-black">
                              <th>Doctor</th>
                              <th>Specialization</th>
                              <th>Schedule Date</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th>Status</th>
                          </tr>
                          
                          @foreach($myscheds as $row)
                          <tr>
                              <td style="white-space: nowrap;">
                                  <a
                                      class="title-info update_info"
                                      href="#"
                                  >
                                      {{ $row->schedule->doctor->lname }}, {{ $row->schedule->doctor->fname }} {{ $row->schedule->doctor->mname }}
                                  </a>
                              </td>
                              <td>{{ $row->schedule->doctor->specialization }}</td>
                              <td>{{ $row->schedule->schedule_date }}</td>
                              <td>{{ $row->schedule->start_time }}</td>
                              <td>{{ $row->schedule->end_time }}</td>
                              <td>@if($row->schedule->status == 'booked')<span class="label label-success">{{ $row->schedule->status }}</span>
                              @else
                              <span class="label label-danger">{{ $row->schedule->status }}
                            @endif</td>
                          </tr>
                          @endforeach
                      </table>
                      
                  </div>
              @else
                  <div class="alert alert-warning">
                      <span class="text-warning">
                          <i class="fa fa-warning"></i> No schedule found!
                      </span>
                  </div>
              @endif
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
</script>
@endsection