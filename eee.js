var m_o = {param: {isFirstLoad: true, sportId: null, eventId: null, version: 0}};
var fglg = false;
var isParlayPage = 0;
var isSingleLineMoreBets = 0;
var m_om = {
    $container: null, moreBetsId: null, _isRendering: false, parseLoad: function (a) {
        if (!m_om._isRendering) {
            if (a.hasClass("expand")) {
                var b = a.parent().closest("tbody").find("div[id=eventContainer][class=morebet-c][eid=" + a.attr("id").substring(4) + "]");
                if (b.size() == 1) {
                    b = b.find("div[class=evt-name]>a[class=btn-close]");
                    if (b.size() == 1) {
                        b.click()
                    }
                }
                b = null
            } else {
                m_o.param.isFirstLoad = true;
                m_o.param.version = 0;
                m_om.$container = null;
                m_om._renderingViewer(a)
            }
        }
    }, closeMoreBets: function (d) {
        if (!m_om._isRendering) {
            var a = d.srcElement ? $(d.srcElement) : $(d.target);
            var c = a.parent().closest("div[id=eventContainer][class=morebet-c]").parent();
            var b = a.parent().closest("tbody");
            b.find("tr[id^=e" + c.attr("id").substring(2) + "]").find("a[id=mbb_" + c.attr("id").substring(2) + "]").removeClass("expand");
            b = null;
            c.empty();
            c = null;
            if (m_om.$container) {
                m_om.$container = null
            }
            if (m_om.moreBetsId) {
                m_om.moreBetsId = null
            }
        }
    }, getMoreBetEventId: function () {
        if (!this.moreBetsId) {
            if (m_om.$container && (m_om.$container.size() == 1)) {
                this.moreBetsId = m_om.$container.attr("id").substr(2)
            } else {
                this.moreBetsId = null
            }
        }
        return this.moreBetsId
    }, _renderingViewer: function (a) {
        this._parsingUrl(a.attr("href"));
        m_om.$container = $(a.parent().closest("table").find("td[id=mb" + m_o.param.eventId + "]"));
        if (m_om.$container && (m_om.$container.size() == 1)) {
            this.moreBetsId = m_om.$container.attr("id").substr(2)
        }
        utility.service("OddsService/GetMoreBetsOdds", m_o.param, "GET", function (b) {
            if (b) {
                if (m_o.param.isFirstLoad) {
                    m_om._resetMoreBetsView();
                    m_om._isRendering = true;
                    m_om._loadTemplateAndDisplay(b, function () {
                        if (!a.hasClass("expand")) {
                            a.addClass("expand")
                        }
                    });
                    UpdateHighLight()
                }
                if (m_o.param.version != b.v) {
                    m_o.param.version = parseInt(b.v)
                }
                b = null
            }
        })
    }, refreshTemplateAndDisplay: function (b, a) {
        if (this.moreBetsId && a.find("a[id=mbb_" + this.moreBetsId + "]").size() == 1) {
            m_om.$container = a.find("#mb" + this.moreBetsId)
        } else {
            m_om.$container = null
        }
        if (m_om.$container && m_om.$container.size() == 1) {
            var d = b.isInplay;
            if (b && b.egs) {
                var c = m_om.$container.attr("id").substr(2);
                for (cmpt in b.egs) {
                    for (evt in b.egs[cmpt].es) {
                        if (b.egs[cmpt].es[evt].k == c) {
                            b = b.egs[cmpt].es[evt];
                            c = null;
                            break
                        }
                    }
                    if (!c) {
                        break
                    }
                }
                isSingleLineMoreBets = (o.param.displayView) ? (o.param.displayView == "1") : false;
                m_om._loadTemplateAndDisplay({e: b, i: d, v: m_o.param.version}, function () {
                    if (m_om.moreBetsId) {
                        var e = a.find("a[id=mbb_" + m_om.moreBetsId + "]");
                        if (e.size() == 1) {
                            if (!e.hasClass("expand")) {
                                e.addClass("expand")
                            }
                        }
                        e = null
                    }
                })
            }
        }
    }, _loadTemplateAndDisplay: function (b, a) {
        var c;
        if (window.parent.gv) {
            c = window.parent.gv.lang
        } else {
            c = window.parent.parent.gv.lang
        }
        var d = c + ".MoreBets.html";
        utility.template("OddsPage/" + d, function (e) {
            b.fglg = fglg;
            b.sportId = parseInt(m_o.param.sportId);
            b.inp = b.i.toString();
            m_om.$container.html(e.process(b));
            m_om.$container.click(m_om.a_click);
            m_om.$container.find("a[class=btn-close][title=Close]").click(m_om.closeMoreBets);
            if (m_o.param.isFirstLoad) {
                m_om.$container.find("div[id=eventContainer][class=morebet-c]").stop(true, true).show("blind", 200, function () {
                    $(window.parent.MainFrame.document).scrollTop($("#mbb_" + m_o.param.eventId).parent().closest("tr").position().top);
                    m_om._isRendering = false
                });
                m_o.param.isFirstLoad = !m_o.param.isFirstLoad
            }
            if (window.parent.gv.at == "False") {
                m_om.$container.find(".odds a").css("cursor", "text").removeAttr("href")
            } else {
                m_om.$container.find(".odds a").css("cursor", "hand")
            }
            if (a) {
                a()
            }
        }, d);
        d = null
    }, a_click: function (c) {
        var a;
        if (c.srcElement) {
            a = $(c.srcElement)
        } else {
            a = $(c.target)
        }
        if (a[0].tagName.toUpperCase() != "A") {
            return
        }
        if (a.hasClass("btn-close")) {
            return
        }
        var d = $("#eventContainer").attr("eid");
        var e = a.attr("hdp");
        if (e == undefined) {
            e = null
        }
        var g = "null:null";
        var f = $("#isInplay").val() == "true" ? true : false;
        if (f) {
            var b = a.parent().closest("#mb" + m_om.moreBetsId);
            if (b && (b.size() == 1)) {
                if (a.parent("td[name*='PKAH']").size() > 0) {
                    g = b.find("#ph" + d).val() + ":" + b.find("#pa" + d).val()
                } else {
                    if (a.parent("td[name*='PKOU']").size() > 0) {
                        g = b.find("#poh" + d).val() + ":" + b.find("#poa" + d).val()
                    } else {
                        if (a.parent("td[name*='CORNER']").size() > 0) {
                            g = b.find("#ch" + d).val() + ":" + b.find("#ca" + d).val()
                        } else {
                            if (a.parent("td[name*='OFFSIDE']").size() > 0) {
                                g = b.find("#oh" + d).val() + ":" + b.find("#oa" + d).val()
                            } else {
                                if (a.parent("td[name*='REDCARDIPAH']").size() > 0) {
                                    g = b.find("#iprh" + d).val() + ":" + b.find("#ipra" + d).val()
                                } else {
                                    if (a.parent("td[name*='REDCARDIPOU']").size() > 0) {
                                        g = b.find("#iproh" + d).val() + ":" + b.find("#iproa" + d).val()
                                    } else {
                                        if (a.parent("td[name*='YELCARDIPAH']").size() > 0) {
                                            g = b.find("#ipyh" + d).val() + ":" + b.find("#ipya" + d).val()
                                        } else {
                                            if (a.parent("td[name*='YELCARDIPOU']").size() > 0) {
                                                g = b.find("#ipyoh" + d).val() + ":" + b.find("#ipyoa" + d).val()
                                            } else {
                                                if (a.parent("td[name*='REDCARD']").size() > 0) {
                                                    g = b.find("#rh" + d).val() + ":" + b.find("#ra" + d).val()
                                                } else {
                                                    if (a.parent("td[name*='YELCARD']").size() > 0) {
                                                        g = b.find("#yh" + d).val() + ":" + b.find("#ya" + d).val()
                                                    } else {
                                                        g = b.find("#sh" + d).val() + ":" + b.find("#sa" + d).val()
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            b = null
        }
        if (isParlayPage) {
            window.parent.NavigatorFrame.Betslip.addToParlay(a.attr("id").substring(1), d, a.html().replace(",", ""), e)
        } else {
            window.parent.NavigatorFrame.Betslip.add(a.attr("id").substring(1), d, a.html().replace(",", ""), e, g, f, true)
        }
        c.stopPropagation();
        c.preventDefault()
    }, _parsingUrl: function (c) {
        m_o.param.sportId = m_o.param.eventId = fglg = isParlayPage = isSingleLineMoreBets = null;
        if (c) {
            var b = [];
            $.each(c.substr(c.indexOf("?") + 1).split("&"), function () {
                $.each(this.split("="), function () {
                    b.push(this)
                })
            });
            for (var a = 0; a < b.length; a += 2) {
                switch (b[a].toLowerCase()) {
                    case"sportid":
                        m_o.param.sportId = b[a + 1];
                        break;
                    case"eventid":
                        m_o.param.eventId = b[a + 1];
                        break;
                    case"fglg":
                        fglg = (b[a + 1].toLowerCase() == "true");
                        break;
                    case"parlay":
                        isParlayPage = b[a + 1];
                        break;
                    case"singleline":
                        isSingleLineMoreBets = parseInt(b[a + 1]);
                        break;
                    default:
                        break
                }
            }
        }
        if (isParlayPage == null) {
            m_o.param.isParlay = false;
            isParlayPage = 0
        } else {
            if (isParlayPage == 1) {
                m_o.param.isParlay = true
            } else {
                m_o.param.isParlay = false
            }
        }
        if (isSingleLineMoreBets == null) {
            isSingleLineMoreBets = 0
        }
    }, _resetMoreBetsView: function () {
        var a = null;
        var b = $("#wrapper").find("#inplayWrapper:visible, #nonInplayWrapper:visible");
        b.find("tr.mb").each(function (c) {
            a = $(this).find("td[id^=mb]");
            a.unbind("click");
            a.empty()
        });
        b.find("a[id^=mbb_]").each(function (c) {
            $(this).removeClass("expand")
        });
        b = a = null
    }
};
function searchStringObjArr(a, c) {
    if (a == null) {
        return []
    }
    var b = $.grep(a, function (e, d) {
        return (e.pId == c)
    });
    return b
}
function setFirstLastScorer(c, d, e, a, f, b) {
    return {pId: c, pName: d, sId1st: e, o1st: a, sIdLast: f, oLast: b}
}
function pushToArray(a, b) {
    a.push(b)
}
function sortObjArray(a, b) {
    if (a.pName.toLowerCase() < b.pName.toLowerCase()) {
        return -1
    }
    if (a.pName.toLowerCase() > b.pName.toLowerCase()) {
        return 1
    }
    return 0
}
function mergeArrays(b, a) {
    var e = [];
    var c = ((b.length > a.length) ? b.length : a.length);
    for (var d = 0; d < c; d++) {
        e.push({Home: null, Away: null});
        if (b[d]) {
            e[d].Home = b[d]
        } else {
            e[d].Home = {pId: null}
        }
        if (a[d]) {
            e[d].Away = a[d]
        } else {
            e[d].Away = {pId: null}
        }
    }
    return e
}
function isFavouriteTeam(b, a, c) {
    if ((b == null && a == null) || (b == 0 && a == 0)) {
        return false
    }
    if (b.substr(0, 1) == "-") {
        return c ? true : false
    } else {
        if (a.substr(0, 1) == "-") {
            return c ? false : true
        }
    }
    return false
}
function formatSpecialBetsJson(d) {
    var e = [];
    for (var b = 0; b < d.length; b++) {
        var a = {};
        if (d[b].st != null) {
            var c = getExistingPeriodResultIndex(e, d[b].mn);
            if (c == -1) {
                a.name = d[b].n;
                a.ah = [];
                a.ou = [];
                if (d[b].st.toLowerCase() == "ha") {
                    a.ah.push(d[b])
                } else {
                    if (d[b].st.toLowerCase() == "ou") {
                        a.ou.push(d[b])
                    }
                }
                e.push(a)
            } else {
                if (d[b].st.toLowerCase() == "ha") {
                    e[c].ah.push(d[b])
                } else {
                    if (d[b].st.toLowerCase() == "ou") {
                        e[c].ou.push(d[b])
                    }
                }
            }
        }
    }
    return e
}
function formatPropositionBetsJson(b) {
    for (var a in b) {
        if ((b[a].o.length % 2) != 0) {
            b[a].o.push(null)
        }
    }
    return b
}
function getExistingPeriodResultIndex(d, a) {
    var c = -1;
    for (var b = 0; b < d.length; b++) {
        if (d[b].name == a) {
            c = b;
            break
        }
    }
    return c
};