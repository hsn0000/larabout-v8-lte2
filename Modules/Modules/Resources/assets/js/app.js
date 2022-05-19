/**
* load short js and init for table
*/
import Sortable from "sortablejs";

const sortChange = async() => {
    let child_order = {}
    let parent_order = {}
    let parent = $('.parent')

    $.each(parent, function(key,value) {
        parent_order[key] = $(value).data('id')

        if($(value).find('.child').length > 0) 
        {
            let tmp_child_order = {}
            let child = $(value).find('.child')

            $.each(child,function(keys,values) {
                tmp_child_order[keys] = $(values).data('id')
            })

            child_order[key] = tmp_child_order
        }
    })

    const response = await http_request('post',route('modules.update-order'),{parent:parent_order,child:child_order});

    if(!!response.success)
    {
        toast_alert.msg_success('Success !',response.data.message)
    }
    else
    {
        toast_alert.msg_error('Error !',response.error.message ?? 'Internal server error')
    }
}

const nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'))
for(let i = 0; i < nestedSortables.length; i++) {
    new Sortable(nestedSortables[i], {
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onEnd: sortChange
    })
}

const body = $('body')

/**
 * handler action from web
 */
$(function () {

    /**
     * button add action
     */
    body.on('click','.btn-add', async () => {
        /*
         * get form data
         */
        const response = await http_request('get',route('modules.add'))

        if(!!response.success)
        {
            modal.init(response.data.tittle ?? 'Modal',response.data.form ?? '')
        }
        else
        {
            pop_alert.msg_error(response.error.message ?? 'Internal server error!')
        }
    })

    /**
     * button edit action
     */
    body.on('click','.btn-edit', async () => {
        /*
         * define variable
         */
        let modid = $(event.target).data('id') ?? $(event.target).parent().data('id')

        /*
         * get form data
         */
        const response = await http_request('get',route('modules.edit',{id:modid}))

        if(!!response.success)
        {
            modal.init(response.data.tittle ?? 'Modal',response.data.form ?? '')
        }
        else
        {
            pop_alert.msg_error(response.error.message ?? 'Internal server error!')
        }
    })

    /**
     * button edit publish status
     */
    body.on('click','.btn-publish', async () => {

        let btn_publish = $(event.target)
        let modid = btn_publish.data('id') ?? btn_publish.parent().data('id')
        let published = btn_publish.data('published') ?? btn_publish.parent().data('published')
        published = published === 'n' ? 'y' : 'n'
        
        /*
        * get form data
        */
       const response = await http_request('post',route('modules.update-published'),{modid:modid,published:published})
       
       if(!!response.success)
       {
           let container_elem = $('.parent-'+modid).length > 0 ? $('.parent-'+modid) :  $('.child-'+modid)
           let elem = btn_publish.data('id') ? btn_publish : btn_publish.parent()

           btn_publish.data('published',published) ?? btn_publish.parent().data('published',published)

           if(published === 'y')
            {
                container_elem.removeClass('disable')
                elem.find('i').addClass('fa-eye')
                elem.find('i').removeClass('fa-eye-slash')
            }
            else
            {
                container_elem.addClass('disable')
                elem.find('i').removeClass('fa-eye')
                elem.find('i').addClass('fa-eye-slash')
            }

            toast_alert.msg_success('Success!',response.data.message)
        }
        else
        {
            toast_alert.msg_error('Error!',response.error.message ?? 'Internal server error!')
        }
    })
})
