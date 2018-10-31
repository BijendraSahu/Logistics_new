<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'material_type/'.$material_type->id, 'class' => 'form-horizontal', 'id'=>'material_type', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('material_id', 'Material*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('material_id', $material, $material_type->material_id,['class' => 'form-control requiredDD', 'id'=>'material']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('type', 'Type*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::text('type', $material_type->type, ['class' => 'form-control input-sm required', 'placeholder'=>'Enter Type']) !!}
            </div>
        </div>
        <div class='form-group'>
            <div class='col-sm-offset-2 col-sm-8'>
                {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}


