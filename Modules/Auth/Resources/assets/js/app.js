$(function () {

    /*
     * handling login with press enter
     */
    $(window).on("keypress", function (e) {

        if (e.keyCode == 13 && $(e.target).hasClass('form-control')) {
            /*
             * handling enter onkeypress
             */

            const username  = $('#form-login input[name="username"]').val()
            const password  = $('#form-login input[name="password"]').val()
            const captcha   = $('#form-login input[name="captcha"]').val()

            if(username !== '' && password !== '' && captcha !== '')
            {
                /*
                 * if all form insert
                 */
                e.preventDefault()
                $('.do-login').click()
            }
        }
    });

    /**
     * for refresh captcha
     */
    $('.captcha-refresh a').click(function (){
        const img = $('.captcha-image img')

        axios.get('/auth/refresh-captcha')
            .then(function (response) {
                /* replace src img */
                img.attr('src',response.data)
            })
            .catch(function (error) {
                pop_alert.msg_error('Failed To Load Captcha!')
            });
    });

    /**
     * for do login process
     */
    $('.do-login').click(function (){
        const username  = $('#form-login input[name="username"]').val()
        const password  = $('#form-login input[name="password"]').val()
        const captcha   = $('#form-login input[name="captcha"]').val()
        const all_input = $('input')
        const loading   = $('.loading')
        const submit   = $('.do-login')
        let post = {}

        /* define post data */
        post.username = username
        post.password = password
        post.captcha  = captcha

        /* init process */
        submit.attr('disabled',true)
        all_input.attr('disabled',true)
        loading.css('display', 'inline-block')

        if(username === '' || password === '' || captcha === '')
        {
            pop_alert.msg_error('All Fields Must Be Filled!',function (){
                /* return to default condition form */

                submit.attr('disabled',false)
                all_input.attr('disabled',false)
                loading.css('display','none')

                /*  refresh captcha */
                $('.captcha-refresh a').click()
            })
            return
        }

        axios.post('/api/auth/do-login',post)
        .then(function (response) {
            /* if curl success */

            /* check response data */
            if(!!response.data.data.success_login)
            {
                /* if login success */

                /* show aller error */
                pop_alert.msg_success(response.data.data.message,function (){

                    return window.location.href = '/'

                });

            }
            else
            {

                /* if login failed */

                /* show aller error */
                pop_alert.msg_error(response.data.data.message)
            }

        })
        .catch(function (error) {
            /* if curl failed */

            /* define error message */
            const error_message = error.response.data.error?.error_message === undefined ? error : error.response.data.error?.error_message

            /* show aller error */
            pop_alert.msg_error(error_message)

            /* return to default condition form */

            submit.attr('disabled',false)
            all_input.attr('disabled',false)
            loading.css('display','none')

            /*  refresh captcha */
            $('.captcha-refresh a').click()
        })
        .finally(function (){
            // submit.attr('disabled',true)
            all_input.attr('disabled',false)
            loading.css('display','none')
            
            /*  refresh captcha */
            $('.captcha-refresh a').click()
              return window.location.href = '/'
        })
    })
})
