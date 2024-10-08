/*
@license
dhtmlxScheduler v.4.4.4 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
Scheduler.plugin(function(e) {
    e.templates.calendar_month = e.date.date_to_str("%F %Y"), e.templates.calendar_scale_date = e.date.date_to_str("%D"), e.templates.calendar_date = e.date.date_to_str("%d"), e.config.minicalendar = {
        mark_events: !0
    }, e._synced_minicalendars = [], e.renderCalendar = function(t, a, n) {
        var i = null,
            r = t.date || e._currentDate();
        if ("string" == typeof r && (r = this.templates.api_date(r)), a) i = this._render_calendar(a.parentNode, r, t, a), e.unmarkCalendar(i);
        else {
            var o = t.container,
                d = t.position;
            if ("string" == typeof o && (o = document.getElementById(o)),
                "string" == typeof d && (d = document.getElementById(d)), d && "undefined" == typeof d.left) {
                var l = getOffset(d);
                d = {
                    top: l.top + d.offsetHeight,
                    left: l.left
                }
            }
            o || (o = e._get_def_cont(d)), i = this._render_calendar(o, r, t), i.onclick = function(t) {
                t = t || event;
                var a = t.target || t.srcElement;
                if (-1 != a.className.indexOf("dhx_month_head")) {
                    var n = a.parentNode.className;
                    if (-1 == n.indexOf("dhx_after") && -1 == n.indexOf("dhx_before")) {
                        var i = e.templates.xml_date(this.getAttribute("date"));
                        i.setDate(parseInt(a.innerHTML, 10)), e.unmarkCalendar(this),
                            e.markCalendar(this, i, "dhx_calendar_click"), this._last_date = i, this.conf.handler && this.conf.handler.call(e, i, this)
                    }
                }
            }
        }
        if (e.config.minicalendar.mark_events)
            for (var s = e.date.month_start(r), _ = e.date.add(s, 1, "month"), c = this.getEvents(s, _), u = this["filter_" + this._mode], h = {}, p = 0; p < c.length; p++) {
                var v = c[p];
                if (!u || u(v.id, v)) {
                    var m = v.start_date;
                    for (m.valueOf() < s.valueOf() && (m = s), m = e.date.date_part(new Date(m.valueOf())); m < v.end_date && (h[+m] || (h[+m] = !0, this.markCalendar(i, m, "dhx_year_event")), m = this.date.add(m, 1, "day"),
                            !(m.valueOf() >= _.valueOf())););
                }
            }
        return this._markCalendarCurrentDate(i), i.conf = t, t.sync && !n && this._synced_minicalendars.push(i), i.conf._on_xle_handler || (i.conf._on_xle_handler = e.attachEvent("onXLE", function() {
            e.updateCalendar(i, i.conf.date)
        })), i
    }, e._get_def_cont = function(e) {
        return this._def_count || (this._def_count = document.createElement("DIV"), this._def_count.className = "dhx_minical_popup", this._def_count.onclick = function(e) {
                (e || event).cancelBubble = !0
            }, document.body.appendChild(this._def_count)),
            this._def_count.style.left = e.left + "px", this._def_count.style.top = e.top + "px", this._def_count._created = new Date, this._def_count
    }, e._locateCalendar = function(t, a) {
        if ("string" == typeof a && (a = e.templates.api_date(a)), +a > +t._max_date || +a < +t._min_date) return null;
        for (var n = t.querySelector(".dhx_year_body").childNodes[0], i = 0, r = new Date(t._min_date); + this.date.add(r, 1, "week") <= +a;) r = this.date.add(r, 1, "week"), i++;
        var o = e.config.start_on_monday,
            d = (a.getDay() || (o ? 7 : 0)) - (o ? 1 : 0);
        return n.rows[i].cells[d].firstChild;
    }, e.markCalendar = function(e, t, a) {
        var n = this._locateCalendar(e, t);
        n && (n.className += " " + a)
    }, e.unmarkCalendar = function(e, t, a) {
        if (t = t || e._last_date, a = a || "dhx_calendar_click", t) {
            var n = this._locateCalendar(e, t);
            n && (n.className = (n.className || "").replace(RegExp(a, "g")))
        }
    }, e._week_template = function(t) {
        for (var a = t || 250, n = 0, i = document.createElement("div"), r = this.date.week_start(e._currentDate()), o = 0; 7 > o; o++) this._cols[o] = Math.floor(a / (7 - o)), this._render_x_header(o, n, r, i), r = this.date.add(r, 1, "day"), a -= this._cols[o],
            n += this._cols[o];
        return i.lastChild.className += " dhx_scale_bar_last", i
    }, e.updateCalendar = function(e, t) {
        e.conf.date = t, this.renderCalendar(e.conf, e, !0)
    }, e._mini_cal_arrows = ["&nbsp", "&nbsp"], e._render_calendar = function(t, a, n, i) {
        var r = e.templates,
            o = this._cols;
        this._cols = [];
        var d = this._mode;
        this._mode = "calendar";
        var l = this._colsS;
        this._colsS = {
            height: 0
        };
        var s = new Date(this._min_date),
            _ = new Date(this._max_date),
            c = new Date(e._date),
            u = r.month_day,
            h = this._ignores_detected;
        this._ignores_detected = 0, r.month_day = r.calendar_date,
            a = this.date.month_start(a);
        var p, v = this._week_template(t.offsetWidth - 1 - this.config.minicalendar.padding);
        i ? p = i : (p = document.createElement("DIV"), p.className = "dhx_cal_container dhx_mini_calendar"), p.setAttribute("date", this.templates.xml_format(a)), p.innerHTML = "<div class='dhx_year_month'></div><div class='dhx_year_grid'><div class='dhx_year_week'>" + (v ? v.innerHTML : "") + "</div><div class='dhx_year_body'></div></div>";
        var m = p.querySelector(".dhx_year_month"),
            g = p.querySelector(".dhx_year_week"),
            f = p.querySelector(".dhx_year_body");
        if (m.innerHTML = this.templates.calendar_month(a), n.navigation)
            for (var b = function(t, a) {
                    var n = e.date.add(t._date, a, "month");
                    e.updateCalendar(t, n), e._date.getMonth() == t._date.getMonth() && e._date.getFullYear() == t._date.getFullYear() && e._markCalendarCurrentDate(t)
                }, y = ["dhx_cal_prev_button", "dhx_cal_next_button"], x = ["left:1px;top:2px;position:absolute;", "left:auto; right:1px;top:2px;position:absolute;"], k = [-1, 1], w = function(t) {
                    return function() {
                        if (n.sync)
                            for (var a = e._synced_minicalendars, i = 0; i < a.length; i++) b(a[i], t);
                        else b(p, t);
                    }
                }, D = [e.locale.labels.prev, e.locale.labels.next], S = 0; 2 > S; S++) {
                var E = document.createElement("DIV");
                E.className = y[S], e._waiAria.headerButtonsAttributes(E, D[S]), E.style.cssText = x[S], E.innerHTML = this._mini_cal_arrows[S], m.appendChild(E), E.onclick = w(k[S])
            }
        p._date = new Date(a), p.week_start = (a.getDay() - (this.config.start_on_monday ? 1 : 0) + 7) % 7;
        var N = p._min_date = this.date.week_start(a);
        p._max_date = this.date.add(p._min_date, 6, "week"), this._reset_month_scale(f, a, N, 6), i || t.appendChild(p), g.style.height = g.childNodes[0].offsetHeight - 1 + "px";
        var M = e.uid();
        e._waiAria.minicalHeader(m, M), e._waiAria.minicalGrid(p.querySelector(".dhx_year_grid"), M), e._waiAria.minicalRow(g);
        for (var A = g.querySelectorAll(".dhx_scale_bar"), O = 0; O < A.length; O++) e._waiAria.minicalHeadCell(A[O]);
        for (var C = f.querySelectorAll("td"), T = new Date(s), O = 0; O < C.length; O++) e._waiAria.minicalDayCell(C[O], new Date(T)), T = e.date.add(T, 1, "day");
        return e._waiAria.minicalHeader(m, M), this._cols = o, this._mode = d, this._colsS = l, this._min_date = s, this._max_date = _, e._date = c, r.month_day = u, this._ignores_detected = h,
            p
    }, e.destroyCalendar = function(t, a) {
        !t && this._def_count && this._def_count.firstChild && (a || (new Date).valueOf() - this._def_count._created.valueOf() > 500) && (t = this._def_count.firstChild), t && (t.onclick = null, t.innerHTML = "", t.parentNode && t.parentNode.removeChild(t), this._def_count && (this._def_count.style.top = "-1000px"), t.conf && t.conf._on_xle_handler && e.detachEvent(t.conf._on_xle_handler))
    }, e.isCalendarVisible = function() {
        return this._def_count && parseInt(this._def_count.style.top, 10) > 0 ? this._def_count : !1
    }, e._attach_minical_events = function() {
        dhtmlxEvent(document.body, "click", function() {
            e.destroyCalendar()
        }), e._attach_minical_events = function() {}
    }, e.attachEvent("onTemplatesReady", function() {
        e._attach_minical_events()
    }), e.templates.calendar_time = e.date.date_to_str("%d-%m-%Y"), e.form_blocks.calendar_time = {
        render: function(t) {
            var a = "<input class='dhx_readonly' type='text' disabled readonly='true'>",
                n = e.config,
                i = this.date.date_part(e._currentDate()),
                r = 1440,
                o = 0;
            n.limit_time_select && (o = 60 * n.first_hour, r = 60 * n.last_hour + 1), i.setHours(o / 60), t._time_values = [],
                a += " <select>";
            for (var d = o; r > d; d += 1 * this.config.time_step) {
                var l = this.templates.time_picker(i);
                a += "<option value='" + d + "'>" + l + "</option>", t._time_values.push(d), i = this.date.add(i, this.config.time_step, "minute")
            }
            a += "</select>";
            e.config.full_day;
            return "<div style='height:30px;padding-top:0; font-size:inherit;' class='dhx_section_time'>" + a + "<span style='font-weight:normal; font-size:10pt;'> &nbsp;&ndash;&nbsp; </span>" + a + "</div>"
        },
        set_value: function(t, a, n, i) {
            function r(t, a, n) {
                c(t, a, n), t.value = e.templates.calendar_time(a),
                    t._date = e.date.date_part(new Date(a))
            }

            function o(e) {
                for (var t = i._time_values, a = 60 * e.getHours() + e.getMinutes(), n = a, r = !1, o = 0; o < t.length; o++) {
                    var d = t[o];
                    if (d === a) {
                        r = !0;
                        break
                    }
                    a > d && (n = d)
                }
                return r || n ? r ? a : n : -1
            }
            var d, l, s = t.getElementsByTagName("input"),
                _ = t.getElementsByTagName("select"),
                c = function(t, a, n) {
                    t.onclick = function() {
                        e.destroyCalendar(null, !0), e.renderCalendar({
                            position: t,
                            date: new Date(this._date),
                            navigation: !0,
                            handler: function(a) {
                                t.value = e.templates.calendar_time(a), t._date = new Date(a), e.destroyCalendar(),
                                    e.config.event_duration && e.config.auto_end_date && 0 === n && v()
                            }
                        })
                    }
                };
            if (e.config.full_day) {
                if (!t._full_day) {
                    var u = "<label class='dhx_fullday'><input type='checkbox' name='full_day' value='true'> " + e.locale.labels.full_day + "&nbsp;</label></input>";
                    e.config.wide_form || (u = t.previousSibling.innerHTML + u), t.previousSibling.innerHTML = u, t._full_day = !0
                }
                var h = t.previousSibling.getElementsByTagName("input")[0],
                    p = 0 === e.date.time_part(n.start_date) && 0 === e.date.time_part(n.end_date);
                h.checked = p, _[0].disabled = h.checked,
                    _[1].disabled = h.checked, h.onclick = function() {
                        if (h.checked === !0) {
                            var a = {};
                            e.form_blocks.calendar_time.get_value(t, a), d = e.date.date_part(a.start_date), l = e.date.date_part(a.end_date), (+l == +d || +l >= +d && (0 !== n.end_date.getHours() || 0 !== n.end_date.getMinutes())) && (l = e.date.add(l, 1, "day"))
                        }
                        var i = d || n.start_date,
                            o = l || n.end_date;
                        r(s[0], i), r(s[1], o), _[0].value = 60 * i.getHours() + i.getMinutes(), _[1].value = 60 * o.getHours() + o.getMinutes(), _[0].disabled = h.checked, _[1].disabled = h.checked
                    }
            }
            if (e.config.event_duration && e.config.auto_end_date) {
                var v = function() {
                    d = e.date.add(s[0]._date, _[0].value, "minute"), l = new Date(d.getTime() + 60 * e.config.event_duration * 1e3), s[1].value = e.templates.calendar_time(l), s[1]._date = e.date.date_part(new Date(l)), _[1].value = 60 * l.getHours() + l.getMinutes()
                };
                _[0].onchange = v
            }
            r(s[0], n.start_date, 0), r(s[1], n.end_date, 1), c = function() {}, _[0].value = o(n.start_date), _[1].value = o(n.end_date)
        },
        get_value: function(t, a) {
            var n = t.getElementsByTagName("input"),
                i = t.getElementsByTagName("select");
            return a.start_date = e.date.add(n[0]._date, i[0].value, "minute"),
                a.end_date = e.date.add(n[1]._date, i[1].value, "minute"), a.end_date <= a.start_date && (a.end_date = e.date.add(a.start_date, e.config.time_step, "minute")), {
                    start_date: new Date(a.start_date),
                    end_date: new Date(a.end_date)
                }
        },
        focus: function(e) {}
    }, e.linkCalendar = function(t, a) {
        var n = function() {
            var n = e._date,
                i = new Date(n.valueOf());
            return a && (i = a(i)), i.setDate(1), e.updateCalendar(t, i), !0
        };
        e.attachEvent("onViewChange", n), e.attachEvent("onXLE", n), e.attachEvent("onEventAdded", n), e.attachEvent("onEventChanged", n), e.attachEvent("onAfterEventDelete", n),
            n()
    }, e._markCalendarCurrentDate = function(t) {
        var a = e._date,
            n = e._mode,
            i = e.date.month_start(new Date(t._date)),
            r = e.date.add(i, 1, "month");
        if ("day" == n || this._props && this._props[n]) i.valueOf() <= a.valueOf() && r > a && e.markCalendar(t, a, "dhx_calendar_click");
        else if ("week" == n)
            for (var o = e.date.week_start(new Date(a.valueOf())), d = 0; 7 > d; d++) i.valueOf() <= o.valueOf() && r > o && e.markCalendar(t, o, "dhx_calendar_click"), o = e.date.add(o, 1, "day")
    }, e.attachEvent("onEventCancel", function() {
        e.destroyCalendar(null, !0)
    })
});