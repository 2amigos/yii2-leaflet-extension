L.Control.Geocoder.RaveGeo = L.Class.extend({
    options: {
        querySuffix: '',
        deepSearch: true,
        wordBased: false
    },

    jsonp: function(params, callback, context) {
        var callbackId = '_l_geocoder_' + (L.Control.Geocoder.callbackId++),
            paramParts = [];
        params.prepend = callbackId + '(';
        params.append = ')';
        for (var p in params) {
            paramParts.push(p + '=' + escape(params[p]));
        }

        window[callbackId] = L.Util.bind(callback, context);
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = this._serviceUrl + '?' + paramParts.join('&');
        script.id = callbackId;
        document.getElementsByTagName('head')[0].appendChild(script);
    },

    initialize: function(serviceUrl, scheme, options) {
        L.Util.setOptions(this, options);

        this._serviceUrl = serviceUrl;
        this._scheme = scheme;
    },

    geocode: function(query, cb, context) {
        L.Control.Geocoder.jsonp(this._serviceUrl, {
            address: query + this.options.querySuffix,
            scheme: this._scheme,
            outputFormat: 'jsonp',
            deepSearch: this.options.deepSearch,
            wordBased: this.options.wordBased
        }, function(data) {
            var results = [];
            for (var i = data.length - 1; i >= 0; i--) {
                var r = data[i],
                    c = L.latLng(r.y, r.x);
                results[i] = {
                    name: r.address,
                    bbox: L.latLngBounds([c]),
                    center: c
                };
            }
            cb.call(context, results);
        }, this);
    }
});

L.Control.Geocoder.raveGeo = function(serviceUrl, scheme, options) {
    return new L.Control.Geocoder.RaveGeo(serviceUrl, scheme, options);
};