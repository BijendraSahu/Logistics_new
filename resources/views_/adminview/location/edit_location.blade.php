<script src="{{ url('js/validation.js') }}"></script>
{!! Form::open(['url' => 'location/'.$location->id, 'class' => 'form-horizontal', 'id'=>'Unit', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('role', 'Location Type*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('type', array('dumping_site' => 'Dumping Site', 'crusher' => 'Crusher', 'petrol_pump' => 'Petrol Pump', 'site' => 'Site'), $location->type,['class' => 'form-control requiredDD', 'id'=>'profession']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('role', 'Location*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::text('location', $location->name, ['class' => 'form-control input-sm','placeholder'=>'Enter Location']) !!}
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
