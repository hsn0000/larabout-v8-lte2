(function () {

    let router = (function () {

        let routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"sanctum\/csrf-cookie","name":"generated::IvdOaaNGZCU4DObv","action":"Laravel\Sanctum\Http\Controllers\CsrfCookieController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"captcha\/api\/{config?}","name":"generated::3YOjV2PCZsJctPVF","action":"\Mews\Captcha\CaptchaController@getCaptchaApi"},{"host":null,"methods":["GET","HEAD"],"uri":"captcha\/{config?}","name":"generated::E95Gg4M8mVZC61GL","action":"\Mews\Captcha\CaptchaController@getCaptcha"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":"generated::5djjAjVVLDU5Fsnn","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"debug","name":"generated::rHitkODt8JUDKuTU","action":"Closure"},{"host":null,"methods":["POST"],"uri":"api\/auth\/do-login","name":"auth.do_login","action":"Modules\Auth\Http\Controllers\AuthController@do_login"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/logout","name":"auth.logout","action":"Modules\Auth\Http\Controllers\AuthController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/login","name":"auth.login","action":"Modules\Auth\Http\Controllers\AuthController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/refresh-captcha\/{config?}","name":"auth.refresh_captcha","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/home","name":"generated::JKMOzfSAO4EtwlEa","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home.dashboard","action":"Modules\Home\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"modules","name":"modules","action":"Modules\Modules\Http\Controllers\ModulesController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"modules\/add","name":"modules.add","action":"Modules\Modules\Http\Controllers\ModulesController@add"},{"host":null,"methods":["POST"],"uri":"modules\/save","name":"modules.save","action":"Modules\Modules\Http\Controllers\ModulesController@save"},{"host":null,"methods":["GET","HEAD"],"uri":"modules\/edit\/{id}","name":"modules.edit","action":"Modules\Modules\Http\Controllers\ModulesController@edit"},{"host":null,"methods":["POST"],"uri":"modules\/update","name":"modules.update","action":"Modules\Modules\Http\Controllers\ModulesController@update"},{"host":null,"methods":["POST"],"uri":"modules\/update-order","name":"modules.update-order","action":"Modules\Modules\Http\Controllers\ModulesController@update_order"},{"host":null,"methods":["POST"],"uri":"modules\/update-published","name":"modules.update-published","action":"Modules\Modules\Http\Controllers\ModulesController@update_published"},{"host":null,"methods":["GET","HEAD","POST","PUT","PATCH","DELETE","OPTIONS"],"uri":"operator","name":"operator","action":"Modules\Operator\Http\Controllers\OperatorController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"operator\/add","name":"operator.add","action":"Modules\Operator\Http\Controllers\OperatorController@add"},{"host":null,"methods":["POST"],"uri":"operator\/save","name":"operator.save","action":"Modules\Operator\Http\Controllers\OperatorController@save"},{"host":null,"methods":["GET","HEAD"],"uri":"operator\/edit\/{id}","name":"operator.edit","action":"Modules\Operator\Http\Controllers\OperatorController@edit"},{"host":null,"methods":["POST"],"uri":"operator\/update","name":"operator.update","action":"Modules\Operator\Http\Controllers\OperatorController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"operator\/delete\/{id}","name":"operator.delete","action":"Modules\Operator\Http\Controllers\OperatorController@delete"},{"host":null,"methods":["POST"],"uri":"operator\/update-active","name":"operator.update-active","action":"Modules\Operator\Http\Controllers\OperatorController@update_active"},{"host":null,"methods":["GET","HEAD","POST","PUT","PATCH","DELETE","OPTIONS"],"uri":"operator-group","name":"operator-group","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"operator-group\/add","name":"operator-group.add","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@add"},{"host":null,"methods":["POST"],"uri":"operator-group\/save","name":"operator-group.save","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@save"},{"host":null,"methods":["GET","HEAD"],"uri":"operator-group\/edit\/{id}","name":"operator-group.edit","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@edit"},{"host":null,"methods":["POST"],"uri":"operator-group\/update","name":"operator-group.update","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"operator-group\/delete\/{id}","name":"operator-group.delete","action":"Modules\OperatorGroup\Http\Controllers\OperatorGroupController@delete"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                let uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                let uri = this.replaceNamedParameters(route.uri, parameters);
                let qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        let value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                let qs = [];
                for (let key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (let key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (let key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                let url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        let getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            let attrs = [];
            for (let key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        let getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // router.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // router.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // router.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // router.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // router.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                let url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // router.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                let url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return router;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = router;
    }
    else {
        window.router = router;
    }

}).call(this);