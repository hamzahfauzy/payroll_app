@extends('layouts.app')

@section('title',config('app.name', 'Laravel').' - Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <form class="col-md-12" enctype="multipart/form-data" action="{{route('edit-profile')}}" method="post">
            @csrf

            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
            @endif

            <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif -->

            <div class="card card-body mb-3">
                <h3>Profile</h3>

                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" required class="form-control @error('name') is-invalid @enderror" value="{{old('name') ? old('name') : Auth::user()->name}}">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" required class="form-control @error('email') is-invalid @enderror" value="{{old('email') ? old('email') : Auth::user()->email}}">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>

            @if(Auth::user()->employee)

            <div class="card card-body mb-3">
                <h3>Employee</h3>

                <div class="form-group">
                    <label for="">NIK</label>
                    <input type="number" name="NIK" required class="form-control @error('NIK') is-invalid @enderror" value="{{old('NIK') ? old('NIK') : Auth::user()->employee->NIK}}">

                    @error('NIK')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">NPWP</label>
                    <input type="number" name="NPWP" required class="form-control @error('NPWP') is-invalid @enderror" value="{{old('NPWP') ? old('NPWP') : Auth::user()->employee->NPWP}}">

                    @error('NPWP')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="employee_name" required class="form-control @error('employee_name') is-invalid @enderror" value="{{old('employee_name') ? old('employee_name') : Auth::user()->employee->name}}">

                    @error('employee_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Work Around</label>
                    <input type="text" name="work_around" required class="form-control @error('work_around') is-invalid @enderror" value="{{old('work_around') ? old('work_around') : Auth::user()->employee->work_around}}">

                    @error('work_around')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Bank Account</label>
                    <input type="text" name="bank_account" required class="form-control @error('bank_account') is-invalid @enderror" value="{{old('bank_account') ? old('bank_account') : Auth::user()->employee->bank_account}}">

                    @error('bank_account')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            @else

            <div class="card card-body">
                <h3>Installation</h3>

                <div class="form-group">
                    <label for="company_name">{{ __('Company Name') }}</label>

                    <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') ?? $installation->company_name }}" required autofocus>

                    @error('company_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number">{{ __('Phone Number') }}</label>

                    <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') ?? $installation->phone_number }}" required>

                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">{{ __('Address') }}</label>

                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $installation->address }}" required>

                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_email">{{ __('Company Email') }}</label>

                    <input id="company_email" type="email" class="form-control @error('company_email') is-invalid @enderror" name="company_email" value="{{ old('company_email') ?? $installation->email }}" required>

                    @error('company_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code">{{ __('Postal Code') }}</label>

                    <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') ?? $installation->postal_code }}" required>

                    @error('postal_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="logo">{{ __('Logo') }}</label>

                    <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" style="height: auto">

                    @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slip_watermark">{{ __('Slip Watermark') }}</label>

                    <input id="slip_watermark" type="file" class="form-control @error('slip_watermark') is-invalid @enderror" name="slip_watermark" style="height: auto">

                    @error('slip_watermark')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            @endif

            <br>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
</div>
@endsection