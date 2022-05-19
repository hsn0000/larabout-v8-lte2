<style>
    .module-list{width:100%;display:grid;grid-template-columns:30% 70%;background:#f3f3f3;margin-bottom:5px;padding:8px 10px;color:inherit}
    .operator-group .module-list.parent{
        background: rgba(41,41,41,1);
        background: -moz-linear-gradient(top, rgba(41,41,41,1) 0%, rgba(2,2,2,1) 100%);
        background: -webkit-linear-gradient(top, rgba(41,41,41,1) 0%, rgba(2,2,2,1) 100%);
        background: -o-linear-gradient(top, rgba(41,41,41,1) 0%, rgba(2,2,2,1) 100%);
        background: -ms-linear-gradient(top, rgba(41,41,41,1) 0%, rgba(2,2,2,1) 100%);
        background: linear-gradient(to bottom, rgba(41,41,41,1) 0%, rgba(2,2,2,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#292929', endColorstr='#020202', GradientType=0 );
        color: white;
    }
    .operator-group .module-list .form-check-inline{width:unset;padding:unset;float:right}
    .operator-group .module-list .form-check-inline label{color:inherit;cursor:pointer;margin:0 5px 0 0}
    .operator-group .module-list .form-check-inline input{margin:0;cursor:pointer;vertical-align:middle}
</style>
<form class="form-horizontal operator-group" action="{{ route('operator-group.update') }}" autocomplete="off" method="post" role="form" >
    @csrf
    <div class="form-group">
        <label for="name" class="col-xs-12 col-sm-4 col-md-3 control-label required">Group Name</label>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <input type="text" name="name" class="form-control" id="name" required value="{{ $operator_group->name ?? null }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            @foreach($module as $value)
                <div class="module-list parent">
                    <div><i class="{{$value->mod_icon}}"></i> {{$value->mod_name}}</div>
                </div>
                @if(count((array)$value->detail)>0)
                    @foreach($value->detail as $child)
                        <div class="module-list">
                            <div>{{$child->mod_name}}</div>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input name="delete[]" type="checkbox" value="{{$child->modid}}" id="delete-{{$child->modid}}" class="form-check-input checkbox-delete">
                                    <label class="form-check-label" for="delete-{{$child->modid}}">delete</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="update[]" type="checkbox" value="{{$child->modid}}" id="update-{{$child->modid}}" class="form-check-input checkbox-update">
                                    <label class="form-check-label" for="update-{{$child->modid}}">update</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="create[]" type="checkbox" value="{{$child->modid}}" id="create-{{$child->modid}}" class="form-check-input checkbox-create">
                                    <label class="form-check-label" for="create-{{$child->modid}}">create</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="read[]" type="checkbox" value="{{$child->modid}}" id="read-{{$child->modid}}" class="form-check-input checkbox-read">
                                    <label class="form-check-label" for="read-{{$child->modid}}">read</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="module-list">
                        <div>{{$value->mod_name}}</div>
                        <div>
                            <div class="form-check form-check-inline">
                                <input name="delete[]" type="checkbox" value="{{$value->modid}}" id="delete-{{$value->modid}}" class="form-check-input checkbox-delete">
                                <label class="form-check-label" for="delete-{{$value->modid}}">delete</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="update[]" type="checkbox" value="{{$value->modid}}" id="update-{{$value->modid}}" class="form-check-input checkbox-update">
                                <label class="form-check-label" for="update-{{$value->modid}}">update</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="create[]" type="checkbox" value="{{$value->modid}}" id="create-{{$value->modid}}" class="form-check-input checkbox-create">
                                <label class="form-check-label" for="create-{{$value->modid}}">create</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="read[]" type="checkbox" value="{{$value->modid}}" id="read-{{$value->modid}}" class="form-check-input checkbox-read">
                                <label class="form-check-label" for="read-{{$value->modid}}">read</label>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 text-center">
            <input type="hidden" name="guid" value="{{ $operator_group->guid ?? null }}">
            <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
        </div>
    </div>
</form>
<script type="application/javascript">
    $(function(){

        let role_read 	= {!! $operator_group->read !!};
        let role_create = {!! $operator_group->create !!};
        let role_alter 	= {!! $operator_group->update !!};
        let role_drop 	= {!! $operator_group->delete !!};

        if(role_read[0] === '*')
        {
            $('.checkbox-read').prop('checked', true)
        }
        else
        {
            $.each(role_read, function(i,v){
                $('#read-'+v).prop('checked', true)
            })
        }

        if(role_create[0] === '*')
        {
            $('.checkbox-create').prop('checked', true)
        }
        else
        {
            $.each(role_create, function(i,v){
                $('#read-'+v).prop('checked', true)
                $('#create-'+v).prop('checked', true)
            })
        }

        if(role_alter[0] === '*')
        {
            $('.checkbox-update').prop('checked', true)
        }
        else
        {
            $.each(role_alter, function(i,v){
                $('#read-'+v).prop('checked', true)
                $('#update-'+v).prop('checked', true)
            })
        }

        if(role_drop[0] === '*')
        {
            $('.checkbox-delete').prop('checked', true)
        }
        else
        {
            $.each(role_drop, function(i,v){
                $('#read-'+v).prop('checked', true)
                $('#delete-'+v).prop('checked', true)
            })
        }

        $('input:checkbox').click(function(){
            let value = $(this).val()
            if($(this).attr('name') == 'create[]' || $(this).attr('name') == 'update[]' || $(this).attr('name') == 'delete[]'){
                if(!$('#read-'+value).is(':checked')){
                    $('#read-'+value).prop('checked', true)
                }
            }
            if($(this).attr('name') == 'read[]'){
                if(!$(this).is(':checked')){
                    $('#create-'+value).prop('checked', false)
                    $('#update-'+value).prop('checked', false)
                    $('#delete-'+value).prop('checked', false)
                }
            }
        })

        App.init()
    })
</script>
