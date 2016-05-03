
{{-- page level styles --}}
@push('header_styles_stack')

    <link href="{{ asset('assets/vendors/morrisjs/morris.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendors/ckeditor/samples/../ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendors/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendors/ckeditor/samples/css/samples.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">

@endpush

<div class="form-group">
    <div class="row">
        <div class="col-md-4 {{ $errors->first('title', 'has-error') }} {{ $errors->first('slug', 'has-error') }}">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            <span class="help-block">{{ $errors->first('title', ':message') == null ? $errors->first('slug', ':message') != null ? str_replace('slug', 'title', $errors->first('slug', ':message')) : '' : ''}}</span>
        </div>

        <div class="col-md-2 {{ $errors->first('author', 'has-error') }}">
            {!! Form::label('author', 'Author') !!}
            {!! Form::select('author', $users, null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('author', ':message') }}</span>
        </div>

        <div class="col-md-2 {{ $errors->first('category', 'has-error') }}">
            {!! Form::label('category', 'Category') !!}
            {!! Form::select('category', $cats, null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('category', ':message') }}</span>
        </div>

        <div class="col-md-4 {{ $errors->first('keywords', 'has-error') }}">
            {!! Form::label('keywords', 'Keywords') !!}
            {!! Form::text('keywords', null, ['class' => 'form-control', 'placeholder' => 'Seperated by comma. Ex: fruits, apple, banana, pear']) !!}
            <span class="help-block">{{ $errors->first('keywords', ':message') }}</span>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">

        <div class="col-md-12 {{ $errors->first('contents', 'has-error') }}">
            {!! Form::label('contents', 'Contents') !!}
            {!! Form::textarea('contents', null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('contents', ':message') }}</span>
        </div>

    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-offset-10 col-md-2">
            {!! Form::label('submit', 'Save') !!}
            {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
</div>

{{-- page level scripts --}}
@push('footer_scripts_stack')

    <script>
        CKEDITOR.replace( 'contents' );
        initSample();
    </script>

@endpush