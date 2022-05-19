try {
    global.$ = global.jQuery = window.$ = window.jQuery = require('jquery');
    global._ = require('lodash');

    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */

    global.axios = require('axios');
    global.axios.defaults.headers.common = {
        'X-Requested-With' : 'XMLHttpRequest',
        // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }

    let moment = require('moment')
    global.moment = moment
    if("default" in moment) {
        global.moment = moment['default']
    }

    require('bootstrap')
    require('fastclick')
    require('jquery-price-format');
    require('daterangepicker');
    require('bootstrap-datepicker')
    require('admin-lte')
    require('fullcalendar')
    require('select2')
    require('jquery-toast-plugin')
    require('datatables.net')
    require('datatables.net-bs')
    require('datatables.net-responsive-bs')
    require('easy-autocomplete')
    require('iframe-resizer')
} catch(e) {
    console.error('failed to load sript',e)
}
