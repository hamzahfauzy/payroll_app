@extends('layouts.app')

@section('template_title')
    Employee Sallary
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Employee Sallary') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('employee-sallaries.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Sallary Id</th>
										<th>Period Id</th>
										<th>Amount</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeSallaries as $employeeSallary)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $employeeSallary->employee_id }}</td>
											<td>{{ $employeeSallary->sallary_id }}</td>
											<td>{{ $employeeSallary->period_id }}</td>
											<td>{{ $employeeSallary->amount }}</td>

                                            <td>
                                                <form action="{{ route('employee-sallaries.destroy',$employeeSallary->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('employee-sallaries.show',$employeeSallary->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('employee-sallaries.edit',$employeeSallary->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $employeeSallaries->links() !!}
            </div>
        </div>
    </div>
@endsection
