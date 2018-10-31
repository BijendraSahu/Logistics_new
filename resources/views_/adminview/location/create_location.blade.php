<script src="{{ url('js/validation.js') }}"></script>
@if($errors->any())
    <div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>
@endif
{!! Form::open(['url' => 'location', 'class' => 'form-horizontal', 'id'=>'location']) !!}
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('role', 'Location Type*', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::select('type', array('dumping_site' => 'Dumping Site', 'crusher' => 'Crusher', 'petrol_pump' => 'Petrol Pump', 'site' => 'Site'), null,['class' => 'form-control requiredDD', 'id'=>'location']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('name', 'Location*', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::text('location', null, ['class' => 'form-control input-sm required', 'placeholder'=>'Enter Location']) !!}
                </div>
            </div>
            <div class='form-group'>
                <div class='col-sm-offset-2 col-sm-10'>
                    {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                </div>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
