import {useState} from 'react';
import {Link} from "react-router-dom";

import {loginUser} from "../../functions/AuthFunctions";

export default function LoginPage() {
    const [username, setUsername] = useState();
    const [password, setPassword] = useState();

    const handleSubmit = async e => {
        e.preventDefault();

        await loginUser({
            username,
            password,
        });
    }

    return (
        <div className="card-body login-card-body">
            <p className="login-box-msg">Please Log In</p>

            <form className="card-body login-card-body" onSubmit={handleSubmit}>
                <div className="input-group mb-3">
                    <input placeholder="Username" className="form-control" type="text"
                           onChange={e => setUsername(e.target.value)}/>

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

            <Link className="nav-link" to="/registration">
                <span>Reg In</span>
            </Link>
        </div>
    );
}
