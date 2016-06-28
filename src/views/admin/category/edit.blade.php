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
                <h1 class="page-header">Edit category</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            @include('errors.list')

            {!! Form::model($cat, array('route' => array('category.update', $cat->id))) !!}

            @include('admin.category.partials.form', ['submitButton' => 'Update category'])

            {!! Form::close() !!}

        </div>

    </div>

@endsection
