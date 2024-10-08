/*
@license
dhtmlxScheduler v.4.4.4 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
! function() {
    function e(e) {
        function t(t) {
            var a = {
                minicalButton: e.$keyboardNavigation.MinicalButton,
                minicalDate: e.$keyboardNavigation.MinicalCell,
                scheduler: e.$keyboardNavigation.SchedulerNode,
                dataArea: e.$keyboardNavigation.DataArea,
                timeSlot: e.$keyboardNavigation.TimeSlot,
                event: e.$keyboardNavigation.Event
            };
            return a[t] || a.scheduler
        }
        e.config.key_nav = !0, e.config.key_nav_step = 30, e.addShortcut = function(e, a, i) {
                var n = t(i);
                n && n.prototype.bind(e, a)
            }, e.removeShortcut = function(e, a) {
                var i = t(a);
                i && i.prototype.unbind(e);
            }, e.focus = function() {
                if (e.config.key_nav) {
                    var t = e.$keyboardNavigation.dispatcher;
                    t.enable();
                    var a = t.getActiveNode();
                    !a || a instanceof e.$keyboardNavigation.MinicalButton || a instanceof e.$keyboardNavigation.MinicalCell ? t.setDefaultNode() : t.focusNode(t.getActiveNode())
                }
            }, e.$keyboardNavigation = {}, e._compose = function() {
                for (var e = Array.prototype.slice.call(arguments, 0), t = {}, a = 0; a < e.length; a++) {
                    var i = e[a];
                    "function" == typeof i && (i = new i);
                    for (var n in i) t[n] = i[n]
                }
                return t
            }, e.$keyboardNavigation.shortcuts = {
                createCommand: function() {
                    return {
                        modifiers: {
                            shift: !1,
                            alt: !1,
                            ctrl: !1,
                            meta: !1
                        },
                        keyCode: null
                    }
                },
                parse: function(e) {
                    for (var t = [], a = this.getExpressions(this.trim(e)), i = 0; i < a.length; i++) {
                        for (var n = this.getWords(a[i]), r = this.createCommand(), o = 0; o < n.length; o++) this.commandKeys[n[o]] ? r.modifiers[n[o]] = !0 : this.specialKeys[n[o]] ? r.keyCode = this.specialKeys[n[o]] : r.keyCode = n[o].charCodeAt(0);
                        t.push(r)
                    }
                    return t
                },
                getCommandFromEvent: function(e) {
                    var t = this.createCommand();
                    t.modifiers.shift = !!e.shiftKey, t.modifiers.alt = !!e.altKey,
                        t.modifiers.ctrl = !!e.ctrlKey, t.modifiers.meta = !!e.metaKey, t.keyCode = e.which || e.keyCode;
                    var a = String.fromCharCode(t.keyCode);
                    return a && (t.keyCode = a.toLowerCase().charCodeAt(0)), t
                },
                getHashFromEvent: function(e) {
                    return this.getHash(this.getCommandFromEvent(e))
                },
                getHash: function(e) {
                    var t = [];
                    for (var a in e.modifiers) e.modifiers[a] && t.push(a);
                    return t.push(e.keyCode), t.join(this.junctionChar)
                },
                getExpressions: function(e) {
                    return e.split(this.junctionChar)
                },
                getWords: function(e) {
                    return e.split(this.combinationChar);
                },
                trim: function(e) {
                    return e.replace(/\s/g, "")
                },
                junctionChar: ",",
                combinationChar: "+",
                commandKeys: {
                    shift: 16,
                    alt: 18,
                    ctrl: 17,
                    meta: !0
                },
                specialKeys: {
                    backspace: 8,
                    tab: 9,
                    enter: 13,
                    esc: 27,
                    space: 32,
                    up: 38,
                    down: 40,
                    left: 37,
                    right: 39,
                    home: 36,
                    end: 35,
                    pageup: 33,
                    pagedown: 34,
                    "delete": 46,
                    insert: 45,
                    plus: 107,
                    f1: 112,
                    f2: 113,
                    f3: 114,
                    f4: 115,
                    f5: 116,
                    f6: 117,
                    f7: 118,
                    f8: 119,
                    f9: 120,
                    f10: 121,
                    f11: 122,
                    f12: 123
                }
            }, e.$keyboardNavigation.EventHandler = {
                _handlers: null,
                findHandler: function(t) {
                    this._handlers || (this._handlers = {});
                    var a = e.$keyboardNavigation.shortcuts,
                        i = a.getHash(t);
                    return this._handlers[i]
                },
                doAction: function(e, t) {
                    var a = this.findHandler(e);
                    a && (a.call(this, t), t.preventDefault ? t.preventDefault() : t.returnValue = !1)
                },
                bind: function(t, a) {
                    this._handlers || (this._handlers = {});
                    for (var i = e.$keyboardNavigation.shortcuts, n = i.parse(t), r = 0; r < n.length; r++) this._handlers[i.getHash(n[r])] = a
                },
                unbind: function(t) {
                    for (var a = e.$keyboardNavigation.shortcuts, i = a.parse(t), n = 0; n < i.length; n++) this._handlers[a.getHash(i[n])] && delete this._handlers[a.getHash(i[n])]
                },
                bindAll: function(e) {
                    for (var t in e) this.bind(t, e[t]);
                },
                initKeys: function() {
                    this._handlers || (this._handlers = {}), this.keys && this.bindAll(this.keys)
                }
            },
            function() {
                e.$keyboardNavigation.getFocusableNodes = e._getFocusableNodes, e.$keyboardNavigation.trapFocus = function(t, a) {
                    if (9 != a.keyCode) return !1;
                    for (var i = e.$keyboardNavigation.getFocusableNodes(t), n = document.activeElement, r = -1, o = 0; o < i.length; o++)
                        if (i[o] == n) {
                            r = o;
                            break
                        } var d, l;
                    if (a.shiftKey) {
                        if (d = 0 >= r ? i[i.length - 1] : r - 1, l = i[d]) return l.focus(), a.preventDefault(), !0
                    } else if (d = r >= i.length - 1 ? 0 : r + 1, l = i[d]) return l.focus(),
                        a.preventDefault(), !0;
                    return !1
                }
            }(), e.$keyboardNavigation.marker = {
                clear: function() {
                    for (var t = e.$container.querySelectorAll(".dhx_focus_slot"), a = 0; a < t.length; a++) t[a].parentNode.removeChild(t[a])
                },
                createElement: function() {
                    var e = document.createElement("DIV");
                    return e.setAttribute("tabindex", -1), e.className = "dhx_focus_slot", e
                },
                renderMultiple: function(t, a, i) {
                    for (var n = [], r = new Date(t), o = new Date(Math.min(a.valueOf(), e.date.add(e.date.day_start(new Date(t)), 1, "day").valueOf())); r.valueOf() < a.valueOf();) n = n.concat(i.call(this, r, new Date(Math.min(o.valueOf(), a.valueOf())))),
                        r = e.date.day_start(e.date.add(r, 1, "day")), o = e.date.day_start(e.date.add(r, 1, "day")), o = new Date(Math.min(o.valueOf(), a.valueOf()));
                    return n
                },
                render: function(t, a, i) {
                    this.clear();
                    var n = [],
                        r = e.$keyboardNavigation.TimeSlot.prototype._modes,
                        o = e.$keyboardNavigation.TimeSlot.prototype._getMode();
                    switch (o) {
                        case r.units:
                            n = this.renderVerticalMarker(t, a, i);
                            break;
                        case r.timeline:
                            n = this.renderTimelineMarker(t, a, i);
                            break;
                        case r.year:
                            n = n.concat(this.renderMultiple(t, a, this.renderYearMarker));
                            break;
                        case r.month:
                            n = this.renderMonthMarker(t, a);
                            break;
                        case r.weekAgenda:
                            n = n.concat(this.renderMultiple(t, a, this.renderWeekAgendaMarker));
                            break;
                        case r.list:
                            n = this.renderAgendaMarker(t, a);
                            break;
                        case r.dayColumns:
                            n = n.concat(this.renderMultiple(t, a, this.renderVerticalMarker))
                    }
                    this.addWaiAriaLabel(n, t, a, i), this.addDataAttributes(n, t, a, i);
                    for (var d = n.length - 1; d >= 0; d--)
                        if (n[d].offsetWidth) return n[d];
                    return null
                },
                addDataAttributes: function(t, a, i, n) {
                    for (var r = e.date.date_to_str(e.config.api_date), o = r(a), d = r(i), l = 0; l < t.length; l++) t[l].setAttribute("data-start-date", o),
                        t[l].setAttribute("data-end-date", d), n && t[l].setAttribute("data-section", n)
                },
                addWaiAriaLabel: function(t, a, i, n) {
                    var r = "",
                        o = e.getState(),
                        d = o.mode,
                        l = !1;
                    r += e.templates.day_date(a), e.date.day_start(new Date(a)).valueOf() != a.valueOf() && (r += " " + e.templates.hour_scale(a), l = !0), e.date.day_start(new Date(a)).valueOf() != e.date.day_start(new Date(i)).valueOf() && (r += " - " + e.templates.day_date(i), (l || e.date.day_start(new Date(i)).valueOf() != i.valueOf()) && (r += " " + e.templates.hour_scale(i))), n && (e.matrix && e.matrix[d] ? r += ", " + e.templates[d + "_scale_label"](n.key, n.label, n) : e._props && e._props[d] && (r += ", " + e.templates[d + "_scale_text"](n.key, n.label, n)));
                    for (var s = 0; s < t.length; s++) e._waiAria.setAttributes(t[s], {
                        "aria-label": r,
                        "aria-live": "polite"
                    })
                },
                renderWeekAgendaMarker: function(t, a) {
                    for (var i = e.$container.querySelectorAll(".dhx_wa_day_cont .dhx_wa_scale_bar"), n = e.date.week_start(new Date(e.getState().min_date)), r = -1, o = e.date.day_start(new Date(t)), d = 0; d < i.length && (r++, e.date.day_start(new Date(n)).valueOf() != o.valueOf()); d++) n = e.date.add(n, 1, "day");
                    return -1 != r ? this._wrapDiv(i[r]) : []
                },
                _wrapDiv: function(e) {
                    var t = this.createElement();
                    return t.style.top = e.offsetTop + "px",
                        t.style.left = e.offsetLeft + "px", t.style.width = e.offsetWidth + "px", t.style.height = e.offsetHeight + "px", e.appendChild(t), [t]
                },
                renderYearMarker: function(t, a) {
                    var i = e._get_year_cell(t);
                    i.style.position = "relative";
                    var n = this.createElement();
                    return n.style.top = "0px", n.style.left = "0px", n.style.width = "100%", n.style.height = "100%", i.appendChild(n), [n]
                },
                renderAgendaMarker: function(t, a) {
                    var i = this.createElement();
                    return i.style.height = "1px", i.style.width = "100%", i.style.opacity = 1, i.style.top = "0px", i.style.left = "0px",
                        e.$container.querySelector(".dhx_cal_data").appendChild(i), [i]
                },
                renderTimelineMarker: function(t, a, i) {
                    var n = e._lame_copy({}, e.matrix[e._mode]),
                        r = n._scales;
                    n.round_position = !1;
                    var o = [],
                        d = t ? new Date(t) : e._min_date,
                        l = a ? new Date(a) : e._max_date;
                    if (d.valueOf() < e._min_date.valueOf() && (d = new Date(e._min_date)), l.valueOf() > e._max_date.valueOf() && (l = new Date(e._max_date)), !n._trace_x) return o;
                    for (var s = 0; s < n._trace_x.length && !e._is_column_visible(n._trace_x[s]); s++);
                    if (s == n._trace_x.length) return o;
                    var _ = r[i];
                    if (!(a > d && l > t)) return o;
                    var c = this.createElement(),
                        u = e._timeline_getX({
                            start_date: t
                        }, !1, n) - 1,
                        h = e._timeline_getX({
                            start_date: a
                        }, !1, n) - 1,
                        p = n._section_height[i] - 1 || n.dy - 1,
                        v = 0;
                    e._isRender("cell") && (v = _.offsetTop, u += n.dx, h += n.dx, _ = e.$container.querySelector(".dhx_cal_data"));
                    var m = Math.max(1, h - u - 1);
                    return c.style.cssText = "height: " + p + "px; left: " + u + "px; width: " + m + "px; top: " + v + "px;", _.insertBefore(c, _.firstChild), o.push(c), o
                },
                renderMonthCell: function(t) {
                    for (var a = e.$container.querySelectorAll(".dhx_month_head"), i = [], n = 0; n < a.length; n++) i.push(a[n].parentNode);
                    for (var r = e.date.week_start(new Date(e.getState().min_date)), o = -1, d = 0, l = -1, s = r, _ = e.date.day_start(new Date(t)), n = 0; n < i.length && (o++, 6 == l ? (d++, l = 0) : l++, e.date.day_start(new Date(s)).valueOf() != _.valueOf()); n++) s = e.date.add(s, 1, "day");
                    if (-1 == o) return [];
                    var c = e._colsS[l],
                        u = e._colsS.heights[d],
                        h = this.createElement();
                    h.style.top = u + "px", h.style.left = c + "px", h.style.width = e._cols[l] + "px", h.style.height = (e._colsS.heights[d + 1] - u || e._colsS.height) + "px";
                    var p = e.$container.querySelector(".dhx_cal_data"),
                        v = p.querySelector("table");
                    return v.nextSibling ? p.insertBefore(h, v.nextSibling) : p.appendChild(h), h
                },
                renderMonthMarker: function(t, a) {
                    for (var i = [], n = t; n.valueOf() < a.valueOf();) i.push(this.renderMonthCell(n)), n = e.date.add(n, 1, "day");
                    return i
                },
                renderVerticalMarker: function(t, a, i) {
                    var n = e.locate_holder_day(t),
                        r = [],
                        o = null,
                        d = e.config;
                    if (e._ignores[n]) return r;
                    if (e._props && e._props[e._mode] && i) {
                        var l = e._props[e._mode];
                        n = l.order[i];
                        var s = l.order[i];
                        l.days > 1 ? n = e.locate_holder_day(t) + s : (n = s, l.size && n > l.position + l.size && (n = 0))
                    }
                    if (o = e.locate_holder(n),
                        !o || o.querySelector(".dhx_scale_hour")) return document.createElement("div");
                    var _ = Math.max(60 * t.getHours() + t.getMinutes(), 60 * d.first_hour),
                        c = Math.min(60 * a.getHours() + a.getMinutes(), 60 * d.last_hour);
                    if (!c && e.date.day_start(new Date(a)).valueOf() > e.date.day_start(new Date(t)).valueOf() && (c = 60 * d.last_hour), _ >= c) return [];
                    var u = this.createElement(),
                        h = e.config.hour_size_px * d.last_hour + 1,
                        p = 36e5;
                    return u.style.top = Math.round((60 * _ * 1e3 - e.config.first_hour * p) * e.config.hour_size_px / p) % h + "px", u.style.lineHeight = u.style.height = Math.max(Math.round(60 * (c - _) * 1e3 * e.config.hour_size_px / p) % h, 1) + "px",
                        u.style.width = "100%", o.appendChild(u), r.push(u), r[0]
                }
            }, e.$keyboardNavigation.SchedulerNode = function() {}, e.$keyboardNavigation.SchedulerNode.prototype = e._compose(e.$keyboardNavigation.EventHandler, {
                getDefaultNode: function() {
                    var t = new e.$keyboardNavigation.TimeSlot;
                    return t.isValid() || (t = t.fallback()), t
                },
                _modes: {
                    month: "month",
                    year: "year",
                    dayColumns: "dayColumns",
                    timeline: "timeline",
                    units: "units",
                    weekAgenda: "weekAgenda",
                    list: "list"
                },
                getMode: function() {
                    var t = e.getState(),
                        a = t.mode;
                    return e.matrix && e.matrix[a] ? this._modes.timeline : e._props && e._props[a] ? this._modes.units : "month" == a ? this._modes.month : "year" == a ? this._modes.year : "week_agenda" == a ? this._modes.weekAgenda : "map" == a || "agenda" == a || e._grid && e["grid_" + a] ? this._modes.list : this._modes.dayColumns;
                },
                focus: function() {
                    e.focus()
                },
                blur: function() {},
                disable: function() {
                    e.$container.setAttribute("tabindex", "0")
                },
                enable: function() {
                    e.$container && e.$container.removeAttribute("tabindex")
                },
                isEnabled: function() {
                    return e.$container.hasAttribute("tabindex")
                },
                _compareEvents: function(e, t) {
                    return e.start_date.valueOf() == t.start_date.valueOf() ? e.id > t.id ? 1 : -1 : e.start_date.valueOf() > t.start_date.valueOf() ? 1 : -1
                },
                _pickEvent: function(t, a, i, n) {
                    var r = e.getState();
                    t = new Date(Math.max(r.min_date.valueOf(), t.valueOf())),
                        a = new Date(Math.min(r.max_date.valueOf(), a.valueOf()));
                    var o = e.getEvents(t, a);
                    o.sort(this._compareEvents), n && (o = o.reverse());
                    for (var d = !!i, l = 0; l < o.length && d; l++) o[l].id == i && (d = !1), o.splice(l, 1), l--;
                    return o[0]
                },
                nextEventHandler: function(t) {
                    var a = e.$keyboardNavigation.dispatcher.activeNode,
                        i = t || a && a.eventId,
                        n = null;
                    if (i && e.getEvent(i)) {
                        var r = e.getEvent(i);
                        n = e.$keyboardNavigation.SchedulerNode.prototype._pickEvent(r.start_date, e.date.add(r.start_date, 1, "year"), r.id, !1)
                    }
                    if (!n && !t) {
                        var o = e.getState();
                        n = e.$keyboardNavigation.SchedulerNode.prototype._pickEvent(o.min_date, e.date.add(o.min_date, 1, "year"), null, !1);
                    }
                    if (n) {
                        var d = new e.$keyboardNavigation.Event(n.id);
                        d.isValid() ? (a && a.blur(), e.$keyboardNavigation.dispatcher.setActiveNode(d)) : this.nextEventHandler(n.id)
                    }
                },
                prevEventHandler: function(t) {
                    var a = e.$keyboardNavigation.dispatcher.activeNode,
                        i = t || a && a.eventId,
                        n = null;
                    if (i && e.getEvent(i)) {
                        var r = e.getEvent(i);
                        n = e.$keyboardNavigation.SchedulerNode.prototype._pickEvent(e.date.add(r.end_date, -1, "year"), r.end_date, r.id, !0)
                    }
                    if (!n && !t) {
                        var o = e.getState();
                        n = e.$keyboardNavigation.SchedulerNode.prototype._pickEvent(e.date.add(o.max_date, -1, "year"), o.max_date, null, !0);
                    }
                    if (n) {
                        var d = new e.$keyboardNavigation.Event(n.id);
                        d.isValid() ? (a && a.blur(), e.$keyboardNavigation.dispatcher.setActiveNode(d)) : this.prevEventHandler(n.id)
                    }
                },
                keys: {
                    "alt+1, alt+2, alt+3, alt+4, alt+5, alt+6, alt+7, alt+8, alt+9": function(t) {
                        var a = e.$keyboardNavigation.HeaderCell.prototype.getNodes(".dhx_cal_navline .dhx_cal_tab"),
                            i = t.key;
                        void 0 === i && (i = t.keyCode - 48), a[1 * i - 1] && a[1 * i - 1].click()
                    },
                    "ctrl+left,meta+left": function(t) {
                        e._click.dhx_cal_prev_button()
                    },
                    "ctrl+right,meta+right": function(t) {
                        e._click.dhx_cal_next_button();
                    },
                    "ctrl+up,meta+up": function(t) {
                        var a = e.$container.querySelector(".dhx_cal_data");
                        a.scrollTop -= 20
                    },
                    "ctrl+down,meta+down": function(t) {
                        var a = e.$container.querySelector(".dhx_cal_data");
                        a.scrollTop += 20
                    },
                    e: function() {
                        this.nextEventHandler()
                    },
                    home: function() {
                        e.setCurrentView(new Date)
                    },
                    "shift+e": function() {
                        this.prevEventHandler()
                    },
                    "ctrl+enter,meta+enter": function() {
                        e.addEventNow({
                            start_date: new Date(e.getState().date)
                        })
                    },
                    "ctrl+c,meta+c": function(t) {
                        e._key_nav_copy_paste(t)
                    },
                    "ctrl+v,meta+v": function(t) {
                        e._key_nav_copy_paste(t)
                    },
                    "ctrl+x,meta+x": function(t) {
                        e._key_nav_copy_paste(t)
                    }
                }
            }), e.$keyboardNavigation.SchedulerNode.prototype.bindAll(e.$keyboardNavigation.SchedulerNode.prototype.keys), e.$keyboardNavigation.KeyNavNode = function() {}, e.$keyboardNavigation.KeyNavNode.prototype = e._compose(e.$keyboardNavigation.EventHandler, {
                isValid: function() {
                    return !0
                },
                fallback: function() {
                    return null
                },
                moveTo: function(t) {
                    e.$keyboardNavigation.dispatcher.setActiveNode(t)
                },
                compareTo: function(e) {
                    if (!e) return !1;
                    for (var t in this) {
                        if (!!this[t] != !!e[t]) return !1;
                        var a = !(!this[t] || !this[t].toString),
                            i = !(!e[t] || !e[t].toString);
                        if (i != a) return !1;
                        if (i && a) {
                            if (e[t].toString() != this[t].toString()) return !1
                        } else if (e[t] != this[t]) return !1
                    }
                    return !0
                },
                getNode: function() {},
                focus: function() {
                    var e = this.getNode();
                    e && (e.setAttribute("tabindex", "-1"), e.focus && e.focus())
                },
                blur: function() {
                    var e = this.getNode();
                    e && e.setAttribute("tabindex", "-1")
                }
            }), e.$keyboardNavigation.HeaderCell = function(e) {
                this.index = e || 0
            }, e.$keyboardNavigation.HeaderCell.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                getNode: function(e) {
                    e = e || this.index || 0;
                    var t = this.getNodes();
                    return t[e] ? t[e] : void 0
                },
                getNodes: function(t) {
                    t = t || [".dhx_cal_navline .dhx_cal_prev_button", ".dhx_cal_navline .dhx_cal_next_button", ".dhx_cal_navline .dhx_cal_today_button", ".dhx_cal_navline .dhx_cal_tab"].join(", ");
                    var a = Array.prototype.slice.call(e.$container.querySelectorAll(t));
                    return a.sort(function(e, t) {
                        return e.offsetLeft - t.offsetLeft
                    }), a
                },
                _handlers: null,
                isValid: function() {
                    return !!this.getNode(this.index)
                },
                fallback: function() {
                    var t = this.getNode(0);
                    return t || (t = new e.$keyboardNavigation.TimeSlot), t
                },
                keys: {
                    left: function() {
                        var t = this.index - 1;
                        0 > t && (t = this.getNodes().length - 1), this.moveTo(new e.$keyboardNavigation.HeaderCell(t))
                    },
                    right: function() {
                        var t = this.index + 1;
                        t >= this.getNodes().length && (t = 0), this.moveTo(new e.$keyboardNavigation.HeaderCell(t))
                    },
                    down: function() {
                        this.moveTo(new e.$keyboardNavigation.TimeSlot)
                    },
                    enter: function() {
                        var e = this.getNode();
                        e && e.click()
                    }
                }
            }), e.$keyboardNavigation.HeaderCell.prototype.bindAll(e.$keyboardNavigation.HeaderCell.prototype.keys),
            e.$keyboardNavigation.Event = function(t) {
                if (this.eventId = null, e.getEvent(t)) {
                    var a = e.getEvent(t);
                    this.start = new Date(a.start_date), this.end = new Date(a.end_date), this.section = this._getSection(a), this.eventId = t
                }
            }, e.$keyboardNavigation.Event.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                _getNodes: function() {
                    return Array.prototype.slice.call(e.$container.querySelectorAll("[event_id]"))
                },
                _modes: e.$keyboardNavigation.SchedulerNode.prototype._modes,
                getMode: e.$keyboardNavigation.SchedulerNode.prototype.getMode,
                _handlers: null,
                isValid: function() {
                    return !(!e.getEvent(this.eventId) || !this.getNode())
                },
                fallback: function() {
                    var t = this._getNodes()[0],
                        a = null;
                    if (t && e._locate_event(t)) {
                        var i = e._locate_event(t);
                        a = new e.$keyboardNavigation.Event(i)
                    } else a = new e.$keyboardNavigation.TimeSlot;
                    return a
                },
                getNode: function() {
                    var t = "[event_id='" + this.eventId + "']",
                        a = e.$container.querySelector(".dhx_cal_editor" + t + " textarea");
                    return a ? a : e.$container.querySelector(t)
                },
                focus: function() {
                    var t = e.getEvent(this.eventId),
                        a = e.getState();
                    (t.start_date.valueOf() > a.max_date.valueOf() || t.end_date.valueOf() <= a.min_date.valueOf()) && e.setCurrentView(t.start_date), e.$keyboardNavigation.KeyNavNode.prototype.focus.apply(this)
                },
                blur: function() {
                    e.$keyboardNavigation.KeyNavNode.prototype.blur.apply(this)
                },
                _getSection: function(t) {
                    var a = null,
                        i = e.getState().mode;
                    if (e.matrix && e.matrix[i]) {
                        var n = e.matrix[e.getState().mode];
                        a = t[n.y_property]
                    } else if (e._props && e._props[i]) {
                        var r = e._props[i];
                        a = t[r.map_to]
                    }
                    return a
                },
                _moveToSlot: function(t) {
                    var a = e.getEvent(this.eventId);
                    if (a) {
                        var i = this._getSection(a),
                            n = new e.$keyboardNavigation.TimeSlot(a.start_date, null, i);
                        this.moveTo(n.nextSlot(n, t))
                    } else this.moveTo(new e.$keyboardNavigation.TimeSlot)
                },
                keys: {
                    left: function() {
                        this._moveToSlot("left")
                    },
                    right: function() {
                        this._moveToSlot("right")
                    },
                    down: function() {
                        this.getMode() == this._modes.list ? e.$keyboardNavigation.SchedulerNode.prototype.nextEventHandler() : this._moveToSlot("down")
                    },
                    space: function() {
                        var t = this.getNode();
                        t && t.click ? t.click() : this.moveTo(new e.$keyboardNavigation.TimeSlot);
                    },
                    up: function() {
                        this.getMode() == this._modes.list ? e.$keyboardNavigation.SchedulerNode.prototype.prevEventHandler() : this._moveToSlot("up")
                    },
                    "delete": function() {
                        e.getEvent(this.eventId) ? e._click.buttons["delete"](this.eventId) : this.moveTo(new e.$keyboardNavigation.TimeSlot)
                    },
                    enter: function() {
                        e.getEvent(this.eventId) ? e.showLightbox(this.eventId) : this.moveTo(new e.$keyboardNavigation.TimeSlot)
                    }
                }
            }), e.$keyboardNavigation.Event.prototype.bindAll(e.$keyboardNavigation.Event.prototype.keys), e.$keyboardNavigation.TimeSlot = function(t, a, i, n) {
                var r = e.getState(),
                    o = e.matrix && e.matrix[r.mode];
                t || (o ? (t = e.date[o.name + "_start"](new Date(r.date)), t = this.findVisibleColumn(t)) : (t = new Date(e.getState().min_date), t = this.findVisibleColumn(t), t.setHours(e.config.first_hour))), a || (a = o ? e.date.add(t, o.x_step, o.x_unit) : e.date.add(t, e.config.key_nav_step, "minute")), this.section = i || this._getDefaultSection(), this.start_date = new Date(t), this.end_date = new Date(a), this.movingDate = n || null
            }, e.$keyboardNavigation.TimeSlot.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                _handlers: null,
                clone: function(t) {
                    return new e.$keyboardNavigation.TimeSlot(t.start_date, t.end_date, t.section, t.movingDate)
                },
                _getMultisectionView: function() {
                    var t, a = e.getState();
                    return e._props && e._props[a.mode] ? t = e._props[a.mode] : e.matrix && e.matrix[a.mode] && (t = e.matrix[a.mode]), t
                },
                _getDefaultSection: function() {
                    var e = null,
                        t = this._getMultisectionView();
                    return t && !e && (e = this._getNextSection()), e
                },
                _getNextSection: function(e, t) {
                    var a = this._getMultisectionView(),
                        i = a.order[e],
                        n = i;
                    n = void 0 !== i ? i + t : a.size && a.position ? a.position : 0,
                        n = 0 > n ? n = (a.options || a.y_unit).length - 1 : n;
                    var r = a.options || a.y_unit;
                    return r[n] ? r[n].key : null
                },
                isValid: function() {
                    var t = e.getState(),
                        a = !(this.start_date.valueOf() < t.min_date.valueOf() || this.start_date.valueOf() >= t.max_date.valueOf());
                    if (!a) return !1;
                    if (!this.isVisible(this.start_date, this.end_date)) return !1;
                    var i = this._getMultisectionView();
                    return i ? void 0 !== i.order[this.section] : !0
                },
                fallback: function() {
                    var t = new e.$keyboardNavigation.TimeSlot;
                    return t.isValid() ? t : new e.$keyboardNavigation.DataArea;
                },
                getNodes: function() {
                    return Array.prototype.slice.call(e.$container.querySelectorAll(".dhx_focus_slot"))
                },
                getNode: function() {
                    return this.getNodes()[0]
                },
                focus: function() {
                    e.$keyboardNavigation.marker.render(this.start_date, this.end_date, this.section), e.$keyboardNavigation.KeyNavNode.prototype.focus.apply(this), e.$keyboardNavigation._pasteDate = this.start_date, e.$keyboardNavigation._pasteSection = this.section
                },
                blur: function() {
                    e.$keyboardNavigation.KeyNavNode.prototype.blur.apply(this), e.$keyboardNavigation.marker.clear();
                },
                _modes: e.$keyboardNavigation.SchedulerNode.prototype._modes,
                _getMode: e.$keyboardNavigation.SchedulerNode.prototype.getMode,
                addMonthDate: function(t, a, i) {
                    var n;
                    switch (a) {
                        case "up":
                            n = e.date.add(t, -1, "week");
                            break;
                        case "down":
                            n = e.date.add(t, 1, "week");
                            break;
                        case "left":
                            n = e.date.day_start(e.date.add(t, -1, "day")), n = this.findVisibleColumn(n, -1);
                            break;
                        case "right":
                            n = e.date.day_start(e.date.add(t, 1, "day")), n = this.findVisibleColumn(n, 1);
                            break;
                        default:
                            n = e.date.day_start(new Date(t))
                    }
                    var r = e.getState();
                    return (t.valueOf() < r.min_date.valueOf() || !i && t.valueOf() >= r.max_date.valueOf()) && (n = new Date(r.min_date)),
                        n
                },
                nextMonthSlot: function(t, a, i) {
                    var n, r;
                    return n = this.addMonthDate(t.start_date, a, i), n.setHours(e.config.first_hour), r = new Date(n), r.setHours(e.config.last_hour), {
                        start_date: n,
                        end_date: r
                    }
                },
                _alignTimeSlot: function(t, a, i, n) {
                    for (var r = new Date(a); r.valueOf() < t.valueOf();) r = e.date.add(r, n, i);
                    return r.valueOf() > t.valueOf() && (r = e.date.add(r, -n, i)), r
                },
                nextTimelineSlot: function(t, a, i) {
                    var n = e.getState(),
                        r = e.matrix[n.mode],
                        o = this._alignTimeSlot(t.start_date, e.date[r.name + "_start"](new Date(t.start_date)), r.x_unit, r.x_step),
                        d = this._alignTimeSlot(t.end_date, e.date[r.name + "_start"](new Date(t.end_date)), r.x_unit, r.x_step);
                    d.valueOf() <= o.valueOf() && (d = e.date.add(o, r.x_step, r.x_unit));
                    var l = this.clone(t);
                    switch (l.start_date = o, l.end_date = d, l.section = t.section || this._getNextSection(), a) {
                        case "up":
                            l.section = this._getNextSection(t.section, -1);
                            break;
                        case "down":
                            l.section = this._getNextSection(t.section, 1);
                            break;
                        case "left":
                            l.start_date = this.findVisibleColumn(e.date.add(l.start_date, -r.x_step, r.x_unit), -1), l.end_date = e.date.add(l.start_date, r.x_step, r.x_unit);
                            break;
                        case "right":
                            l.start_date = this.findVisibleColumn(e.date.add(l.start_date, r.x_step, r.x_unit), 1),
                                l.end_date = e.date.add(l.start_date, r.x_step, r.x_unit)
                    }
                    return (l.start_date.valueOf() < n.min_date.valueOf() || l.start_date.valueOf() >= n.max_date.valueOf()) && (i && l.start_date.valueOf() >= n.max_date.valueOf() ? l.start_date = new Date(n.max_date) : (l.start_date = e.date[n.mode + "_start"](e.date.add(n.date, "left" == a ? -1 : 1, n.mode)), l.end_date = e.date.add(l.start_date, r.x_step, r.x_unit))), l
                },
                nextUnitsSlot: function(t, a, i) {
                    var n = this.clone(t);
                    n.section = t.section || this._getNextSection();
                    var r = t.section || this._getNextSection(),
                        o = e.getState(),
                        d = e._props[o.mode];
                    switch (a) {
                        case "left":
                            r = this._getNextSection(t.section, -1);
                            var l = d.size ? d.size - 1 : d.options.length;
                            d.days > 1 && d.order[r] == l - 1 && e.date.add(t.start_date, -1, "day").valueOf() >= o.min_date.valueOf() && (n = this.nextDaySlot(t, a, i));
                            break;
                        case "right":
                            r = this._getNextSection(t.section, 1), d.days > 1 && !d.order[r] && e.date.add(t.start_date, 1, "day").valueOf() < o.max_date.valueOf() && (n = this.nextDaySlot(t, a, i));
                            break;
                        default:
                            n = this.nextDaySlot(t, a, i), r = t.section
                    }
                    return n.section = r, n
                },
                _moveDate: function(t, a) {
                    var i = this.findVisibleColumn(e.date.add(t, a, "day"), a);
                    return i.setHours(t.getHours()), i.setMinutes(t.getMinutes()), i
                },
                isBeforeLastHour: function(t, a) {
                    var i = t.getMinutes(),
                        n = t.getHours(),
                        r = e.config.last_hour;
                    return r > n || !a && (24 == r || n == r) && !i
                },
                isAfterFirstHour: function(t, a) {
                    var i = t.getMinutes(),
                        n = t.getHours(),
                        r = e.config.first_hour,
                        o = e.config.last_hour;
                    return n >= r || !a && !i && (!n && 24 == o || n == o)
                },
                isInVisibleDayTime: function(e, t) {
                    return this.isBeforeLastHour(e, t) && this.isAfterFirstHour(e, t)
                },
                nextDaySlot: function(t, a, i) {
                    var n, r, o = e.config.key_nav_step,
                        d = this._alignTimeSlot(t.start_date, e.date.day_start(new Date(t.start_date)), "minute", o),
                        l = t.start_date;
                    switch (a) {
                        case "up":
                            if (n = e.date.add(d, -o, "minute"), !this.isInVisibleDayTime(n, !0) && (!i || this.isInVisibleDayTime(l, !0))) {
                                var s = !0;
                                i && e.date.date_part(new Date(n)).valueOf() != e.date.date_part(new Date(l)).valueOf() && (s = !1), s && (n = this.findVisibleColumn(e.date.add(t.start_date, -1, "day"), -1)), n.setHours(e.config.last_hour), n.setMinutes(0), n = e.date.add(n, -o, "minute")
                            }
                            r = e.date.add(n, o, "minute");
                            break;
                        case "down":
                            n = e.date.add(d, o, "minute");
                            var _ = i ? n : e.date.add(n, o, "minute");
                            if (!this.isInVisibleDayTime(_, !1) && (!i || this.isInVisibleDayTime(l, !1)))
                                if (i) {
                                    var s = !0;
                                    e.date.date_part(new Date(l)).valueOf() == l.valueOf() && (s = !1), s && (n = this.findVisibleColumn(e.date.add(t.start_date, 1, "day"), 1)), n.setHours(e.config.first_hour), n.setMinutes(0), n = e.date.add(n, o, "minute")
                                } else n = this.findVisibleColumn(e.date.add(t.start_date, 1, "day"), 1), n.setHours(e.config.first_hour), n.setMinutes(0);
                            r = e.date.add(n, o, "minute");
                            break;
                        case "left":
                            n = this._moveDate(t.start_date, -1), r = this._moveDate(t.end_date, -1);
                            break;
                        case "right":
                            n = this._moveDate(t.start_date, 1), r = this._moveDate(t.end_date, 1);
                            break;
                        default:
                            n = d, r = e.date.add(n, o, "minute")
                    }
                    return {
                        start_date: n,
                        end_date: r
                    }
                },
                nextWeekAgendaSlot: function(t, a) {
                    var i, n, r = e.getState();
                    switch (a) {
                        case "down":
                        case "left":
                            i = e.date.day_start(e.date.add(t.start_date, -1, "day")), i = this.findVisibleColumn(i, -1);
                            break;
                        case "up":
                        case "right":
                            i = e.date.day_start(e.date.add(t.start_date, 1, "day")), i = this.findVisibleColumn(i, 1);
                            break;
                        default:
                            i = e.date.day_start(t.start_date)
                    }
                    return (t.start_date.valueOf() < r.min_date.valueOf() || t.start_date.valueOf() >= r.max_date.valueOf()) && (i = new Date(r.min_date)),
                        n = new Date(i), n.setHours(e.config.last_hour), {
                            start_date: i,
                            end_date: n
                        }
                },
                nextAgendaSlot: function(e, t) {
                    return {
                        start_date: e.start_date,
                        end_date: e.end_date
                    }
                },
                isDateVisible: function(t) {
                    if (!e._ignores_detected) return !0;
                    var a, i = e.matrix && e.matrix[e.getState().mode];
                    return a = i ? e._get_date_index(i, t) : e.locate_holder_day(t), !e._ignores[a]
                },
                findVisibleColumn: function(t, a) {
                    var i = t;
                    a = a || 1;
                    for (var n = e.getState(); !this.isDateVisible(i) && (a > 0 && i.valueOf() <= n.max_date.valueOf() || 0 > a && i.valueOf() >= n.min_date.valueOf());) i = this.nextDateColumn(i, a);
                    return i
                },
                nextDateColumn: function(t, a) {
                    a = a || 1;
                    var i, n = e.matrix && e.matrix[e.getState().mode];
                    return i = n ? e.date.add(t, a * n.x_step, n.x_unit) : e.date.day_start(e.date.add(t, a, "day"))
                },
                isVisible: function(t, a) {
                    if (!e._ignores_detected) return !0;
                    for (var i = new Date(t); i.valueOf() < a.valueOf();) {
                        if (this.isDateVisible(i)) return !0;
                        i = this.nextDateColumn(i)
                    }
                    return !1
                },
                nextSlot: function(t, a, i, n) {
                    var r;
                    i = i || this._getMode();
                    var o = e.$keyboardNavigation.TimeSlot.prototype.clone(t);
                    switch (i) {
                        case this._modes.units:
                            r = this.nextUnitsSlot(o, a, n);
                            break;
                        case this._modes.timeline:
                            r = this.nextTimelineSlot(o, a, n);
                            break;
                        case this._modes.year:
                            r = this.nextMonthSlot(o, a, n);
                            break;
                        case this._modes.month:
                            r = this.nextMonthSlot(o, a, n);
                            break;
                        case this._modes.weekAgenda:
                            r = this.nextWeekAgendaSlot(o, a, n);
                            break;
                        case this._modes.list:
                            r = this.nextAgendaSlot(o, a, n);
                            break;
                        case this._modes.dayColumns:
                            r = this.nextDaySlot(o, a, n)
                    }
                    return r.start_date.valueOf() >= r.end_date.valueOf() && (r = this.nextSlot(r, a, i)), e.$keyboardNavigation.TimeSlot.prototype.clone(r)
                },
                extendSlot: function(t, a) {
                    var i, n = this._getMode();
                    switch (n) {
                        case this._modes.units:
                            i = "left" == a || "right" == a ? this.nextUnitsSlot(t, a) : this.extendUnitsSlot(t, a);
                            break;
                        case this._modes.timeline:
                            i = "down" == a || "up" == a ? this.nextTimelineSlot(t, a) : this.extendTimelineSlot(t, a);
                            break;
                        case this._modes.year:
                            i = this.extendMonthSlot(t, a);
                            break;
                        case this._modes.month:
                            i = this.extendMonthSlot(t, a);
                            break;
                        case this._modes.dayColumns:
                            i = this.extendDaySlot(t, a);
                            break;
                        case this._modes.weekAgenda:
                            i = this.extendWeekAgendaSlot(t, a);
                            break;
                        default:
                            i = t
                    }
                    var r = e.getState();
                    return i.start_date.valueOf() < r.min_date.valueOf() && (i.start_date = this.findVisibleColumn(r.min_date), i.start_date.setHours(e.config.first_hour)), i.end_date.valueOf() > r.max_date.valueOf() && (i.end_date = this.findVisibleColumn(r.max_date, -1)), e.$keyboardNavigation.TimeSlot.prototype.clone(i)
                },
                extendTimelineSlot: function(e, t) {
                    return this.extendGenericSlot({
                        left: "start_date",
                        right: "end_date"
                    }, e, t, "timeline")
                },
                extendWeekAgendaSlot: function(e, t) {
                    return this.extendGenericSlot({
                        left: "start_date",
                        right: "end_date"
                    }, e, t, "weekAgenda")
                },
                extendGenericSlot: function(t, a, i, n) {
                    var r, o = a.movingDate;
                    if (o || (o = t[i]), !o || !t[i]) return a;
                    if (!i) return e.$keyboardNavigation.TimeSlot.prototype.clone(a);
                    r = this.nextSlot({
                        start_date: a[o],
                        section: a.section
                    }, i, n, !0), r.start_date.valueOf() == a.start_date.valueOf() && (r = this.nextSlot({
                        start_date: r.start_date,
                        section: r.section
                    }, i, n, !0)), r.movingDate = o;
                    var d = this.extendSlotDates(a, r, r.movingDate);
                    return d.end_date.valueOf() <= d.start_date.valueOf() && (r.movingDate = "end_date" == r.movingDate ? "start_date" : "end_date"),
                        d = this.extendSlotDates(a, r, r.movingDate), r.start_date = d.start_date, r.end_date = d.end_date, r
                },
                extendSlotDates: function(e, t, a) {
                    var i = {
                        start_date: null,
                        end_date: null
                    };
                    return "start_date" == a ? (i.start_date = t.start_date, i.end_date = e.end_date) : (i.start_date = e.start_date, i.end_date = t.start_date), i
                },
                extendMonthSlot: function(t, a) {
                    var t = this.extendGenericSlot({
                        up: "start_date",
                        down: "end_date",
                        left: "start_date",
                        right: "end_date"
                    }, t, a, "month");
                    return t.start_date.setHours(e.config.first_hour), t.end_date = e.date.add(t.end_date, -1, "day"),
                        t.end_date.setHours(e.config.last_hour), t
                },
                extendUnitsSlot: function(e, t) {
                    var a;
                    switch (t) {
                        case "down":
                        case "up":
                            a = this.extendDaySlot(e, t);
                            break;
                        default:
                            a = e
                    }
                    return a.section = e.section, a
                },
                extendDaySlot: function(e, t) {
                    return this.extendGenericSlot({
                        up: "start_date",
                        down: "end_date",
                        left: "start_date",
                        right: "end_date"
                    }, e, t, "dayColumns")
                },
                scrollSlot: function(t) {
                    var a = e.getState(),
                        i = this.nextSlot(this, t);
                    (i.start_date.valueOf() < a.min_date.valueOf() || i.start_date.valueOf() >= a.max_date.valueOf()) && e.setCurrentView(new Date(i.start_date)),
                        this.moveTo(i)
                },
                keys: {
                    left: function() {
                        this.scrollSlot("left")
                    },
                    right: function() {
                        this.scrollSlot("right")
                    },
                    down: function() {
                        var t = this._getMode();
                        t == this._modes.list ? e.$keyboardNavigation.SchedulerNode.prototype.nextEventHandler() : this.scrollSlot("down")
                    },
                    up: function() {
                        var t = this._getMode();
                        t == this._modes.list ? e.$keyboardNavigation.SchedulerNode.prototype.prevEventHandler() : this.scrollSlot("up")
                    },
                    "shift+down": function() {
                        this.moveTo(this.extendSlot(this, "down"))
                    },
                    "shift+up": function() {
                        this.moveTo(this.extendSlot(this, "up"));
                    },
                    "shift+right": function() {
                        this.moveTo(this.extendSlot(this, "right"))
                    },
                    "shift+left": function() {
                        this.moveTo(this.extendSlot(this, "left"))
                    },
                    enter: function() {
                        var t = {
                                start_date: new Date(this.start_date),
                                end_date: new Date(this.end_date)
                            },
                            a = e.getState().mode;
                        if (e.matrix && e.matrix[a]) {
                            var i = e.matrix[e.getState().mode];
                            t[i.y_property] = this.section
                        } else if (e._props && e._props[a]) {
                            var n = e._props[a];
                            t[n.map_to] = this.section
                        }
                        e.addEventNow(t)
                    }
                }
            }), e.$keyboardNavigation.TimeSlot.prototype.bindAll(e.$keyboardNavigation.TimeSlot.prototype.keys),
            e.$keyboardNavigation.MinicalButton = function(e, t) {
                this.container = e, this.index = t || 0
            }, e.$keyboardNavigation.MinicalButton.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                isValid: function() {
                    return !0
                },
                focus: function() {
                    e.$keyboardNavigation.dispatcher.globalNode.disable(), this.container.removeAttribute("tabindex"), e.$keyboardNavigation.KeyNavNode.prototype.focus.apply(this)
                },
                blur: function() {
                    this.container.setAttribute("tabindex", "0"), e.$keyboardNavigation.KeyNavNode.prototype.blur.apply(this)
                },
                getNode: function() {
                    return this.index ? this.container.querySelector(".dhx_cal_next_button") : this.container.querySelector(".dhx_cal_prev_button")
                },
                keys: {
                    right: function(t) {
                        this.moveTo(new e.$keyboardNavigation.MinicalButton(this.container, this.index ? 0 : 1))
                    },
                    left: function(t) {
                        this.moveTo(new e.$keyboardNavigation.MinicalButton(this.container, this.index ? 0 : 1))
                    },
                    down: function() {
                        var t = new e.$keyboardNavigation.MinicalCell(this.container, 0, 0);
                        t && !t.isValid() && (t = t.fallback()), this.moveTo(t)
                    },
                    enter: function(e) {
                        this.getNode().click()
                    }
                }
            }), e.$keyboardNavigation.MinicalButton.prototype.bindAll(e.$keyboardNavigation.MinicalButton.prototype.keys), e.$keyboardNavigation.MinicalCell = function(e, t, a) {
                this.container = e, this.row = t || 0, this.col = a || 0
            }, e.$keyboardNavigation.MinicalCell.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                isValid: function() {
                    var e = this._getGrid();
                    return !(!e[this.row] || !e[this.row][this.col])
                },
                fallback: function() {
                    var t = this.row,
                        a = this.col,
                        i = this._getGrid();
                    i[t] || (t = 0);
                    var n = !0;
                    if (t > i.length / 2 && (n = !1),
                        !i[t]) {
                        var r = new e.$keyboardNavigation.TimeSlot;
                        return r.isValid() ? r : new e.$keyboardNavigation.DataArea
                    }
                    if (n) {
                        for (var o = a; o < i[t].length; o++)
                            if (i[t][o] || o != i[t].length - 1 || (t++, a = 0), i[t][o]) return new e.$keyboardNavigation.MinicalCell(this.container, t, o)
                    } else
                        for (var o = a; o < i[t].length; o--)
                            if (i[t][o] || o || (t--, a = i[t].length - 1), i[t][o]) return new e.$keyboardNavigation.MinicalCell(this.container, t, o);
                    return new e.$keyboardNavigation.MinicalButton(this.container, 0)
                },
                focus: function() {
                    e.$keyboardNavigation.dispatcher.globalNode.disable(),
                        this.container.removeAttribute("tabindex"), e.$keyboardNavigation.KeyNavNode.prototype.focus.apply(this)
                },
                blur: function() {
                    this.container.setAttribute("tabindex", "0"), e.$keyboardNavigation.KeyNavNode.prototype.blur.apply(this)
                },
                _getNode: function(e, t) {
                    return this.container.querySelector(".dhx_year_body tr:nth-child(" + (e + 1) + ") td:nth-child(" + (t + 1) + ")")
                },
                getNode: function() {
                    return this._getNode(this.row, this.col)
                },
                _getGrid: function() {
                    for (var t = this.container.querySelectorAll(".dhx_year_body tr"), a = [], i = 0; i < t.length; i++) {
                        a[i] = [];
                        for (var n = t[i], r = n.querySelectorAll("td"), o = 0; o < r.length; o++) {
                            var d = r[o],
                                l = !0,
                                s = e._getClassName(d);
                            (s.indexOf("dhx_after") > -1 || s.indexOf("dhx_before") > -1 || s.indexOf("dhx_scale_ignore") > -1) && (l = !1), a[i][o] = l
                        }
                    }
                    return a
                },
                keys: {
                    right: function(t) {
                        var a = this._getGrid(),
                            i = this.row,
                            n = this.col + 1;
                        a[i] && a[i][n] || (a[i + 1] ? (i += 1, n = 0) : n = this.col);
                        var r = new e.$keyboardNavigation.MinicalCell(this.container, i, n);
                        r.isValid() || (r = r.fallback()), this.moveTo(r)
                    },
                    left: function(t) {
                        var a = this._getGrid(),
                            i = this.row,
                            n = this.col - 1;
                        a[i] && a[i][n] || (a[i - 1] ? (i -= 1, n = a[i].length - 1) : n = this.col);
                        var r = new e.$keyboardNavigation.MinicalCell(this.container, i, n);
                        r.isValid() || (r = r.fallback()), this.moveTo(r)
                    },
                    down: function() {
                        var t = this._getGrid(),
                            a = this.row + 1,
                            i = this.col;
                        t[a] && t[a][i] || (a = this.row);
                        var n = new e.$keyboardNavigation.MinicalCell(this.container, a, i);
                        n.isValid() || (n = n.fallback()), this.moveTo(n)
                    },
                    up: function() {
                        var t = this._getGrid(),
                            a = this.row - 1,
                            i = this.col;
                        if (t[a] && t[a][i]) {
                            var n = new e.$keyboardNavigation.MinicalCell(this.container, a, i);
                            n.isValid() || (n = n.fallback()), this.moveTo(n)
                        } else {
                            var r = 0;
                            this.col > t[this.row].length / 2 && (r = 1), this.moveTo(new e.$keyboardNavigation.MinicalButton(this.container, r))
                        }
                    },
                    enter: function(e) {
                        this.getNode().querySelector(".dhx_month_head").click()
                    }
                }
            }), e.$keyboardNavigation.MinicalCell.prototype.bindAll(e.$keyboardNavigation.MinicalCell.prototype.keys), e.$keyboardNavigation.DataArea = function(e) {
                this.index = e || 0
            }, e.$keyboardNavigation.DataArea.prototype = e._compose(e.$keyboardNavigation.KeyNavNode, {
                getNode: function(t) {
                    return e.$container.querySelector(".dhx_cal_data")
                },
                _handlers: null,
                isValid: function() {
                    return !0
                },
                fallback: function() {
                    return this
                },
                keys: {
                    "up,down,right,left": function() {
                        this.moveTo(new e.$keyboardNavigation.TimeSlot)
                    }
                }
            }), e.$keyboardNavigation.DataArea.prototype.bindAll(e.$keyboardNavigation.DataArea.prototype.keys), dhtmlx._modalsStack || (dhtmlx._modalsStack = []),
            function() {
                function t() {
                    return !(!s.length && !dhtmlx._modalsStack.length)
                }

                function a(e, t) {
                    for (; e && e != t;) e = e.parentNode;
                    return !(e != t)
                }

                function i(i) {
                    setTimeout(function() {
                        t() || a(document.activeElement, e.$container) || e.focus()
                    }, 1)
                }

                function n(t) {
                    e.eventRemove(t, "keydown", d), e.event(t, "keydown", d), s.push(t)
                }

                function r() {
                    var t = s.pop();
                    t && e.eventRemove(t, "keydown", d), i(t)
                }

                function o(e) {
                    return dhtmlx._modalsStack.length ? e == dhtmlx._modalsStack[dhtmlx._modalsStack.length - 1] : e == s[s.length - 1]
                }

                function d(t) {
                    var t = t || window.event,
                        a = t.currentTarget;
                    o(a) && e.$keyboardNavigation.trapFocus(a, t)
                }

                function l() {
                    n(e.getLightbox())
                }
                var s = [];
                if (e.attachEvent("onLightbox", l),
                    e.attachEvent("onAfterLightbox", r), e.attachEvent("onAfterQuickInfo", function() {
                        i()
                    }), !dhtmlx._keyNavMessagePopup) {
                    dhtmlx._keyNavMessagePopup = !0;
                    var _ = null,
                        c = null;
                    dhtmlx.attachEvent("onMessagePopup", function(t) {
                        for (_ = document.activeElement, c = _; c && e._getClassName(c).indexOf("dhx_cal_data") < 0;) c = c.parentNode;
                        c && (c = c.parentNode), e.eventRemove(t, "keydown", d), e.event(t, "keydown", d), dhtmlx._modalsStack.push(t)
                    }), dhtmlx.attachEvent("onAfterMessagePopup", function() {
                        var t = dhtmlx._modalsStack.pop();
                        t && e.eventRemove(t, "keydown", d),
                            setTimeout(function() {
                                for (var t = document.activeElement; t && e._getClassName(t).indexOf("dhx_cal_light") < 0;) t = t.parentNode;
                                t || (_ && _.parentNode ? _.focus() : c && c.parentNode && c.focus(), _ = null, c = null)
                            }, 1)
                    })
                }
                e.$keyboardNavigation.isModal = t
            }(), e.$keyboardNavigation.dispatcher = {
                isActive: !1,
                activeNode: null,
                globalNode: new e.$keyboardNavigation.SchedulerNode,
                enable: function() {
                    e.$container && (this.isActive = !0, this.globalNode.enable(), this.setActiveNode(this.getActiveNode()))
                },
                disable: function() {
                    this.isActive = !1, this.globalNode.disable();
                },
                isEnabled: function() {
                    return !!this.isActive
                },
                getDefaultNode: function() {
                    return this.globalNode.getDefaultNode()
                },
                setDefaultNode: function() {
                    this.setActiveNode(this.getDefaultNode())
                },
                getActiveNode: function() {
                    var e = this.activeNode;
                    return e && !e.isValid() && (e = e.fallback()), e
                },
                focusGlobalNode: function() {
                    this.blurNode(this.globalNode), this.focusNode(this.globalNode)
                },
                setActiveNode: function(e) {
                    e && e.isValid() && (this.activeNode && this.activeNode.compareTo(e) || this.isEnabled() && (this.blurNode(this.activeNode),
                        this.activeNode = e, this.focusNode(this.activeNode)))
                },
                focusNode: function(t) {
                    t && t.focus && (t.focus(), t.getNode && document.activeElement != t.getNode() && this.setActiveNode(new e.$keyboardNavigation.DataArea))
                },
                blurNode: function(e) {
                    e && e.blur && e.blur()
                },
                keyDownHandler: function(t) {
                    if (!t.defaultPrevented) {
                        var a = this.getActiveNode();
                        if ((!e.$keyboardNavigation.isModal() || a && a.container && e._locate_css({
                                target: a.container
                            }, "dhx_minical_popup", !1)) && !e.getState().editor_id && this.isEnabled()) {
                            t = t || window.event;
                            var i = this.globalNode,
                                n = e.$keyboardNavigation.shortcuts.getCommandFromEvent(t);
                            a ? a.findHandler(n) ? a.doAction(n, t) : i.findHandler(n) && i.doAction(n, t) : this.setDefaultNode()
                        }
                    }
                },
                _timeout: null,
                delay: function(e, t) {
                    clearTimeout(this._timeout), this._timeout = setTimeout(e, t || 1)
                }
            }, e._temp_key_scope = function() {
                function t(e) {
                    e = e || window.event, o.x = e.clientX, o.y = e.clientY
                }

                function a() {
                    for (var t = !1, a = !1, i = document.elementFromPoint(o.x, o.y); i && i != e._obj;) i = i.parentNode;
                    return t = !(i != e._obj), a = e.$keyboardNavigation.dispatcher.isEnabled(), t || a
                }

                function i(e) {
                    delete e.rec_type, delete e.rec_pattern,
                        delete e.event_pid, delete e.event_length
                }

                function n() {
                    var t = e.$keyboardNavigation.dispatcher.getActiveNode();
                    return t && t.eventId ? t.eventId : e._select_id
                }
                e.config.key_nav = !0, e.$keyboardNavigation._pasteDate = null, e.$keyboardNavigation._pasteSection = null;
                var r = null,
                    o = {};
                document.body ? dhtmlxEvent(document.body, "mousemove", t) : dhtmlxEvent(window, "load", function() {
                    dhtmlxEvent(document.body, "mousemove", t)
                }), e.attachEvent("onMouseMove", function(t, a) {
                    var i = e.getState();
                    if (i.mode && i.min_date) {
                        var n = e.getActionData(a);
                        e.$keyboardNavigation._pasteDate = n.date, e.$keyboardNavigation._pasteSection = n.section
                    }
                }), e._make_pasted_event = function(t) {
                    var a = e.$keyboardNavigation._pasteDate,
                        n = e.$keyboardNavigation._pasteSection,
                        r = t.end_date - t.start_date,
                        o = e._lame_copy({}, t);
                    if (i(o), o.start_date = new Date(a), o.end_date = new Date(o.start_date.valueOf() + r), n) {
                        var d = e._get_section_property();
                        e.config.multisection ? o[d] = t[d] : o[d] = n
                    }
                    return o
                }, e._do_paste = function(t, a, i) {
                    e.addEvent(a), e.callEvent("onEventPasted", [t, a, i])
                }, e._is_key_nav_active = function() {
                    return this._is_initialized() && !this._is_lightbox_open() && this.config.key_nav ? !0 : !1
                }, e._key_nav_copy_paste = function(t) {
                    if (!e._is_key_nav_active()) return !0;
                    if (t = t || event, 37 == t.keyCode || 39 == t.keyCode) {
                        t.cancelBubble = !0;
                        var i = e.date.add(e._date, 37 == t.keyCode ? -1 : 1, e._mode);
                        return e.setCurrentView(i), !0
                    }
                    var o = n();
                    if ((t.ctrlKey || t.metaKey) && 67 == t.keyCode) return o && (e._buffer_id = o, r = !0, e.callEvent("onEventCopied", [e.getEvent(o)])), !0;
                    if ((t.ctrlKey || t.metaKey) && 88 == t.keyCode && o) {
                        r = !1, e._buffer_id = o;
                        var d = e.getEvent(o);
                        e.updateEvent(d.id), e.callEvent("onEventCut", [d])
                    }
                    if ((t.ctrlKey || t.metaKey) && 86 == t.keyCode && a(t)) {
                        var d = e.getEvent(e._buffer_id);
                        if (d) {
                            var l = e._make_pasted_event(d);
                            if (r) l.id = e.uid(), e._do_paste(r, l, d);
                            else {
                                var s = e.callEvent("onBeforeEventChanged", [l, t, !1, d]);
                                s && (e._do_paste(r, l, d), r = !0)
                            }
                        }
                        return !0
                    }
                }
            }, e._temp_key_scope(),
            function() {
                function t() {
                    if (e.config.key_nav) {
                        var t, a = document.activeElement;
                        return t = !a || e._locate_css(a, "dhx_cal_quick_info", !1) ? !1 : e.$keyboardNavigation.isChildOf(a, e.$container) || e.$keyboardNavigation.isMinical(a);
                    }
                }

                function a(e) {
                    e && !i.isEnabled() ? i.enable() : !e && i.isEnabled() && i.disable()
                }
                e.$keyboardNavigation.attachSchedulerHandlers = function() {
                    function t(t) {
                        if (!e.config.key_nav) return !0;
                        var a, n = e.getActionData(t);
                        e._locate_event(t.target || t.srcElement) ? a = new e.$keyboardNavigation.Event(e._locate_event(t.target || t.srcElement)) : (a = new e.$keyboardNavigation.TimeSlot, n.date && (a = a.nextSlot(new e.$keyboardNavigation.TimeSlot(n.date, null, n.section)))), i.isEnabled() ? n.date && i.delay(function() {
                            i.setActiveNode(a)
                        }) : i.activeNode = a;
                    }

                    function a(t) {
                        if (e.config.key_nav && i.isEnabled()) {
                            var a = t,
                                n = new e.$keyboardNavigation.Event(a.eventId);
                            if (!n.isValid()) {
                                var r = n.start || a.start,
                                    o = n.end || a.end,
                                    d = n.section || a.section;
                                n = new e.$keyboardNavigation.TimeSlot(r, o, d), n.isValid() || (n = new e.$keyboardNavigation.TimeSlot)
                            }
                            i.setActiveNode(n);
                            var l = i.getActiveNode();
                            l && l.getNode && document.activeElement != l.getNode() && i.focusNode(i.getActiveNode())
                        }
                    }
                    var i = e.$keyboardNavigation.dispatcher,
                        n = function(t) {
                            return e.config.key_nav && !e._edit_id ? i.keyDownHandler(t) : void 0;
                        },
                        r = function() {
                            i.focusGlobalNode()
                        };
                    e.attachEvent("onDataRender", function() {
                        if (e.config.key_nav && i.isEnabled() && !e.getState().editor_id) {
                            var t = i.getActiveNode();
                            if (t instanceof e.$keyboardNavigation.MinicalButton || t instanceof e.$keyboardNavigation.MinicalCell) return;
                            t.isValid() ? i.focusNode(t) : i.setActiveNode(t.fallback()), i.focusNode(i.getActiveNode())
                        }
                    }), e.attachEvent("onSchedulerReady", function() {
                        var a = e.$container;
                        e.eventRemove(document, "keydown", n), e.eventRemove(a, "mousedown", t), e.eventRemove(a, "focus", r),
                            e.config.key_nav ? (e.event(document, "keydown", n), e.event(a, "mousedown", t), e.event(a, "focus", r), a.setAttribute("tabindex", "0")) : a.removeAttribute("tabindex")
                    });
                    var o = e.updateEvent;
                    e.updateEvent = function(t) {
                        var n = o.apply(this, arguments);
                        if (e.config.key_nav && i.isEnabled() && e.getState().select_id == t) {
                            var r = new e.$keyboardNavigation.Event(t);
                            e.getState().lightbox_id || a(r)
                        }
                        return n
                    }, e.attachEvent("onEventDeleted", function(t) {
                        if (!e.config.key_nav) return !0;
                        if (i.isEnabled()) {
                            var a = i.getActiveNode();
                            a.eventId == t && i.setActiveNode(new e.$keyboardNavigation.TimeSlot);
                        }
                        return !0
                    }), e.attachEvent("onClearAll", function() {
                        return e.config.key_nav ? void(i.isEnabled() && i.getActiveNode() instanceof e.$keyboardNavigation.Event && i.setActiveNode(new e.$keyboardNavigation.TimeSlot)) : !0
                    })
                }, e.$keyboardNavigation._minicalendars = [], e.$keyboardNavigation.isMinical = function(t) {
                    for (var a = e.$keyboardNavigation._minicalendars, i = 0; i < a.length; i++)
                        if (this.isChildOf(t, a[i])) return !0;
                    return !1
                }, e.$keyboardNavigation.isChildOf = function(e, t) {
                    for (; e && e !== t;) e = e.parentNode;
                    return !(e !== t)
                }, e.$keyboardNavigation.patchMinicalendar = function() {
                    function t(t) {
                        var a = t.target;
                        i.enable(), i.setActiveNode(new e.$keyboardNavigation.MinicalButton(a, 0))
                    }

                    function a(t) {
                        var a = t.target || t.srcElement,
                            n = e._locate_css(t, "dhx_cal_prev_button", !1),
                            r = e._locate_css(t, "dhx_cal_next_button", !1),
                            o = e._locate_css(t, "dhx_year_body", !1),
                            d = 0,
                            l = 0;
                        if (o) {
                            for (var s, _, c = a; c && "td" != c.tagName.toLowerCase();) c = c.parentNode;
                            if (c && (_ = c, s = _.parentNode), s && _) {
                                for (var u = s.parentNode.querySelectorAll("tr"), h = 0; h < u.length; h++)
                                    if (u[h] == s) {
                                        d = h;
                                        break
                                    } for (var p = s.querySelectorAll("td"), h = 0; h < p.length; h++)
                                    if (p[h] == _) {
                                        l = h;
                                        break
                                    }
                            }
                        }
                        var v = t.currentTarget;
                        i.delay(function() {
                            (n || r || o) && (i.enable(), i.activeNode = null), n ? i.setActiveNode(new e.$keyboardNavigation.MinicalButton(v, 0)) : r ? i.setActiveNode(new e.$keyboardNavigation.MinicalButton(v, 1)) : o && i.setActiveNode(new e.$keyboardNavigation.MinicalCell(v, d, l))
                        })
                    }
                    var i = e.$keyboardNavigation.dispatcher;
                    if (e.renderCalendar) {
                        var n = e.renderCalendar;
                        e.renderCalendar = function() {
                            var r = n.apply(this, arguments),
                                o = e.$keyboardNavigation._minicalendars;
                            e.eventRemove(r, "click", a), e.event(r, "click", a),
                                e.eventRemove(r, "focus", t), e.event(r, "focus", t);
                            for (var d = !1, l = 0; l < o.length; l++)
                                if (o[l] == r) {
                                    d = !0;
                                    break
                                } if (d || o.push(r), i.isEnabled()) {
                                var s = i.getActiveNode();
                                s.container == r ? i.focusNode(s) : r.setAttribute("tabindex", "0")
                            } else r.setAttribute("tabindex", "0");
                            return r
                        }
                    }
                    if (e.destroyCalendar) {
                        var r = e.destroyCalendar;
                        e.destroyCalendar = function(a, i) {
                            a = a || (e._def_count ? e._def_count.firstChild : null);
                            var n = r.apply(this, arguments);
                            if (!a || !a.parentNode)
                                for (var o = e.$keyboardNavigation._minicalendars, d = 0; d < o.length; d++) o[d] == a && (e.eventRemove(o[d], "focus", t),
                                    o.splice(d, 1), d--);
                            return n
                        }
                    }
                };
                var i = e.$keyboardNavigation.dispatcher;
                if (e.$keyboardNavigation.attachSchedulerHandlers(), e.renderCalendar) e.$keyboardNavigation.patchMinicalendar();
                else var n = e.attachEvent("onSchedulerReady", function() {
                    e.detachEvent(n), e.$keyboardNavigation.patchMinicalendar()
                });
                setInterval(function() {
                    if (e.$container && e.$keyboardNavigation.isChildOf(e.$container, document.body)) {
                        var n = t();
                        n ? a(n) : !n && i.isEnabled() && setTimeout(function() {
                            e.config.key_nav ? a(t()) : e.$container.removeAttribute("tabindex");
                        }, 100)
                    }
                }, 500)
            }()
    }
    window.Scheduler ? window.Scheduler.plugin(e) : e(window.scheduler)
}();