import {useState} from 'react';

async function loginUser(credentials) {
    return fetch('/api/v1/token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })
            .then(data => data.json())
}

export default function LoginPage() {
    const [clientId, setClientId] = useState();
    const [password, setPassword] = useState();

    const handleSubmit = async e => {
        e.preventDefault();
        const response = await loginUser({
            clientId,
            password
        });

        localStorage.setItem('token', response.result.token);

        window.location.reload();
    }

    return (
            <div className="card-body login-card-body">
                <p className="login-box-msg">Please Log In</p>

                <form className="card-body login-card-body" onSubmit={handleSubmit}>
                    <div className="input-group mb-3">
                        <input placeholder="Client Id" className="form-control" type="text"
                               onChange={e => setClientId(e.target.value)}/>

                        <div className="input-group-append">
                            <div className="input-group-text">
                                <span className="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div className="input-group mb-3">
                        <input placeholder="Password" className="form-control" type="password"
                               onChange={e => setPassword(e.target.value)}/>

                        <div className="input-group-append">
                            <div className="input-group-text">
                                <span className="fa-solid fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-12">
                            <button type="submit" className="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
    );
}