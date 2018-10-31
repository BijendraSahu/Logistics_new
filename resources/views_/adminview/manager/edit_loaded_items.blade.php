<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'update_loaded', 'class' => 'form-horizontal', 'id'=>'edit_loaded', 'method'=>'post']) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('user_no', 'Voucher No*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                <p></p>
                {{--<label for="" class="badge">{{$loaded_items->challan_no}}</label>--}}
                <input type="text" name="challan_no" class="form-control" placeholder="Enter Voucher No" value="{{$loaded_items->challan_no}}">
                <input type="hidden" name="id" value="{{$loaded_items->id}}">
            </div>
        </div>

        {{--<div class="form-group">--}}
            {{--{!! Form::label('role', 'Contact', ['class' => 'col-sm-2 control-label']) !!}--}}
            {{--<div class='col-sm-10'>--}}
                {{--<p></p>--}}
                {{--<label for="" class="badge">{{$loaded_items->contact}}</label>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class='form-group'>
            {!! Form::label('name', 'Material *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('material_id', $materials, $loaded_items->material_id,['class' => 'form-control requiredDD', 'id'=>'vehicle_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Material Type *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('material_type_id', $material_types, $loaded_items->material_type_id,['class' => 'form-control requiredDD', 'id'=>'material_type_id']) !!}
            </div>
        </div>

        <div class='form-group'>
            {!! Form::label('name', 'Location *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('location_id', $locations, $loaded_items->location_id,['class' => 'form-control requiredDD', 'id'=>'location_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Load Qty *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <input type="text" name="load_qty" class="form-control" placeholder="Enter Quantity" value="{{$loaded_items->load_qty}}">
            </div>
            <div class='col-sm-2'>
                {!! Form::select('unit_id', $units, $loaded_items->unit_id,['class' => 'form-control requiredDD', 'id'=>'unit_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Vehicle *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('vehicle_id', $vehicles, $loaded_items->vehicle_id,['class' => 'form-control requiredDD', 'id'=>'vehicle_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Destination Address *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                <textarea type="text" name="destination_address" class="form-control" rows="5" placeholder="Enter Destination Address">{{$loaded_items->destination_address}}</textarea>
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

