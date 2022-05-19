<form class="form-horizontal" action="{{ route('modules.save') }}" autocomplete="off" method="post" role="form">
    @csrf
    <div class="form-group">
        <label for="parent" class="col-xs-12 col-sm-4 col-md-3 control-label required">Parent</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            {!! form_dropdown('parent', $dropdown_parent, null, 'id="parent" class="form-control" select-search-modal') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-xs-12 col-sm-4 col-md-3 control-label required">Name</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
    </div>
    <div class="form-group">
        <label for="icon" class="col-xs-12 col-sm-4 col-md-3 control-label required">Icon</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            {!! form_dropdown('icon', $dropdown_icon, null, 'id="icon" class="form-control" select-search-icon') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="alias" class="col-xs-12 col-sm-4 col-md-3 control-label required">Alias</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="alias" class="form-control" id="alias" required>
        </div>
    </div>
    <div class="form-group">
        <label for="permalink" class="col-xs-12 col-sm-4 col-md-3 control-label required">Pemalink</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="permalink" class="form-control" id="permalink" required placeholder="/foo/bar">
        </div>
    </div>
    <div class="form-group">
        <label for="published" class="col-xs-12 col-sm-4 col-md-3 control-label required">published</label>
        <div class="col-xs-12 col-sm-8 col-md-9 p-t-7">
            <div class="mt-ios fs-8">
                <input id="published" type="checkbox" name="published"/>
                <label for="published"></label>
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
