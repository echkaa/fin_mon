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
    if (response.error !== undefined) {
        NotificationError(response.error.message);
        throw response.error.message;
    }

    return callback(response);
}

export async function requestWithAuthCheck(url, method, body = null, headers = null) {
    if (method === 'GET') {
        url = url + "?" + encodeQueryData(body);
    }

    let status = null,
        response = await fetch(url, {
            method: method,
            headers: headers,
            body: method !== 'GET' ? JSON.stringify(body) : null
        }).then(function (response) {
            if (response.status === 401) {
                logout();
            }

            status = response.status;

            return response.json();
        });

    response.status = status;

    return executeWithCheckOnError(
        response,
        (response) => response
    )
}
