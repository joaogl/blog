@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Categories
    @parent
@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create category</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            {!! Form::model(null, array('route' => array('create.category'))) !!}

            @include('admin.category.partials.form', ['submitButton' => 'Create category'])

            {!! Form::close() !!}

        </div>

    </div>

@endsection
