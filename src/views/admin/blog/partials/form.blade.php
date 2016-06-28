
<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('description', 'Description') !!}
            {!! Form::text('description', null, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-10">
            {!! Form::label('value', 'Value') !!}
            @if(sizeof($setting->options()) > 0)
                {!! Form::select('value', $setting->options(), null, ['class' => 'form-control']) !!}
            @else
                {!! Form::text('value', null, ['class' => 'form-control']) !!}
            @endif
        </div>
        <div class="col-md-2">
            {!! Form::label('submit', 'Save') !!}
            {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-offset-1 col-md-4">
        </div>
    </div>
</div>
