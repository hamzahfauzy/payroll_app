<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('employee_id') }}
            {{ Form::text('employee_id', $employeePeriod->employee_id, ['class' => 'form-control' . ($errors->has('employee_id') ? ' is-invalid' : ''), 'placeholder' => 'Employee Id']) }}
            {!! $errors->first('employee_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('period_id') }}
            {{ Form::text('period_id', $employeePeriod->period_id, ['class' => 'form-control' . ($errors->has('period_id') ? ' is-invalid' : ''), 'placeholder' => 'Period Id']) }}
            {!! $errors->first('period_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $employeePeriod->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('payout_at') }}
            {{ Form::text('payout_at', $employeePeriod->payout_at, ['class' => 'form-control' . ($errors->has('payout_at') ? ' is-invalid' : ''), 'placeholder' => 'Payout At']) }}
            {!! $errors->first('payout_at', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>