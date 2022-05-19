const loading = $('.loading')
const table_container = $('.table-container')
const table = $('#table-operator-group')
const body = $('body')

const render_table = async () => {
    /*
     * show loading and hide table
     */
    loading.show()
    table_container.hide()

    if(!!$.fn.dataTable.isDataTable(table))
    {
        /*
         * destroy data table if instance already created
         */
        table.dataTable().fnDestroy();
    }

    /*
     * function for generate table data
     */
    let title = $(document).attr('title')
    let table_action = $('#table-action-operator-group')
    let form_filter = table_action.find('.form-control')
    let data_filter = {}

    if(form_filter.length > 0)
    {
        $.each(form_filter,function (key,val) {
            let obj_filter = $(val)
            let name = obj_filter.attr('name')
            data_filter[name] = obj_filter.val() ?? null
        })
    }

    table.DataTable( {
        processing: true,
        serverSide: true,
        pageLength: data_filter.length,
        ajax: {
            url : route('operator-group'),
            type : "POST" ,
            data : data_filter,
            beforeSend : function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", csrf);
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'guid',className: 'text-center',width:'3%'},
            {data: 'name', name: 'name'},
            {data: 'total_operator', name: 'total_operator'},
            {data: 'read', name: 'read', orderable: false, searchable: false},
            {data: 'create', name: 'create', orderable: false, searchable: false},
            {data: 'update', name: 'update', orderable: false, searchable: false},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false,width:'5%',className: "text-center" },
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        let data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table table-striped'
                })
            }
        },
        initComplete: function() {
            loading.hide()
            table_container.show()
        }
    })

    window.history.pushState({},title, route('operator-group',data_filter))

    /*
     * reload jquery initiation
     */
    App.init()
}

$(document).ready(async () => {
    /**
     * render initial table
     */
    await render_table()

    /**
     * button filter clicked
     */
    body.on('click','.btn-filter', async () => {
        await render_table()
    })

    /**
     * button add clicked
     */
    body.on('click','.btn-add', async () => {
        /*
         * hide modal responsive data table
         */
        $('.dtr-bs-modal').trigger('click.dismiss.bs.modal')

        /*
         * get form data
         */
        const response = await http_request('get',route('operator-group.add'))

        if(!!response.success)
        {
            modal.init(response.data.title ?? 'Modal',response.data.form ?? '',false,'modal-lg')
        }
        else
        {
            pop_alert.msg_error(response.error?.message ?? response.message ?? 'Internal server error!')
        }
    })

    /**
     * on button edit clicked
     */
    body.on('click','.btn-edit', async () => {
        /*
         * hide modal responsive data table
         */
        $('.dtr-bs-modal').trigger('click.dismiss.bs.modal')

        const btn_edit = $(event.target)
        const id = btn_edit.data('id') ?? btn_edit.parent().data('id')

        /*
         * get form data
         */
        const response = await http_request('get',route('operator-group.edit',{id:id}))

        if(!!response.success)
        {
            modal.init(response.data.title ?? 'Modal',response.data.form ?? '')
        }
        else
        {
            pop_alert.msg_error(response.error?.message ?? response.message ?? 'Internal server error!')
        }
    })

    /**
     * on button delete clicked
     */
    body.on('click','.btn-delete', async () => {
        /*
         * hide modal responsive data table
         */
        $('.dtr-bs-modal').trigger('click.dismiss.bs.modal')

        const btn_delete = $(event.target)
        const id = btn_delete.data('id') ?? btn_delete.parent().data('id')

        pop_alert.msg_confirm('are you sure to delete this operator Group?',async (callback) => {

            if(!!callback.isConfirmed)
            {
                /*
                 * if confirmed
                 */

                /*
                 * get form data
                 */
                const response = await http_request('get',route('operator-group.delete',{id:id}))

                if(!!response.success)
                {
                    toast_alert.msg_success('Success!',response.data.message)
                }
                else
                {
                    toast_alert.msg_error('Error!',response.error?.message ?? response.message ?? 'Internal server error!')
                }

                /*
                 * re render table
                 */
                await render_table()
            }
        })
    })
})
