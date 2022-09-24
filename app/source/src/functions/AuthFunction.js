export function logout() {
    localStorage.removeItem('token');

    window.location.reload();
}

export async function loginUser(credentials) {
    let response = await fetch('/api/v1/token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })
    .then(data => data.json());

    localStorage.setItem('token', response.result.token);

    window.location.reload();
}
