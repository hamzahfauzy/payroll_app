<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nama') }}
            {{ Form::text('name', $sallary->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nama']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipe') }}
            {{ Form::select('sallary_type', ['Bonus'=>'Bonus','Potongan'=>'Potongan'], $sallary->sallary_type, ['class' => 'form-control' . ($errors->has('sallary_type') ? ' is-invalid' : ''), 'placeholder' => '- Tipe -']) }}
            {!! $errors->first('sallary_type', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>