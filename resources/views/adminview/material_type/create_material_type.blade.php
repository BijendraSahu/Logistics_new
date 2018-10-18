<script src="{{ url('js/validation.js') }}"></script>
{!! Form::open(['url' => 'material_type', 'class' => 'form-horizontal', 'id'=>'material_type']) !!}
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('role', 'Material*', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::select('material_id', $material, null,['class' => 'form-control requiredDD', 'id'=>'material']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('name', 'Type *', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::text('type', null, ['class' => 'form-control input-sm required', 'placeholder'=>'Enter Type']) !!}
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
