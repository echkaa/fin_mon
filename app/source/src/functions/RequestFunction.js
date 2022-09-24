import AuthLogoutLink from "../components/Auth/AuthLogoutLink";

export async function requestWithAuthCheck(url, method, body = null, headers = null) {
    return fetch(url, {
        method: method,
        headers: headers,
        body: body
    })
    .then(function (response) {
        if (response.status === 401) {
            AuthLogoutLink();
        }

        return response.json();
    })
}
