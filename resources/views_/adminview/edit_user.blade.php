<script src="{{ url('js/validation.js') }}"></script>

{!! Form::open(['url' => 'update_user', 'class' => 'form-horizontal', 'id'=>'user_master', 'method'=>'post']) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('user_no', 'Name', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <p></p>
                <label for="" class="badge">{{$user->name}}</label>
                <input type="hidden" name="id" value="{{$user->id}}">
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('role', 'Contact', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <p></p>
                <label for="" class="badge">{{$user->contact}}</label>
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('name', 'User Type *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <select name="user_type" class="form-control requiredDD" id="user_type">
                    <option {{$user->user_type=='staff'?'selected':''}} value="staff">Staff</option>
                    <option {{$user->user_type=='client'?'selected':''}}  value="client">Client</option>
                    <option {{$user->user_type=='supervisor'?'selected':''}}  value="supervisor">Supervisor</option>
                </select>
            </div>
        </div>
        <div class='form-group hidden' id="supervisor_type">
            {!! Form::label('name', 'Site Type *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <select name="type" class="form-control requiredDD" id="type">
                    <option {{$user->type=='crusher'?'selected':''}} value="crusher">Crusher</option>
                    <option {{$user->type=='dumping_site'?'selected':''}} value="dumping_site">Dumping Site</option>
                    <option {{$user->type=='petrol_pump'?'selected':''}}  value="petrol_pump">Petrol Pump</option>
                </select>
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
<script>
    $("#user_type").change(function () {
        var curr_val = this.value;
        var firstDropVal = $('#user_type').val();
        if (curr_val == 'supervisor') {
            $('#supervisor_type').removeClass('form-group hidden');
            $('#supervisor_type').addClass('form-group');
        } else {
            $('#supervisor_type').removeClass('form-group');
            $('#supervisor_type').addClass('form-group hidden');
        }
    });

    function check() {
        var firstDropVal = $('#user_type').val();
        if (firstDropVal == 'supervisor') {
            $('#supervisor_type').removeClass('form-group hidden');
            $('#supervisor_type').addClass('form-group');
        }
    }

    check();
</script>
