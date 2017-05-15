/**
 * @package Google Map server side Markers clustering v2.0
 * @author Igor Karpov <mail@noxls.net>
 * 
 */

 var nxIK = {
    total_elementos: [],
    tag_eliminar:"",
    buscador: 0,
    search: [],
    marcador: [],
    markers: [],
    knnmarkers: [],
    map: undefined,
    infowindow: undefined,
    debugMarker: undefined,
    debuginfo: undefined,
    geocoder: new google.maps.Geocoder(),
    knn: false,
    knn_K: 5,
    debug: {
        showGridLines: false,
        showBoundaryMarker: false
    },
    async: {
        lastSendGetMarkers: 0,
        lastReceivedGetMarkers: 0,
        lastSendMarkerDetail: 0,
        lastReceivedMarkerDetail: 0,
        lastCache: ""
    },
    log: function (s) {
        if (console.log) {
            console.log(s)
        }
    },
    round: function (num, decimals) {
        return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals)
    },
    zoomIn: function () {
        var z = nxIK.map.getZoom();
        nxIK.map.setZoom(z + 1)
    },
    zoomOut: function () {
        var z = nxIK.map.getZoom();
        nxIK.map.setZoom(z - 1)
    },

    mymap: {
        initialize: function () {
            var marker_id = getUrlParameter('id');

            if(marker_id) {
                ++nxIK.async.lastSendMarkerDetail;

                var getParams = "?action=get-marker-info&" + "id=" + marker_id + "&" + "sid=" + nxIK.async.lastSendMarkerDetail;

                $.ajax({
                    type: 'GET',
                    url: nxIK.mymap.settings.jsonGetMarkerInfoUrl + getParams,
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success: function (data) {
                        nxIK.findMarker(data.Lat, data.Lon);

                    },
                    error: function (xhr, err) {
                        var msg = "readyState: " + xhr.readyState + "\nstatus: " + xhr.status + "\nresponseText: " + xhr.responseText + "\nerr:" + err;
                        nxIK.log(msg);
                        alert(nxIK.mymap.settings.textErrorMessage)
                    }
                })
            }


            if(!marker_id && AUTODETECT_MAP_CENTER && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var center = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);
                    nxIK.map.setCenter(center);
                });
            }
            var center = new google.maps.LatLng(nxIK.mymap.settings.mapCenterLat, nxIK.mymap.settings.mapCenterLon, true);
            nxIK.map = new google.maps.Map(document.getElementById('nxIK_map'), {
                zoom: nxIK.mymap.settings.zoomLevel,
                center: center,
                scrollwheel: true,
                navigationControl: true,
                mapTypeControl: true,
                draggable: true,
                scaleControl: true,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId[nxIK.mymap.settings.map_type_id],
                backgroundColor: '#fff',
                draggableCursor: 'move',
                minZoom: nxIK.mymap.settings.min_zoomLevel,
                maxZoom: nxIK.mymap.settings.max_zoomLevel
            });
            google.maps.event.addListener(nxIK.map, 'idle', function () {
                nxIK.mymap.events.getBounds(false)
            });
            google.maps.event.addListener(nxIK.map, 'zoom_changed', function () {});
            google.maps.event.trigger(nxIK.map, 'zoom_changed')
        },
        settings: MAP_SETTINGS,
        events: {
            getBounds: function (forceUpdate) {
                if (nxIK.infowindow === undefined) {
                    nxIK.infowindow = new google.maps.InfoWindow()
                }
                var bounds = nxIK.map.getBounds();
                var NE = bounds.getNorthEast();
                var SW = bounds.getSouthWest();
                var mapData = [];
                mapData.neLat = nxIK.round(NE.lat(), 7);
                mapData.neLon = nxIK.round(NE.lng(), 7);
                mapData.swLat = nxIK.round(SW.lat(), 7);
                mapData.swLon = nxIK.round(SW.lng(), 7);
                mapData.zoomLevel = nxIK.map.getZoom();
                if (nxIK.debug.showBoundaryMarker) {
                    var center = nxIK.map.getCenter();
                    if (nxIK.debugMarker === undefined) {
                        nxIK.debugMarker = new google.maps.Marker({
                            position: center,
                            map: nxIK.map,
                            zIndex: 1
                        })
                    }
                    if (nxIK.debuginfo === undefined) {
                        nxIK.debuginfo = new google.maps.InfoWindow()
                    }
                    nxIK.debugMarker.setPosition(center);
                    var debugstr = center.lng() + '; ' + center.lat() + ' zoom: ' + nxIK.map.getZoom() + '<br />SW: ' + SW.lng() + ' ; ' + SW.lat() + '<br/>NE: ' + NE.lng() + ' ; ' + NE.lat();
                    nxIK.debuginfo.setContent(debugstr);
                    nxIK.debuginfo.open(nxIK.map, nxIK.debugMarker)
                }
                var _ = "_";
                var cache = mapData.neLat + _ + mapData.neLon + _ + mapData.swLat + _ + mapData.swLon + _ + mapData.zoomLevel;
                if (nxIK.async.lastCache === cache && forceUpdate === false) return;
                nxIK.async.lastCache = cache;
                nxIK.mymap.events.loadMarkers(mapData)
            },
            polys: [],
            loadMarkers: function (mapData) {
                if(nxIK.buscador==0){
                    var clusterImg = new google.maps.MarkerImage(nxIK.mymap.settings.clusterImage.src, new google.maps.Size(nxIK.mymap.settings.clusterImage.width, nxIK.mymap.settings.clusterImage.height), null, new google.maps.Point(nxIK.mymap.settings.clusterImage.offsetW, nxIK.mymap.settings.clusterImage.offsetH));
                    var pinImg = [];
                    for(var i in nxIK.mymap.settings.pinImage) {
                        pinImg[i] = new google.maps.MarkerImage(nxIK.mymap.settings.pinImage[i].src, new google.maps.Size(nxIK.mymap.settings.pinImage[i].width, nxIK.mymap.settings.pinImage[i].height), null, null);
                    }
                    ++nxIK.async.lastSendGetMarkers;

                    var getParams = "?" + "action=get-markers&nelat=" + nxIK.dEscape(mapData.neLat) + "&" + "nelon=" + nxIK.dEscape(mapData.neLon) + "&" + "swlat=" + nxIK.dEscape(mapData.swLat) + "&" + "swlon=" + nxIK.dEscape(mapData.swLon) + "&" + "zoom=" + mapData.zoomLevel + nxIK.getFilterValues() + "&" + "sid=" + nxIK.async.lastSendGetMarkers;

                    $.ajax({
                        type: 'GET',
                        url: nxIK.mymap.settings.jsonGetMarkerUrl + getParams,
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        success: function (data) {
                            if (data.Ok === "0") {
                                nxIK.log(data.EMsg);
                                return
                            }
                            var lastReceivedGetMarkers = data.Rid;
                            if (lastReceivedGetMarkers <= nxIK.async.lastReceivedGetMarkers) {
                                nxIK.log('async mismatch ' + lastReceivedGetMarkers + ' ' + nxIK.async.lastReceivedGetMarkers);
                                return
                            }
                            nxIK.async.lastReceivedGetMarkers = lastReceivedGetMarkers;
                            var mia = "";
                            if (data.Mia > 0) {
                                mia = "<br/>&nbsp;Mia: " + data.Mia
                            }
                            $.each(nxIK.mymap.events.polys, function () {
                                this.setMap(null)
                            });
                            nxIK.mymap.events.polys.length = 0;
                            if (nxIK.debug.showGridLines === true && data.Polylines) {
                                $.each(data.Polylines, function () {
                                    var item = this;
                                    var x = item.X;
                                    var y = item.Y;
                                    var x2 = item.X2;
                                    var y2 = item.Y2;
                                    var nowrapIsFalse = false;
                                    var polyline = new google.maps.Polyline({
                                        path: [new google.maps.LatLng(y, x, nowrapIsFalse), new google.maps.LatLng(y2, x2, nowrapIsFalse)],
                                        strokeColor: "#f00",
                                        strokeOpacity: 1,
                                        strokeWeight: 2,
                                        map: nxIK.map
                                    });
                                    nxIK.mymap.events.polys.push(polyline)
                                })
                            }
                            var markersDrawTodo = nxIK.dynamicUpdateMarkers(data.Markers, nxIK.markers, nxIK.getKey, true);

                            $.each(markersDrawTodo, function () {
                                var item = this;
                                var lat = item.Y;
                                var lon = item.X;
                                var latLng = new google.maps.LatLng(lat, lon, true);
                                var iconImg;

                                if (item.C === 1) {
                                    if (pinImg[item.T]) {
                                        iconImg = pinImg[item.T];
                                    } else {
                                        iconImg = pinImg.pop();
                                    }
                                } else {
                                    iconImg = clusterImg;
                                }
                                var marker = new google.maps.Marker({
                                    position: latLng,
                                    map: nxIK.map,
                                    icon: iconImg,
                                    maivi: "none",
                                    zIndex: 1
                                });
                                var key = nxIK.getKey(item);
                                marker.set("key", key);
                                nxIK.marcador.push(marker);

                                if (item.C === 1) {
                                    google.maps.event.addListener(marker, 'click', function (event) {
                                        nxIK.mymap.events.popupWindow(marker, item)  ;
                                    })
                                } else {
                                    google.maps.event.addListener(marker, 'click', function (event) {
                                        var z = nxIK.map.getZoom();
                                        var n;
                                        if (z <= 8) {
                                            n = 3
                                        } else if (z <= 12) {
                                            n = 2
                                        } else {
                                            n = 1
                                        }
                                        nxIK.map.setZoom(z + n);
                                        nxIK.map.setCenter(latLng)
                                    });
                                    var label = new nxIK.Label({
                                        map: nxIK.map
                                    }, key, item.C);
                                    label.bindTo('position', marker, 'position');
                                    label.bindTo('visible', marker, 'visible');
                                    var text = item.C === undefined ? "error" : item.C;
                                    label.set('text', text)
                                }
                                nxIK.markers.push(marker)
                            });
                            markersDrawTodo.length = 0
                        },
                        error: function (xhr, err) {
                            var msg = "readyState: " + xhr.readyState + "\nstatus: " + xhr.status + "\nresponseText: " + xhr.responseText;
                            nxIK.log(msg);
                            alert(nxIK.mymap.settings.textErrorMessage)
                        }
                    });

}
},
popupWindow: function (marker, item) {
    ++nxIK.async.lastSendMarkerDetail;
    var getParams = "?action=get-marker-info&" + "id=" + item.I + "&" + "sid=" + nxIK.async.lastSendMarkerDetail;
    $.ajax({
        type: 'GET',
        url: nxIK.mymap.settings.jsonGetMarkerInfoUrl + getParams,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (data) {
            if (data.Ok === "0") {
                nxIK.log(data.EMsg);
                return
            }
            var lastReceivedMarkerDetail = data.Rid;
            if (lastReceivedMarkerDetail <= nxIK.async.lastReceivedMarkerDetail) {
                nxIK.log('async mismatch ' + lastReceivedMarkerDetail + ' ' + nxIK.async.lastReceivedMarkerDetail);
                return
            }
            nxIK.async.lastReceivedMarkerDetail = lastReceivedMarkerDetail;

            //iconos de compartir

            data.Content += '<div style="width:100px;"><div style="float: left" class="fb-share-button" data-href="' + HTTP_APP_PATH + '?action=marker&id=' + item.I + '" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(HTTP_APP_PATH + '?action=marker&id=' + item.I) + '&amp;src=sdkpreparse"><i class="fa flaticon-facebook-logo" aria-hidden="true"></i></a></div>';
            data.Content += '<a target="_blank" href="https://twitter.com/share?url=' + encodeURIComponent(HTTP_APP_PATH + '?action=marker&id=' + item.I) + '&text=" class="twitter-share-button" data-show-count="false"><i class="fa flaticon-social-media" aria-hidden="true"></i></a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';                                                                           
            data.Content += '<a href="whatsapp://send?text=' + HTTP_APP_PATH + '?action=marker&id=' + item.I + '" data-action="share/whatsapp/share"><i class="fa flaticon-whatsapp-logo" aria-hidden="true"></i></a></div>';
            nxIK.infowindow.setContent(data.Content);
            nxIK.infowindow.open(nxIK.map, marker)
        },
        error: function (xhr, err) {
            var msg = "readyState: " + xhr.readyState + "\nstatus: " + xhr.status + "\nresponseText: " + xhr.responseText + "\nerr:" + err;
            nxIK.log(msg);
            alert(nxIK.mymap.settings.textErrorMessage)
        }
    })
}
}
},
getKey: function (p) {
    var s = p.X + "__" + p.Y + "__" + p.C + "__" + p.T;
    return s.replace(/\./g, "_")
},
obtenerKey: function (p) {
    var s = p.lng + "__" + p.lat + "__" + 1 + "__" + 1;
    return s.replace(/\./g, "_")
},
getKnnKey: function (p) {
    var s = p.X + "__" + p.Y + "__" + p.Dist;
    return s.replace(/\./g, "_")
},
dEscape: function (d) {
    var s = d + "";
    return s.replace(/\./g, "_")
},
getFilterValues: function () {
    var filter_str = "";
    $('.checkbox input:checked').each(function() {
        filter_str += "&filter[]=" + this.value;
    });
    return filter_str;
},

chackboxSelectAll: function(obj) {
    var checkboxes = $('.checkbox input');
    if(obj.checked) {
        checkboxes.prop('checked', 'checked');
            //$(checkboxes).each(function() {
            //    this.checked = true;
            //});
        } else {
            checkboxes.removeAttr('checked');
            //$(checkboxes).each(function() {
            //    this.checked = false;
            //});
        }
    },
    findMarker: function(lat, lng) {
        var move_to = new google.maps.LatLng(lat, lng);
        nxIK.map.setCenter(move_to);
        nxIK.map.setZoom(nxIK.mymap.settings.max_zoomLevel);
        return false;
    },
    Label: function (opt_options, id, count) {
        this.setValues(opt_options);
        var span = this.span_ = document.createElement('span');
        if (count >= MARKERS_CLUSTERIZE_5) {
            span.className = "nxIK_clustersize5"
        } else if (count >= MARKERS_CLUSTERIZE_4) {
            span.className = "nxIK_clustersize4"
        } else if (count >= MARKERS_CLUSTERIZE_3) {
            span.className = "nxIK_clustersize3"
        } else if (count >= MARKERS_CLUSTERIZE_2) {
            span.className = "nxIK_clustersize2"
        } else {
            span.className = "nxIK_clustersize1"
        }
        var div = this.div_ = document.createElement('div');
        div.appendChild(span);
        div.className = "countinfo_" + id;
        div.style.cssText = 'position: absolute; display: none;'
    },

    ocultar: function (markers, cache, keyfunction, isclusterbased) {
        var markersCacheIncome = [];
        var markersCacheOnMap = [];
        var markersDrawTodo = [];
        for (i in markers) {
            if (markers.hasOwnProperty(i)) {
                p = markers[i];
                key = keyfunction(p);
                markersCacheIncome[key] = p
            }
        }
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                m = cache[i];
                key = m.get("key");
                if (key !== 0) {
                    markersCacheOnMap[key] = 1
                }
                if (key === undefined) {
                    nxIK.log("error in code: key")
                }
            }
        }
        
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                var m = cache[i];
                key = m.get("key");
                if (key !== 0 && markersCacheIncome[key] === undefined) {
                    if (isclusterbased === true) {
                        $(".countinfo_" + key).remove()
                    }
                    cache[i].set("key", 0);
                    cache[i].setMap(null)
                }
            }
        }
        var temp = []; 
        cache.length = 0;
        markersCacheIncome.length = 0;
        markersCacheOnMap.length = 0;
        temp.length = 0;
        return markersDrawTodo
    },

    actualizarMarcador: function (markers, cache, keyfunction, isclusterbased) {
        var markersCacheIncome = [];
        var markersCacheOnMap = [];
        var markersDrawTodo = [];
        var object;
        for (i in markers) {
            if (markers.hasOwnProperty(i)) {
                p = markers[i];
                key = keyfunction(p);
                object = {
                    C: 1,
                    I: p.id,
                    T: 1,
                    X: p.lng,
                    Y: p.lat
                }
                markersCacheIncome[key] = object
            }
        }
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                m = cache[i];
                key = m.get("key");
                if (key !== 0) {
                    markersCacheOnMap[key] = 1
                }
                if (key === undefined) {
                    nxIK.log("error in code: key")
                }
            }
        }
        for (var i in markers) {
            if (markers.hasOwnProperty(i)) {
                var p = markers[i];
                key = keyfunction(p);
                if (markersCacheOnMap[key] === undefined) {
                    if (markersCacheIncome[key] === undefined) {
                        nxIK.log("error in code: key2")
                    }
                    var newmarker = markersCacheIncome[key];
                    markersDrawTodo.push(newmarker)
                }
            }
        }
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                var m = cache[i];
                key = m.get("key");
                if (key !== 0 && markersCacheIncome[key] === undefined) {
                    if (isclusterbased === true) {
                        $(".countinfo_" + key).remove()
                    }
                    cache[i].set("key", 0);
                    cache[i].setMap(null)
                }
            }
        }
        var temp = [];
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                var key = cache[i].get("key");
                if (key !== 0) {
                    tempItem = cache[i];
                    temp.push(tempItem)
                }
            }
        }
        cache.length = 0;
        for (i in temp) {
            if (temp.hasOwnProperty(i)) {
                var tempItem = temp[i];
                cache.push(tempItem)
            }
        }
        markersCacheIncome.length = 0;
        markersCacheOnMap.length = 0;
        temp.length = 0;
        return markersDrawTodo
    },

    dynamicUpdateMarkers: function (markers, cache, keyfunction, isclusterbased) {
        var markersCacheIncome = [];
        var markersCacheOnMap = [];
        var markersDrawTodo = [];
        for (i in markers) {
            if (markers.hasOwnProperty(i)) {
                p = markers[i];
                key = keyfunction(p);
                markersCacheIncome[key] = p
            }
        }
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                m = cache[i];
                key = m.get("key");
                if (key !== 0) {
                    markersCacheOnMap[key] = 1
                }
                if (key === undefined) {
                    nxIK.log("error in code: key")
                }
            }
        }
        for (var i in markers) {
            if (markers.hasOwnProperty(i)) {
                var p = markers[i];
                key = keyfunction(p);
                if (markersCacheOnMap[key] === undefined) {
                    if (markersCacheIncome[key] === undefined) {
                        nxIK.log("error in code: key2")
                    }
                    var newmarker = markersCacheIncome[key];
                    markersDrawTodo.push(newmarker)
                }
            }
        }
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                var m = cache[i];
                key = m.get("key");
                if (key !== 0 && markersCacheIncome[key] === undefined) {
                    if (isclusterbased === true) {
                        $(".countinfo_" + key).remove()
                    }
                    cache[i].set("key", 0);
                    cache[i].setMap(null)
                }
            }
        }
        var temp = [];
        for (i in cache) {
            if (cache.hasOwnProperty(i)) {
                var key = cache[i].get("key");
                if (key !== 0) {
                    tempItem = cache[i];
                    temp.push(tempItem)
                }
            }
        }
        cache.length = 0;
        for (i in temp) {
            if (temp.hasOwnProperty(i)) {
                var tempItem = temp[i];
                cache.push(tempItem)
            }
        }
        markersCacheIncome.length = 0;
        markersCacheOnMap.length = 0;
        temp.length = 0;
        return markersDrawTodo
    }
};
nxIK.Label.prototype = new google.maps.OverlayView;
nxIK.Label.prototype.onAdd = function () {
    var pane = this.getPanes().overlayLayer;
    pane.appendChild(this.div_);
    var that = this;
    this.listeners_ = [google.maps.event.addListener(this, 'idle', function () {
        that.draw()
    }), google.maps.event.addListener(this, 'visible_changed', function () {
        that.draw()
    }), google.maps.event.addListener(this, 'position_changed', function () {
        that.draw()
    }), google.maps.event.addListener(this, 'text_changed', function () {
        that.draw()
    })]
};
nxIK.Label.prototype.onRemove = function () {
    this.div_.parentNode.removeChild(this.div_);
    for (var i = 0, I = this.listeners_.length; i < I; ++i) {
        google.maps.event.removeListener(this.listeners_[i])
    }
};
nxIK.Label.prototype.draw = function () {
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(this.get('position'));
    var div = this.div_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';
    var visible = this.get('visible');
    div.style.display = visible ? 'block' : 'none';
    this.span_.innerHTML = this.get('text').toString()
};
google.maps.event.addDomListener(window, 'load', nxIK.mymap.initialize);

