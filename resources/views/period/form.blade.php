<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nama') }}
            {{ Form::text('name', $period->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nama']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bulan') }}
            {{ Form::select('month', monthListArray(), $period->month, ['class' => 'form-control' . ($errors->has('month') ? ' is-invalid' : ''), 'placeholder' => '- Pilih Bulan -']) }}
            {!! $errors->first('month', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tahun') }}
            {{ Form::number('year', $period->year, ['class' => 'form-control' . ($errors->has('year') ? ' is-invalid' : ''), 'placeholder' => 'Tahun']) }}
            {!! $errors->first('year', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>