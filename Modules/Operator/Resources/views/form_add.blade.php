<form class="form-horizontal" action="{{ route('operator.save') }}" autocomplete="off" method="post" role="form" >
    @csrf
    <div class="form-group">
        <label for="guid" class="col-xs-12 col-sm-4 col-md-3 control-label required">Operator Group</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            {!! form_dropdown('guid', $dropdown_operator_group, null, 'id="parent" class="form-control" select-search-modal') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="username" class="col-xs-12 col-sm-4 col-md-3 control-label required">Username</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="username" class="form-control" id="username" required>
        </div>
    </div>
    <div class="form-group">
        <label for="fullname" class="col-xs-12 col-sm-4 col-md-3 control-label required">Fullname</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="fullname" class="form-control" id="fullname" required>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-xs-12 col-sm-4 col-md-3 control-label required">Password</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <div class="input-group">
                <input type="password" name="password" class="form-control" id="password" required>
                <span class="input-group-addon show-password cursor-pointer" data-target="#password"><i class="fa fa-eye-slash"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="repassword" class="col-xs-12 col-sm-4 col-md-3 control-label required">Re Password</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <div class="input-group">
                <input type="password" name="repassword" class="form-control" id="repassword" required>
                <span class="input-group-addon show-password cursor-pointer" data-target="#repassword"><i class="fa fa-eye-slash"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="active" class="col-xs-12 col-sm-4 col-md-3 control-label required">Active</label>
        <div class="col-xs-12 col-sm-8 col-md-9 p-t-7">
            <div class="mt-ios fs-8">
                <input id="active" type="checkbox" name="active"/>
                <label for="active"></label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 text-center">
            <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
        </div>
    </div>
</form>
<script type="application/javascript">
    $(function(){
        App.init()
    })
</script>
