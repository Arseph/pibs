@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="box box-success">
        <div class="box-body">
            <div class="box-header with-border">
                <h3>
                    Patient Profile
                </h3>
            </div>
            <div class="box-body">
            <br>
            @if(count($data)>0)
                <div class="table-responsive">
	                    <table class="table table-striped table-hover">
	                        <tr class="bg-black">
	                            <th>Name</th>
	                            <th>DOB</th>
	                            <th>Contact</th>
	                            <th>Email</th>
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
	                        </tr>
	                        @endforeach
	                    </table>
	                    
	                </div>
	            @else
	                <div class="alert alert-warning">
	                    <span class="text-warning">
	                        <i class="fa fa-warning"></i> No Patients found!
	                    </span>
	                </div>
	            @endif
	        </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection