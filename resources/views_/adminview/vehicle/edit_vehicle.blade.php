<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'vehicle/'.$vehicle->id, 'class' => 'form-horizontal', 'id'=>'Unit', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('name', 'Vehicle No*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                {!! Form::text('vehicle_no', $vehicle->vehicle_no, ['class' => 'form-control input-sm required', 'placeholder'=>'Vehicle No']) !!}
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

