<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nama') }}
            {{ Form::text('name', $position->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nama']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gaji_pokok') }}
            {{ Form::number('sallary', $position->sallary, ['class' => 'form-control' . ($errors->has('sallary') ? ' is-invalid' : ''), 'placeholder' => 'Gaji Pokok']) }}
            {!! $errors->first('sallary', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('biaya_jabatan') }}
            {{ Form::number('cost', $position->cost, ['class' => 'form-control' . ($errors->has('cost') ? ' is-invalid' : ''), 'placeholder' => 'Biaya Jabatan']) }}
            {!! $errors->first('cost', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>