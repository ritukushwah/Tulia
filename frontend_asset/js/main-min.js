! function($) {
    "use strict";
    var e = $(window);
    e.on("load", function() {
        $(".pre-loader").fadeOut("slow"), AOS.refresh()
    }), $(document).ready(function() {
        function o() {
            Math.abs(f - y) <= m || (y > f && y > w ? g.removeClass("nav-down").addClass("nav-up") : y + $(window).height() < $(document).height() && g.removeClass("nav-up").addClass("nav-down"), f = y)
        }

        function t(e) {
            O.removeClass("active"), e.addClass("active")
        }

        function n() {
            var e = $("#colors-switcher");
            $("#fa-cog").on("click", function(o) {
                o.preventDefault(), e.toggleClass("active")
            }), $(".colors li a").on("click", function(e) {
                e.preventDefault();
                var o = "css/color/" + $(this).data("class");
                $("#colors").attr("href", o), $(this).parent().parent().find("a").removeClass("active"), $(this).addClass("active")
            })
        }

        function a(e) {
            var o = Date.parse(e) - Date.parse(new Date),
                t = Math.floor(o / 1e3 % 60),
                n = Math.floor(o / 1e3 / 60 % 60),
                a = Math.floor(o / 36e5 % 24),
                s = Math.floor(o / 864e5);
            return {
                total: o,
                days: s,
                hours: a,
                minutes: n,
                seconds: t
            }
        }

        function s(e, o) {
            function t() {
                var e = a(o);
                s.innerHTML = e.days, i.innerHTML = ("0" + e.hours).slice(-2), r.innerHTML = ("0" + e.minutes).slice(-2), l.innerHTML = ("0" + e.seconds).slice(-2), e.total <= 0 && clearInterval(c)
            }
            var n = document.getElementById(e),
                s = n.querySelector(".days"),
                i = n.querySelector(".hours"),
                r = n.querySelector(".minutes"),
                l = n.querySelector(".seconds");
            t();
            var c = setInterval(t, 1e3)
        }
        var i = $("#hamburger-menu"),
            r = $("#social-hamburger"),
            l = $(".button-collapse"),
            c = $("#main-header"),
            u = c.outerHeight(),
            d = u / 2,
            v = $("#nav-color"),
            h = 200,
            p, f = 0,
            m = 5,
            g = $("#main-nav"),
            w = g.outerHeight(),
            C = e.width(),
            y;
        e.on("resize", function() {
            C != e.width() && (C = e.width(), l.sideNav("hide"))
        }), r.on("click", function() {
            $(this).toggleClass("open")
        }), l.sideNav({
            draggable: !0,
            closeOnClick: !0,
            onOpen: function() {
                i.addClass("open")
            },
            onClose: function() {
                i.removeClass("open")
            }
        }), $(".dropdown-button").dropdown({
            belowOrigin: !0,
            constrainWidth: !1
        }), $(".slider").slider(), $(".carousel").carousel({
            dist: -70,
            fullWidth: !1,
            shift: 0,
            padding: -100
        }), setInterval(function() {
            $(".carousel").carousel("next")
        }, 1e4), $("#screenshot-next").on("click", function() {
            $(".carousel").carousel("next")
        }), $("#screenshot-prev").on("click", function() {
            $(".carousel").carousel("prev")
        }), $(".collapsible").collapsible(), e.on("scroll", function() {
            if (p = !0, y = $(this).scrollTop(), y > 1e3) return void v.css({
                opacity: 1
            });
            var e = 1 - (d - y + h) / h + 1;
            1 > e ? v.css({
                opacity: e
            }) : v.css({
                opacity: 1
            })
        }), 0 === $(document).scrollTop() && v.css({
            opacity: 0
        }), setInterval(function() {
            p && (o(), p = !1)
        }, 200), $.scrollIt({
            easing: "ease-out",
            topOffset: -1
        }), $(".owl-header").owlCarousel({
            loop: !0,
            responsiveClass: !0,
            items: 1,
            nav: !1,
            dots: !0,
            autoplay: !0,
            margin: 30,
            animateOut: "bounceOutRight",
            animateIn: "bounceInLeft"
        });
        var b = $(".owl-features"),
            O = $(".feature-link");
        b.owlCarousel({
            loop: !0,
            responsiveClass: !0,
            margin: 20,
            autoplay: !0,
            items: 1,
            nav: !1,
            dots: !1,
            animateOut: "slideOutDown",
            animateIn: "fadeInUp"
        }), b.on("changed.owl.carousel", function(e) {
            var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                n = e.item.count;
            (o > n || 0 == o) && (o = n - o % n), o--;
            var a = $(".feature-link:nth(" + o + ")");
            t(a)
        }), O.on("click", function() {
            var e = $(this).data("owl-item");
            b.trigger("to.owl.carousel", e), t($(this))
        }), n(), $(".same-height").matchHeight({
            property: "min-height",
            byRow: !1
        });
    })
}(jQuery);