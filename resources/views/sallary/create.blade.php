@extends('layouts.app')

@section('template_title')
    Buat Referensi Bonus dan Potongan
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Buat Referensi Bonus dan Potongan</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sallaries.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('sallary.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
