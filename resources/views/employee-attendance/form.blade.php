<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('employee_id') }}
            {{ Form::text('employee_id', $employeeAttendance->employee_id, ['class' => 'form-control' . ($errors->has('employee_id') ? ' is-invalid' : ''), 'placeholder' => 'Employee Id']) }}
            {!! $errors->first('employee_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('attendance_id') }}
            {{ Form::text('attendance_id', $employeeAttendance->attendance_id, ['class' => 'form-control' . ($errors->has('attendance_id') ? ' is-invalid' : ''), 'placeholder' => 'Attendance Id']) }}
            {!! $errors->first('attendance_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('period_id') }}
            {{ Form::text('period_id', $employeeAttendance->period_id, ['class' => 'form-control' . ($errors->has('period_id') ? ' is-invalid' : ''), 'placeholder' => 'Period Id']) }}
            {!! $errors->first('period_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount') }}
            {{ Form::text('amount', $employeeAttendance->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount']) }}
            {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>