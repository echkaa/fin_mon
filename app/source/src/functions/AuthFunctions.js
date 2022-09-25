import {executeWithCheckOnError} from "./RequestFunctions";

export function logout() {
    localStorage.removeItem('token');

    window.location.reload();
}

export async function loginUser(credentials) {
    let response = await fetch('/api/v1/auth/token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })
    .then(data => data.json());

    executeWithCheckOnError(
            response,
            function (response) {
                localStorage.setItem('token', response.result.token);

                window.location.reload();
            }
    )
}

export async function registrationUser(credentials) {
    let response = await fetch('/api/v1/auth/registration', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })
    .then(data => data.json());

    executeWithCheckOnError(
            response,
            function (response) {
                localStorage.setItem('token', response.result.token);

                window.location.reload();
            }
    )
}
