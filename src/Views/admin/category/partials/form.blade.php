
<div class="form-group">
    <div class="row">
        <div class="col-md-4 {{ $errors->first('name', 'has-error') }} {{ $errors->first('slug', 'has-error') }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            <span class="help-block">{{ $errors->first('name', ':message') == null ? $errors->first('slug', ':message') != null ? str_replace('slug', 'name', $errors->first('slug', ':message')) : '' : ''}}</span>
        </div>
        <div class="col-md-8 {{ $errors->first('description', 'has-error') }}">
            {!! Form::label('description', 'Description') !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
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
