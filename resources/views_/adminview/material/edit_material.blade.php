<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'material/'.$material->id, 'class' => 'form-horizontal', 'id'=>'Unit', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('role', 'Locations*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                {!! Form::select('location_id', $locations, $material->location_id,['class' => 'form-control requiredDD', 'id'=>'location']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Material Name*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                {!! Form::text('name', $material->name, ['class' => 'form-control input-sm required', 'placeholder'=>'Enter Material Name']) !!}
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

