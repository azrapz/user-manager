$(document).ajaxError(function (e, xhr, settings) {
    if (xhr.status == 401) {
        window.location.href = '/login';
    }
    if (xhr.status == 403) {
        alert('User has no permission to this action');
    }

});

$(document).ready(function () {
    // disable datatables error alert popup, better ux on no auth
    try {
        $.fn.dataTable.ext.errMode = 'throw';
    } catch (e) {}
})

function setCookie(key, value, expiry) {
    let expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function eraseCookie(key) {
    var keyValue = getCookie(key);
    setCookie(key, keyValue, '-1');
}

function checkPermissions(permission) {
    $.ajax({
        type:'GET',
        url: '/api/role-check',
        headers: {
            'Authorization': getCookie('token')
        },
        data: {permission},
        success: function(data){
            //
        },
        errors: function(data){
            alert('User has no permission to this action');
        }
    });
}
