/*
@license
dhtmlxScheduler v.4.4.4 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
Scheduler.plugin(function(e) {
    e.config.multisection = !0, e.config.multisection_shift_all = !0, e.config.section_delimiter = ",", e.attachEvent("onSchedulerReady", function() {
        e._inited_multisection_copies || (e.attachEvent("onEventIdChange", function(e, t) {
            var a = this._multisection_copies;
            if (a && a[e] && !a[t]) {
                var n = a[e];
                delete a[e], a[t] = n
            }
        }), e._inited_multisection_copies = !0), e._register_copies_array = function(e) {
            for (var t = 0; t < e.length; t++) this._register_copy(e[t])
        }, e._register_copy = function(e) {
            this._multisection_copies[e.id] || (this._multisection_copies[e.id] = {});
            var t = e[this._get_section_property()],
                a = this._multisection_copies[e.id];
            a[t] || (a[t] = e)
        }, e._get_copied_event = function(t, a) {
            if (!this._multisection_copies[t]) return null;
            if (this._multisection_copies[t][a]) return this._multisection_copies[t][a];
            var n = this._multisection_copies[t];
            if (e._drag_event && e._drag_event._orig_section && n[e._drag_event._orig_section]) return n[e._drag_event._orig_section];
            var i = 1 / 0,
                r = null;
            for (var o in n) n[o]._sorder < i && (r = n[o], i = n[o]._sorder);
            return r
        }, e._clear_copied_events = function() {
            this._multisection_copies = {}
        }, e._restore_render_flags = function(t) {
            for (var a = this._get_section_property(), n = 0; n < t.length; n++) {
                var i = t[n],
                    r = e._get_copied_event(i.id, i[a]);
                if (r)
                    for (var o in r) 0 === o.indexOf("_") && (i[o] = r[o])
            }
        };
        var t = e._update_unit_section;
        e._update_unit_section = function(a) {
            return e._update_sections(a, t)
        };
        var a = e._update_timeline_section;
        e._update_timeline_section = function(t) {
            return e._update_sections(t, a)
        }, e.isMultisectionEvent = function(e) {
            if (e && this._get_multisection_view()) {
                var t = this._get_event_sections(e);
                return t.length > 1
            }
            return !1
        }, e._get_event_sections = function(e) {
            var t = this._get_section_property(),
                a = e[t] || "";
            return this._parse_event_sections(a)
        }, e._parse_event_sections = function(t) {
            return t instanceof Array ? t : t.toString().split(e.config.section_delimiter)
        }, e._clear_copied_events(), e._split_events = function(t) {
            var a = [],
                n = this._get_multisection_view(),
                i = this._get_section_property();
            if (n)
                for (var r = 0; r < t.length; r++) {
                    var o = this._get_event_sections(t[r]);
                    if (o.length > 1) {
                        for (var d = 0; d < o.length; d++)
                            if ("undefined" != typeof n.order[o[d]]) {
                                var l = e._copy_event(t[r]);
                                l[i] = o[d], a.push(l)
                            }
                    } else a.push(t[r])
                } else a = t;
            return a
        }, e._get_multisection_view = function() {
            return this.config.multisection ? e._get_section_view() : !1
        };
        var n = e.get_visible_events;
        e.get_visible_events = function(e) {
            this._clear_copied_events();
            var t = n.apply(this, arguments);
            if (this._get_multisection_view()) {
                t = this._split_events(t);
                for (var a = 0; a < t.length; a++) this.is_visible_events(t[a]) || (t.splice(a, 1), a--);
                this._register_copies_array(t)
            }
            return t
        }, e._rendered_events = {};
        var i = e.render_view_data;
        e.render_view_data = function(e, t) {
            return this._get_multisection_view() && e && (e = this._split_events(e), this._restore_render_flags(e)), i.apply(this, [e, t])
        }, e._update_sections = function(t, a) {
            var n = t.view,
                i = t.event,
                r = t.pos;
            if (e.isMultisectionEvent(i)) {
                if (e._drag_event._orig_section || (e._drag_event._orig_section = r.section), e._drag_event._orig_section != r.section) {
                    var o = n.order[r.section] - n.order[e._drag_event._orig_section];
                    if (o) {
                        var d = this._get_event_sections(i),
                            l = [],
                            s = !0;
                        if (e.config.multisection_shift_all)
                            for (var _ = 0; _ < d.length; _++) {
                                var c = e._shift_sections(n, d[_], o);
                                if (null === c) {
                                    l = d, s = !1;
                                    break
                                }
                                l[_] = c
                            } else
                                for (var _ = 0; _ < d.length; _++) {
                                    if (d[_] == r.section) {
                                        l = d, s = !1;
                                        break
                                    }
                                    if (d[_] == e._drag_event._orig_section) {
                                        var c = e._shift_sections(n, d[_], o);
                                        if (null === c) {
                                            l = d, s = !1;
                                            break
                                        }
                                        l[_] = c
                                    } else l[_] = d[_]
                                }
                        s && (e._drag_event._orig_section = r.section), i[e._get_section_property()] = l.join(e.config.section_delimiter)
                    }
                }
            } else a.apply(e, [t])
        }, e._shift_sections = function(e, t, a) {
            for (var n = null, i = e.y_unit || e.options, r = 0; r < i.length; r++)
                if (i[r].key == t) {
                    n = r;
                    break;
                } var o = i[n + a];
            return o ? o.key : null
        };
        var r = e._get_blocked_zones;
        e._get_blocked_zones = function(e, t, a, n, i) {
            if (t && this.config.multisection) {
                t = this._parse_event_sections(t);
                for (var o = [], d = 0; d < t.length; d++) o = o.concat(r.apply(this, [e, t[d], a, n, i]));
                return o
            }
            return r.apply(this, arguments)
        };
        var o = e._check_sections_collision;
        e._check_sections_collision = function(e, t) {
            if (this.config.multisection && this._get_section_view()) {
                e = this._split_events([e]), t = this._split_events([t]);
                for (var a = !1, n = 0, i = e.length; i > n && !a; n++)
                    for (var r = 0, d = t.length; d > r; r++)
                        if (o.apply(this, [e[n], t[r]])) {
                            a = !0;
                            break
                        } return a
            }
            return o.apply(this, arguments)
        }
    })
});