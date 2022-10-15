import {logout} from "./AuthFunctions";
import {NotificationError} from "./NotificationFunctions";

export function executeWithCheckOnError(response, callback) {
    return response.error !== undefined
            ? NotificationError(response.error.message)
            : callback(response)
}

export async function requestWithAuthCheck(url, method, body = null, headers = null) {
    let response = await fetch(url, {
        method: method,
        headers: headers,
        body: body
    })
    .then(function (response) {
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
