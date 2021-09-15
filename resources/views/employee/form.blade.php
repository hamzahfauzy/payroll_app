<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('jabatan') }}
            {{ Form::select('position_id', $positions, $employee->position_id, ['class' => 'form-control' . ($errors->has('position_id') ? ' is-invalid' : ''), 'placeholder' => '- Pilih Jabatan -']) }}
            {!! $errors->first('position_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('NIK') }}
            {{ Form::number('NIK', $employee->NIK, ['class' => 'form-control' . ($errors->has('NIK') ? ' is-invalid' : ''), 'placeholder' => 'NIK']) }}
            {!! $errors->first('NIK', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('NPWP') }}
            {{ Form::number('NPWP', $employee->NPWP, ['class' => 'form-control' . ($errors->has('NPWP') ? ' is-invalid' : ''), 'placeholder' => 'NPWP']) }}
            {!! $errors->first('NPWP', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nama') }}
            {{ Form::text('name', $employee->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nama']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('area_kerja') }}
            {{ Form::text('work_around', $employee->work_around, ['class' => 'form-control' . ($errors->has('work_around') ? ' is-invalid' : ''), 'placeholder' => 'Area Kerja']) }}
            {!! $errors->first('work_around', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('No. Rekening') }}
            {{ Form::text('bank_account', $employee->bank_account, ['class' => 'form-control' . ($errors->has('bank_account') ? ' is-invalid' : ''), 'placeholder' => 'No. Rekening']) }}
            {!! $errors->first('bank_account', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Gaji Pokok') }}
            {{ Form::number('main_sallary', $employee->main_sallary, ['class' => 'form-control' . ($errors->has('main_sallary') ? ' is-invalid' : ''), 'placeholder' => 'No. Rekening']) }}
            {!! $errors->first('main_sallary', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Username') }}
            <input type="text" name="username" value="{{$employee&&$employee->user?$employee->user->email:''}}" id="" class="form-control {{$errors->has('username') ? ' is-invalid' : ''}}" placeholder="Username">
            {!! $errors->first('username', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Password') }}
            <input type="password" name="password" id="" class="form-control {{$errors->has('password') ? ' is-invalid' : ''}}" placeholder="Password">
            {!! $errors->first('password', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>