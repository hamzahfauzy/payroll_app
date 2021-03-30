@extends('layouts.app')

@section('template_title')
    Employee Attendance
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Employee Attendance') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('employee-attendances.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Employee Id</th>
										<th>Attendance Id</th>
										<th>Period Id</th>
										<th>Amount</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeAttendances as $employeeAttendance)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $employeeAttendance->employee_id }}</td>
											<td>{{ $employeeAttendance->attendance_id }}</td>
											<td>{{ $employeeAttendance->period_id }}</td>
											<td>{{ $employeeAttendance->amount }}</td>

                                            <td>
                                                <form action="{{ route('employee-attendances.destroy',$employeeAttendance->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('employee-attendances.show',$employeeAttendance->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('employee-attendances.edit',$employeeAttendance->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $employeeAttendances->links() !!}
            </div>
        </div>
    </div>
@endsection
