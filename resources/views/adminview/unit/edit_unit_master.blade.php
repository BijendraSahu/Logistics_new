<script src="{{ url('js/validation.js') }}"></script>

@if(!is_null($unit))
    {!! Form::open(['url' => 'unit/'.$unit->id, 'class' => 'form-horizontal', 'id'=>'Unit', 'method'=>'put', 'files'=>true]) !!}
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('role', 'Unit Name *', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::text('name', $unit->unit, ['class' => 'form-control input-sm required','placeholder'=>'Enter Unit']) !!}
                </div>
            </div>
            <div class='form-group'>
                <div class='col-sm-offset-2 col-sm-10'>
                    {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@else
    <h4>Unit not found !</h4>
@endif
