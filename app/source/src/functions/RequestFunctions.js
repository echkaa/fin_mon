import {logout} from "./AuthFunctions";
import {NotificationError} from "./NotificationFunctions";

function encodeQueryData(obj, prefix) {
    var str = [],
        p;

    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p,
                v = obj[p];
            str.push((v !== null && typeof v === "object") ?
                encodeQueryData(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }

    return str.join("&");
}

export function executeWithCheckOnError(response, callback) {
    return response.error !== undefined
        ? NotificationError(response.error.message)
        : callback(response)
}

export async function requestWithAuthCheck(url, method, body = null, headers = null) {
    if (method === 'GET') {
        url = url + "?" + encodeQueryData(body);
    }

    let response = await fetch(url, {
        method: method,
        headers: headers,
        body: method === 'POST' ? body : null
    }).then(function (response) {
        if (response.status === 401) {
            logout();
        }

        return response.json();
    });

    return executeWithCheckOnError(
        response,
        function (response) {
            return response;
        });
}
