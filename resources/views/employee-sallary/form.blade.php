<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('employee_id') }}
            {{ Form::text('employee_id', $employeeSallary->employee_id, ['class' => 'form-control' . ($errors->has('employee_id') ? ' is-invalid' : ''), 'placeholder' => 'Employee Id']) }}
            {!! $errors->first('employee_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('sallary_id') }}
            {{ Form::text('sallary_id', $employeeSallary->sallary_id, ['class' => 'form-control' . ($errors->has('sallary_id') ? ' is-invalid' : ''), 'placeholder' => 'Sallary Id']) }}
            {!! $errors->first('sallary_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('period_id') }}
            {{ Form::text('period_id', $employeeSallary->period_id, ['class' => 'form-control' . ($errors->has('period_id') ? ' is-invalid' : ''), 'placeholder' => 'Period Id']) }}
            {!! $errors->first('period_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount') }}
            {{ Form::text('amount', $employeeSallary->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount']) }}
            {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>