require('./bootstrap')

import ClipboardJS from "clipboard"
import Swal from 'sweetalert2'
import * as laravel_route from './router'

/* boot script
------------------------------------------------ */

/* 1. input money format
------------------------------------------------ */
const inputMoney = function ()
{
    $(".currency").priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 0
    })
}

/* 2. input number format
------------------------------------------------ */
const inputNumber = function ()
{
    $(".number").keydown(function(e)
    {
        const key = e.charCode || e.keyCode || 0
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
        return (
            key === 8 ||
            key === 9 ||
            key === 13 ||
            key === 46 ||
            key === 110 ||
            key === 190 ||
            (key >= 35 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105))
    })
}

/* 3. dataHref
------------------------------------------------ */
const initDataHref = function ()
{
    $('[data-href]').click(function () {
        const href = $(this).data('href')
        window.location.replace(href)
    })
}

/* 4. datepicker
------------------------------------------------ */
const initDaterPicker = function ()
{
    const date = new Date()
    date.setDate(date.getDate()-7)

    const end_date = new Date()
    end_date.setDate(end_date.getDate())

    const ranges = {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')]
    }

    $('[daterangepicker]').daterangepicker({
        autoUpdateInput: false,
        maxDate: end_date,
        autoApply: true,
        ranges: ranges,
        showDropdowns: true,
        alwaysShowCalendars: true
    }, function(start, end) {
        $('[daterangepicker]').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'))
    })

    $('[datetimerangepicker]').daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        showSecond: true,
        maxDate: end_date,
        ranges: ranges,
        showDropdowns: true,
        locale: {
            format: 'M/DD/YYYY HH:mm:ss'
        },
        alwaysShowCalendars: true
    }, function(start, end) {
        $('[datetimerangepicker]').val(start.format('M/DD/YYYY HH:mm:ss') + ' - ' + end.format('M/DD/YYYY HH:mm:ss'))
    })

    $('[daterangepicker-last-week]').daterangepicker({minDate: date,maxDate: end_date})

    $('[datepicker]').daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        singleDatePicker: true,
        showDropdowns:true,
        opens: "left"
    })

    $('[datepicker-modal]').daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        singleDatePicker: true,
        showDropdowns:true,
        opens: "left",
        container:'#auto-modal modal-body'
    })

    $('[datepicker-dob]').daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        singleDatePicker: true,
        showDropdowns:true,
        opens: "left",
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        container:'#auto-modal modal-body'
    }, function(start) {
        $('[datepicker-dob]').val(start.format('YYYY-MM-DD'))
    })

    if($('[datepicker-dob]').val() !== undefined)
    {
        const date = moment(new Date($('[datepicker-dob]').val()))
        $('[datepicker-dob]').val(date.format('YYYY-MM-DD'))
    }

    $('[datepicker-view-month]').datepicker({
        autoclose: true,
        endDate: '0',
        format: 'yyyy-mm',
        defaultViewDate: 'month',
        minViewMode: 1
    });
}

/* 5. hide loading
------------------------------------------------ */
const hideLoading = function ()
{
    $('.page-loader').fadeOut()
}

/* 6. show loading
------------------------------------------------ */
const showLoading = function ()
{
    $('.page-loader').fadeIn()
}

/* 7. required form
------------------------------------------------ */
const requiredFrom = function ()
{
    $('.required').each(function(){
        $(this).append('&nbsp<span class="required-text">*</span>')
    })
}

/* 8. copyToClipboard
------------------------------------------------ */
let clipboard = null
let clipboard_modal = null

const copyToClipboard = function ()
{
    if(clipboard !== null)
    {
        clipboard.destroy()
        clipboard_modal.destroy()
    }

    clipboard = new ClipboardJS('.btn-copy')
    clipboard_modal = new ClipboardJS('.btn-copy-modal', {
        container: document.getElementById('auto-modal')
    })

    clipboard.on('success', function(e) {
        toast_alert.msg_success('Copied!','Success Copy To Clipboard!')
        e.clearSelection()
    })
    clipboard_modal.on('success', function(e) {
        toast_alert.msg_success('Copied!','Success Copy To Clipboard!')
        e.clearSelection()
    })

    clipboard.on('error', function(e) {
        toast_alert.msg_error('Copy Failed!',e)
    })
    clipboard_modal.on('error', function(e) {
        toast_alert.msg_error('Copy Failed!',e)
    })
}

/* 9. showPassword
------------------------------------------------ */
const showPassword = function ()
{
    $('.show-password').click(function () {
        const target    = $($(this).data('target'))
        const icon      = $(this).children()

        if (target.attr("type") === "password"){
            target.attr("type", "text")
            icon.removeClass('fa-eye-slash')
            icon.addClass('fa-eye')
        } else {
            target.attr("type", "password")
            icon.removeClass('fa-eye')
            icon.addClass('fa-eye-slash')
        }
    })
}

/* 10. sidebar scroll
------------------------------------------------ */
const sidebarScroll = function () {
    const sidebar = $('.sidebar-scroll')
    let max_height = $(window).innerHeight()-50-105-65-37

    sidebar.height(max_height)
    sidebar.css('overflow-y','auto')
};

/* 11. in array library
------------------------------------------------ */
const inArray =  function (value, array) {
    return array.indexOf(value) > -1;
}

/* 12. select 2 load
------------------------------------------------ */
function formatIcon (icon) {
    if (!icon.id) {
        return icon.text;
    }

    return $(
        '<span><i class="fa ' + icon.element.value.toLowerCase() + '"></i>' + icon.text + '</span>'
    );
}

const select2 =  function () {
    $('[select-search]').select2();
    $('[select-search-modal]').select2({ dropdownParent: ".modal" });
    $('[select-search-icon]').select2({ dropdownParent: ".modal" ,templateResult: formatIcon});
}

/* 13 popup window
------------------------------------------------ */
function popupWindow(url, title, w, h) {
    let left = (screen.width/2)-(w/2)
    let top = (screen.height/2)-(h/2)
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left)
}

/* 14. easy autocomplete
------------------------------------------------ */
const easyAutocomplete = function () {
    const options_user = {
        url: "/api/get-user",
        listLocation: "data",
        getValue: "username",
        list: {
            showAnimation: {
                type: "normal", //normal|slide|fade
                time: 400,
                callback: function() {

                }
            },
            hideAnimation: {
                type: "normal", //normal|slide|fade
                time: 400,
                callback: function() {}
            },
            maxNumberOfElements: 10,
            match: {
                enabled: true
            }
        }
    }

    $(".search-username").easyAutocomplete(options_user)
};

/* 16. file manager button
------------------------------------------------ */
const fileManager = function () {
    // $('[file-manager]').filemanager('file')
};


/* 17. iframe resize
------------------------------------------------ */
const iframeResize = function () {
    $('[iframe-resize]').iFrameResize({
        autoResize:true,
    })
};

/** global const **/
/* 1. init modal
------------------------------------------------ */
const modal = {
    init: function(title,body,footer,size){
        if(!size || (size !== 'modal-lg' && size !== 'modal-sm' && size !== 'modal-md')){
            size = 'modal-md'
        }
        const modal = $('#auto-modal')
        modal.find('.modal-dialog').removeClass('modal-sm modal-md modal-lg ').addClass(size)
        modal.modal({
            backdrop: false
        })

        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html(body)
        if(footer){
            modal.find('.modal-footer').show()
        }
    }
}

/* 2. alert popup
------------------------------------------------ */
const pop_alert = {
    msg_error: function (msg,callback)
    {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: msg,
            confirmButtonColor: '#364a6e',
        }).then(callback)
    },
    msg_success: function (msg,callback)
    {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: msg,
            confirmButtonColor: '#364a6e',
        }).then(callback)
    },
    msg_info: function (msg,callback)
    {
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: msg,
            confirmButtonColor: '#364a6e',
        }).then(callback)
    },
    msg_confirm: function (msg,callback)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Confirm',
            confirmButtonColor: '#364a6e',
            cancelButtonText: 'Cancel',
        }).then(callback)
    }
}

/* 3. alert toast
------------------------------------------------ */
const toast_alert = {
    msg_error: function (title,msg)
    {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: 'error',
            position: 'top-right',
            stack: 4
        })
    },
    msg_success: function (title,msg)
    {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: 'success',
            position: 'top-right',
            stack: 4
        })
    },
    msg_info: function (title,msg)
    {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: 'info',
            position: {
                right: 5,
                top: 60
            }
        })
    },
    msg_warning: function (title,msg)
    {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: 'warning',
            position: 'top-right',
            stack: 4
        })
    }
}

/* 4. csrf token
------------------------------------------------ */
const csrf = $('meta[name="csrf-token"]').attr('content')

/* 5. http_request
------------------------------------------------ */
const http_request = async (method = 'get',url = '',param = []) => {
    try {
        if(!inArray(method,['get','post','put','patch','delete','head','options']))
        {
            return {success:false,error:{message:'invalid method!'}}
        }

        return (await axios.request({
            method: method,
            url: url,
            data:param
        })).data
    }
    catch (error)
    {
        return error.response.data
    }
}

/* 6. object to query string
------------------------------------------------ */
const object_to_query_string = function (obj) {
    let str = [];
    for (let p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

/* 7. router helper
------------------------------------------------ */
const route = function (route, parameters) {
    return laravel_route.route(route, parameters)
}

/* 8. alert
------------------------------------------------ */
const alert_tag = {
    msg_error: function (title,msg)
    {
        return "<div class=\"alert alert-error alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>"+title+"</strong> "+msg+"</div>"
    },
    msg_success: function (title,msg)
    {
        return "<div class=\"alert alert-success alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>"+title+"</strong> "+msg+"</div>"
    },
    msg_info: function (title,msg)
    {
        return "<div class=\"alert alert-info alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>"+title+"</strong> "+msg+"</div>"
    },
    msg_warning: function (title,msg)
    {
        return "<div class=\"alert alert-warning alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>"+title+"</strong> "+msg+"</div>"
    }
}

/* global variable define
------------------------------------------------ */
global.modal = modal
global.pop_alert = pop_alert
global.toast_alert = toast_alert
global.csrf = csrf
global.http_request = http_request
global.showLoading = showLoading
global.hideLoading = hideLoading
global.object_to_query_string = object_to_query_string
global.popupWindow = popupWindow
global.router = laravel_route
global.route = route
global.alert_tag = alert_tag
global.inputMoney = inputMoney
global.inputNumber = inputNumber

/*
 * set default config data tables
 */
$.extend( $.fn.dataTable.defaults, {
    searching : false,
    lengthChange : false,
    order: [[ 0, "desc" ]],
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.modal( {
                header: function () {
                    return 'Details Table';
                }
            }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                tableClass: 'table table-striped'
            })
        }
    }
})
/* end const */

/* main function */
const App = function () {
    return {
        init: function () {
            inputMoney()
            inputNumber()
            initDataHref()
            initDaterPicker()
            requiredFrom()
            copyToClipboard()
            showPassword()
            sidebarScroll()
            select2()
            easyAutocomplete()
            fileManager()
            iframeResize()
        }
    }
}()

global.App = App

$(function(){
    App.init()
})
