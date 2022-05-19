<form class="form-horizontal" action="{{ route('modules.update') }}" autocomplete="off" method="post" role="form">
    @csrf
    <div class="form-group">
        <label for="parent" class="col-xs-12 col-sm-4 col-md-3 control-label required">Parent</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            {!! form_dropdown('parent', $dropdown_parent, $module->parent_id, 'id="parent" class="form-control" select-search-modal') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-xs-12 col-sm-4 col-md-3 control-label required">Name</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="name" class="form-control" id="name" required value="{{ $module->mod_name }}">
        </div>
    </div>
    <div class="form-group">
        <label for="icon" class="col-xs-12 col-sm-4 col-md-3 control-label required">Icon</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            {!! form_dropdown('icon', $dropdown_icon, str_replace('fa ','',$module->mod_icon), 'id="icon" class="form-control" select-search-icon') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="alias" class="col-xs-12 col-sm-4 col-md-3 control-label required">Alias</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="alias" class="form-control" id="alias" required value="{{ $module->mod_alias }}">
        </div>
    </div>
    <div class="form-group">
        <label for="permalink" class="col-xs-12 col-sm-4 col-md-3 control-label required">Pemalink</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="permalink" class="form-control" id="permalink" required placeholder="/foo/bar" value="{{ $module->permalink }}">
        </div>
    </div>
    <div class="form-group">
        <label for="published" class="col-xs-12 col-sm-4 col-md-3 control-label required">published</label>
        <div class="col-xs-12 col-sm-8 col-md-9 p-t-7">
            <div class="mt-ios fs-8">
                <input id="published" type="checkbox" name="published" {{ $module->published == 'y' ? 'checked' : '' }}/>
                <label for="published"></label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 text-center">
            <input type="hidden" name="modid" value="{{ $module->modid }}">
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
