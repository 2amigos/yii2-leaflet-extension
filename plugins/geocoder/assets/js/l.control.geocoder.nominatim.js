L.Control.Geocoder.Nominatim = L.Class.extend({
    options: {
        serviceUrl: 'http://nominatim.openstreetmap.org/',
        geocodingQueryParams: {},
        reverseQueryParams: {}
    },

    initialize: function(options) {
        L.Util.setOptions(this, options);
    },

    geocode: function(query, cb, context) {
        L.Control.Geocoder.jsonp(this.options.serviceUrl + 'search/', L.extend({
            q: query,
            limit: 5,
            format: 'json'
        }, this.options.geocodingQueryParams),
            function(data) {
                var results = [];
                for (var i = data.length - 1; i >= 0; i--) {
                    var bbox = data[i].boundingbox;
                    for (var j = 0; j < 4; j++) bbox[j] = parseFloat(bbox[j]);
                    results[i] = {
                        icon: data[i].icon,
                        name: data[i].display_name,
                        bbox: L.latLngBounds([bbox[0], bbox[2]], [bbox[1], bbox[3]]),
                        center: L.latLng(data[i].lat, data[i].lon)
                    };
                }
                cb.call(context, results);
            }, this, 'json_callback');
    },

    reverse: function(location, scale, cb, context) {
        L.Control.Geocoder.jsonp(this.options.serviceUrl + 'reverse/', L.extend({
            lat: location.lat,
            lon: location.lng,
            zoom: Math.round(Math.log(scale / 256) / Math.log(2)),
            format: 'json'
        }, this.options.reverseQueryParams), function(data) {
            var result = [],
                loc;

            if (data && data.lat && data.lon) {
                loc = L.latLng(data.lat, data.lon);
                result.push({
                    name: data.display_name,
                    center: loc,
                    bounds: L.latLngBounds(loc, loc)
                });
            }

            cb.call(context, result);
        }, this, 'json_callback');
    }
});

L.Control.Geocoder.nominatim = function(options) {
    return new L.Control.Geocoder.Nominatim(options);
};