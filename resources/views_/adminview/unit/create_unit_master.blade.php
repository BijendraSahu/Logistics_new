<script src="{{ url('js/validation.js') }}"></script>
@if($errors->any())
    <div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>
@endif
{!! Form::open(['url' => 'unit', 'class' => 'form-horizontal', 'id'=>'unitmaster']) !!}
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class='form-group'>
                {!! Form::label('name', 'Unit Name *', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::text('name', null, ['class' => 'form-control input-sm required', 'placeholder'=>'Unit Name']) !!}
                </div>
            </div>
            <div class='form-group'>
                <div class='col-sm-offset-2 col-sm-8'>
                    {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                </div>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
