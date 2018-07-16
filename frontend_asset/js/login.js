function login() {
    $("#check").val("1"), $(".loginEmail").val() ? $("#logLoginEmail").html("") : ($("#check").val("0"), $("#logLoginEmail").html("* Email Id is Required")), $(".loginPassword").val() ? $("#logLoginPassword").html("") : ($("#check").val("0"), $("#logLoginPassword").html("* Password is Required")), setTimeout(function() {
        if (1 == $("#check").val()) {
            1 == document.getElementById("checkbox-2").checked ? (localStorage.usrname = $(".loginEmail").val(), localStorage.pass = $(".loginPassword").val(), localStorage.chkbx = $("#checkbox-2").val()) : (localStorage.usrname = "", localStorage.pass = "", localStorage.chkbx = ""), $("#divLoading").addClass("show");
            var e = $(".loginEmail").val(),
                a = $(".loginPassword").val(),
                i = $("#userType").val();
            $.ajax({
                url: "login/userLogin",
                type: "post",
                data: {
                    email: e,
                    password: a,
                    userType: i
                },
                success: function(e) {
                    $.isNumeric(e) ? (firebase.auth().signInWithEmailAndPassword($(".loginEmail").val(), $(".loginPassword").val()).catch(function(e) {
                        e.code, e.message
                    }), myLogin(e)) : ($("#logLoginPassword").html(e), $("#divLoading").removeClass("show"))
                }
            })
        }
    }, 1e3)
}

function validateEmail(e) {
    return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(e)
}

function singUp() {
    $("#check").val("1"), $(".SUemailId").val() ? validateEmail($(".SUemailId").val()) ? $("#reqEmailId").html("") : ($("#check").val("0"), $("#reqEmailId").html("The E-mail field must contain a valid email address.")) : ($("#check").val("0"), $("#reqEmailId").html("* Email Id is Required")), $(".SUuserName").val() ? $("#reqUserName").html("") : ($("#check").val("0"), $("#reqUserName").html("* User Name is Required")), $(".SUpassword").val() ? $("#reqPassword").html("") : ($("#check").val("0"), $("#reqPassword").html("* Password is Required")), $(".SUconfirmPassword").val() ? $("#reqConfirmPassword").html("") : ($("#check").val("0"), $("#reqConfirmPassword").html("* Confirm Password is Required")), $(".SUfirstName").val() ? $("#reqFirstName").html("") : ($("#check").val("0"), $("#reqFirstName").html("* First Name is Required")), $(".SUlastName").val() ? $("#reqLastName").html("") : ($("#check").val("0"), $("#reqLastName").html("* Last Name is Required")), $(".SUcontactNumber").val() ? (intRegex = /[0-9 -()+]+$/, $(".SUcontactNumber").val().length > 13 || $(".SUcontactNumber").val().length < 9 || !intRegex.test($(".SUcontactNumber").val()) ? ($("#check").val("0"), $("#reqContactNumber").html("Please enter a valid phone number")) : $("#reqContactNumber").html("")) : ($("#check").val("0"), $("#reqContactNumber").html("* Contact Number is Required")), $("input[name=deliveryDate]").val() ? $("#reqDob").html("") : ($("#check").val("0"), $("#reqDob").html("* Date of Birth is Required"));
    var e = $("#file-1").prop("files")[0];
    if ((new FormData).append("file", e), "" != $(".SUpassword").val() && "" != $(".SUconfirmPassword").val() && $(".SUpassword").val() != $(".SUconfirmPassword").val() && ($("#check").val("0"), $("#reqConfirmPassword").html("* Password does not match the confirm password")), "" != $(".SUemailId").val() && "" != $(".SUcontactNumber").val() && 1 == $("#check").val()) {
        var a = "login/checkSingUp";
        $.ajax({
            url: a,
            type: "POST",
            data: {
                page: a,
                email: $(".SUemailId").val(),
                mobileNumber: $(".SUcontactNumber").val()
            },
            cache: !1,
            success: function(e) {
                1 == e ? ($("#check").val("0"), $("#reqEmailId").html("* The E-mail field must contain a unique value")) : 2 == e ? ($("#check").val("0"), $("#reqContactNumber").html("* The Contact Number field must contain a unique value")) : 3 == e ? ($("#check").val("0"), $("#reqEmailId").html("* The E-mail field must contain a unique value"), $("#reqContactNumber").html("* The Contact Number field must contain a unique value")) : ($("#reqEmailId").html(""), $("#reqContactNumber").html(""))
            }
        })
    }
    setTimeout(function() {
        if (1 == $("#check").val()) {
            $("#divLoading").addClass("show"), firebase.auth().createUserWithEmailAndPassword($(".SUemailId").val(), $(".SUpassword").val()).then(function() {
                var e = firebase.database(),
                    a = "0",
                    i = firebase.auth().currentUser;
                if (i) a = i.uid;
                else firebase.auth().signInWithEmailAndPassword($(".SUemailId").val(), $(".SUpassword").val()).then(function() {
                    firebase.auth().currentUser.uid
                }).catch(function(e) {
                    e.code, e.message
                });
                setTimeout(function() {
                    e.ref().child("users").child(a).set({
                        email: $(".SUemailId").val(),
                        firebaseToken: "WEBOVENGO",
                        name: $(".SUuserName").val(),
                        uid: a,
                        userImage: "",
                        userType: $("#userType").val()
                    }), singUpFun(a)
                }, 5e3)
            }).catch(function(e) {
                e.code, e.message
            })
        }
    }, 1e3)
}

function singUpFun(e) {
    $("#divLoading").addClass("show");
    var a = $("#file-1").prop("files")[0],
        i = new FormData;
    i.append("file", a), i.append("latitude", $("#loginLat").val()), i.append("longitude", $("#loginLong").val()), i.append("email", $(".SUemailId").val()), i.append("userName", $(".SUuserName").val()), i.append("password", $(".SUpassword").val()), i.append("confirmPassword", $(".SUconfirmPassword").val()), i.append("mobileNumber", $(".SUcontactNumber").val()), i.append("userType", $("#userType").val()), i.append("firstName", $(".SUfirstName").val()), i.append("lastName", $(".SUlastName").val()), i.append("dateOfBirth", $("input[name=deliveryDate]").val()), i.append("fireBaseId", e), $.ajax({
        url: "login/singUp",
        cache: !1,
        contentType: !1,
        processData: !1,
        data: i,
        type: "post",
        success: function(e) {
            $.isNumeric(e) ? myLogin(e) : (alertError(e), $("#divLoading").removeClass("show"))
        }
    })
}

function showLogin() {
    $(".pTEXT").html(""), $("#logSing").hide(300), $("#singup").hide(300), $("#login").show(300)
}

function showSingup() {
    $("input[name=deliveryDate]").val(""), $("input[name=deliveryDate]").attr("placeholder", "Date Of Birth"), $(".pTEXT").html(""), $("#logSing").hide(300), $("#singup").show(300), $("#login").hide(300)
}

function hideLogSing() {
    $(".pTEXT").html(""), $("#logSing").show(300), $("#userType").val(""), $("#singup").hide(300), $("#login").hide(300)
}

function setUserType(e) {
    $(".pTEXT").html(""), 1 == e ? ($("#showCook").hide(), $("#showUser").show()) : ($("#showUser").hide(), $("#showCook").show()), $("#userType").val(e)
}

function alertError(e) {
    var a = e.split(".").join("<br>");
    $("#alertError").html(a), $("#alert").slideDown(300), setTimeout(function() {
        $("#alert").slideUp(300)
    }, 5e3)
}

function sendMail() {
    $("#divLoading").addClass("show");
    var e = baseUrl + "index.php/service/forgotPassword";
    $.ajax({
        url: e,
        type: "POST",
        data: {
            page: e,
            email: $(".emailid").val()
        },
        cache: !1,
        success: function(e) {
            $("#forgotPassword").html(e.message), $("#divLoading").removeClass("show"), "success" == e.status ? setTimeout(function() {
                $("#forgotPassword").html(""), $("#target").click()
            }, 5e3) : setTimeout(function() {
                $("#forgotPassword").html("")
            }, 5e3)
        }
    })
}

function removeP(e) {
    $("#" + e).html("")
}

function fbLogin() {
    FB.login(function(e) {
        e.authResponse ? getFbUserData() : document.getElementById("status").innerHTML = "User cancelled login or did not fully authorize."
    }, {
        scope: "email"
    })
}

function getFbUserData() {
    FB.api("/me", {
        locale: "en_US",
        fields: "id,first_name,last_name,email,birthday"
    }, function(e) {
        $("#divLoading").addClass("show"), FB.logout(function() {}), FB.logout(function() {});
        var a = $("#loginLat").val(),
            i = $("#loginLong").val(),
            o = $("#userType").val(),
            t = "login/singUp",
            l = "http://graph.facebook.com/" + e.id + "/picture?type=large";
        firebase.auth().createUserWithEmailAndPassword(e.email, "123456").then(function() {
            firebase.database();
            var s = "0",
                n = firebase.auth().currentUser;
            if (n) s = n.uid;
            else firebase.auth().signInWithEmailAndPassword(e.email, "123456").then(function() {
                firebase.auth().currentUser.uid
            }).catch(function(e) {
                e.code, e.message
            });
            $.ajax({
                url: t,
                type: "POST",
                data: {
                    page: t,
                    socialId: e.id,
                    email: e.email,
                    mobileNumber: "",
                    firstName: e.first_name,
                    lastName: e.last_name,
                    userName: e.first_name + e.last_name,
                    mobileNumber: "",
                    profileImage: l,
                    latitude: a,
                    userType: o,
                    longitude: i,
                    fireBaseId: s
                },
                cache: !1,
                success: function(e) {
                    $.isNumeric(e) ? (FB.logout(function() {}), FB.logout(function() {}), fbLogout(), $("#divLoading").removeClass("show"), myLogin(e)) : (FB.logout(function() {}), FB.logout(function() {}), fbLogout(), $("#logLoginPassword").html(e), $("#divLoading").removeClass("show"))
                }
            })
        }).catch(function(s) {
            uidd = "", firebase.auth().signInWithEmailAndPassword(e.email, "123456").then(function() {
                firebase.auth().currentUser.uid
            }).catch(function(e) {
                e.code, e.message
            }), $.ajax({
                url: t,
                type: "POST",
                data: {
                    page: t,
                    socialId: e.id,
                    email: e.email,
                    mobileNumber: "",
                    firstName: e.first_name,
                    lastName: e.last_name,
                    userName: e.first_name + e.last_name,
                    mobileNumber: "",
                    profileImage: l,
                    latitude: a,
                    userType: o,
                    longitude: i,
                    fireBaseId: uidd
                },
                cache: !1,
                success: function(e) {
                    $.isNumeric(e) ? (FB.logout(function() {}), FB.logout(function() {}), fbLogout(), $("#divLoading").removeClass("show"), myLogin(e)) : (FB.logout(function() {}), FB.logout(function() {}), fbLogout(), $("#logLoginPassword").html(e), $("#divLoading").removeClass("show"))
                }
            });
            s.code, s.message
        })
    })
}

function fbLogout() {
    FB.logout(function() {})
}
$.ajax({
        url: "//ovengo.com/geoplugin.class/",
        type: "POST",
        dataType: "json",
        success: function(e) {
            $("#loginLat").val(e.latitude), $("#loginLong").val(e.longitude)
        }
    }), $("html, body").animate({
        scrollTop: 0
    }, "slow"), localStorage.chkbx && "" != localStorage.chkbx ? ($("#checkbox-2").attr("checked", "checked"), $(".loginEmail").val(localStorage.usrname), $(".loginPassword").val(localStorage.pass)) : ($("#checkbox-2").removeAttr("checked"), $(".loginEmail").val(""), $(".loginPassword").val("")), window.fbAsyncInit = function() {
        FB.init({
            appId: "1724386664261932",
            xfbml: !0,
            version: "v2.10"
        }), FB.AppEvents.logPageView()
    },
    function(e, a, i) {
        var o, t = e.getElementsByTagName(a)[0];
        e.getElementById(i) || ((o = e.createElement(a)).id = i, o.src = "//connect.facebook.net/en_US/sdk.js", t.parentNode.insertBefore(o, t))
    }(document, "script", "facebook-jssdk");