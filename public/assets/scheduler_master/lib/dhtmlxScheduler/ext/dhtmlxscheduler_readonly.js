/*
@license
dhtmlxScheduler v.4.4.4 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
Scheduler.plugin(function(e) {
    e.attachEvent("onTemplatesReady", function() {
        function t(e, t, a, n) {
            for (var i = t.getElementsByTagName(e), r = a.getElementsByTagName(e), o = r.length - 1; o >= 0; o--) {
                var a = r[o];
                if (n) {
                    var d = document.createElement("SPAN");
                    d.className = "dhx_text_disabled", d.innerHTML = n(i[o]), a.parentNode.insertBefore(d, a), a.parentNode.removeChild(a)
                } else a.disabled = !0, t.checked && (a.checked = !0)
            }
        }
        var a = e.config.lightbox.sections.slice(),
            n = e.config.buttons_left.slice(),
            i = e.config.buttons_right.slice();
        e.attachEvent("onBeforeLightbox", function(t) {
            if (this.config.readonly_form || this.getEvent(t).readonly) {
                this.config.readonly_active = !0;
                for (var r = 0; r < this.config.lightbox.sections.length; r++) this.config.lightbox.sections[r].focus = !1
            } else this.config.readonly_active = !1, e.config.lightbox.sections = a.slice(), e.config.buttons_left = n.slice(), e.config.buttons_right = i.slice();
            var o = this.config.lightbox.sections;
            if (this.config.readonly_active) {
                for (var r = 0; r < o.length; r++)
                    if ("recurring" == o[r].type) {
                        this.config.readonly_active && o.splice(r, 1);
                        break
                    } for (var d = ["dhx_delete_btn", "dhx_save_btn"], l = [e.config.buttons_left, e.config.buttons_right], r = 0; r < d.length; r++)
                    for (var s = d[r], _ = 0; _ < l.length; _++) {
                        for (var c = l[_], u = -1, h = 0; h < c.length; h++)
                            if (c[h] == s) {
                                u = h;
                                break
                            } - 1 != u && c.splice(u, 1)
                    }
            }
            return this.resetLightbox(), !0
        });
        var r = e._fill_lightbox;
        e._fill_lightbox = function() {
            var a = this.getLightbox();
            this.config.readonly_active && (a.style.visibility = "hidden", a.style.display = "block");
            var n = r.apply(this, arguments);
            if (this.config.readonly_active && (a.style.visibility = "", a.style.display = "none"), this.config.readonly_active) {
                var i = this.getLightbox(),
                    d = this._lightbox_r = i.cloneNode(!0);
                d.id = e.uid(), t("textarea", i, d, function(e) {
                    return e.value
                }), t("input", i, d, !1), t("select", i, d, function(e) {
                    return e.options.length ? e.options[Math.max(e.selectedIndex || 0, 0)].text : ""
                }), i.parentNode.insertBefore(d, i), o.call(this, d), e._lightbox && e._lightbox.parentNode.removeChild(e._lightbox), this._lightbox = d, e.config.drag_lightbox && (d.firstChild.onmousedown = e._ready_to_dnd), this.setLightboxSize(), d.onclick = function(t) {
                    var a = t ? t.target : event.srcElement;
                    if (e._getClassName(a) || (a = a.previousSibling), a && a.className) switch (e._getClassName(a)) {
                        case "dhx_cancel_btn":
                            e.callEvent("onEventCancel", [e._lightbox_id]), e._edit_stop_event(e.getEvent(e._lightbox_id), !1), e.hide_lightbox()
                    }
                }, d.onkeydown = function(t) {
                    var a = t || window.event,
                        n = t.target || t.srcElement,
                        i = n.querySelector("[dhx_button]");
                    switch (i || (i = n.parentNode.querySelector(".dhx_custom_button, .dhx_readonly")), (t || a).keyCode) {
                        case 32:
                            if ((t || a).shiftKey) return;
                            i && i.click && i.click();
                            break;
                        case e.keys.edit_cancel:
                            e.cancel_lightbox()
                    }
                }
            }
            return n
        };
        var o = e.showCover;
        e.showCover = function() {
            this.config.readonly_active || o.apply(this, arguments);
        };
        var d = e.hide_lightbox;
        e.hide_lightbox = function() {
            return this._lightbox_r && (this._lightbox_r.parentNode.removeChild(this._lightbox_r), this._lightbox_r = this._lightbox = null), d.apply(this, arguments)
        }
    })
});