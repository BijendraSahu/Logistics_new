<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'update_unloaded', 'class' => 'form-horizontal', 'id'=>'edit_loaded', 'method'=>'post']) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('user_no', 'Voucher No*', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                <p></p>
                {{--<label for="" class="badge">{{$unloaded_items->challan_no}}</label>--}}
                <input type="text" name="challan_no" class="form-control" placeholder="Enter Unloaded Voucher No" value="{{$unloaded_items->challan_no}}">
                <input type="hidden" name="id" value="{{$unloaded_items->id}}">
            </div>
        </div>

        <div class='form-group'>
            {!! Form::label('name', 'Material *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('material_id', $materials, $unloaded_items->material_id,['class' => 'form-control requiredDD', 'id'=>'vehicle_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Material Type *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('material_type_id', $material_types, $unloaded_items->material_type_id,['class' => 'form-control requiredDD', 'id'=>'material_type_id']) !!}
            </div>
        </div>

        <div class='form-group'>
            {!! Form::label('name', 'Location *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('location_id', $locations, $unloaded_items->location_id,['class' => 'form-control requiredDD', 'id'=>'location_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Unload Qty *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <input type="text" name="unload_qty" class="form-control" placeholder="Enter Unload Quantity" value="{{$unloaded_items->unload_qty}}">
            </div>
            <div class='col-sm-2'>
                {!! Form::select('unit_id', $units, $unloaded_items->unit_id,['class' => 'form-control requiredDD', 'id'=>'unit_id']) !!}
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'Vehicle *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-10'>
                {!! Form::select('vehicle_id', $vehicles, $unloaded_items->vehicle_id,['class' => 'form-control requiredDD', 'id'=>'vehicle_id']) !!}
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

