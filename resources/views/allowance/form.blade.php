<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('jabatan') }}
            {{ Form::select('position_id', $positions, $allowance->position_id, ['class' => 'form-control' . ($errors->has('position_id') ? ' is-invalid' : ''), 'placeholder' => '- Pilih Jabatan -']) }}
            {!! $errors->first('position_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nama') }}
            {{ Form::text('name', $allowance->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nama']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('jumlah') }}
            {{ Form::number('amount', $allowance->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Jumlah']) }}
            {!! $errors->first('amount', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipe') }}
            {{ Form::select('allowance_type', ['Percent'=>'Percent','Fixed'=>'Fixed'], $allowance->allowance_type, ['class' => 'form-control' . ($errors->has('allowance_type') ? ' is-invalid' : ''), 'placeholder' => '- Pilih Tipe -']) }}
            {!! $errors->first('allowance_type', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>