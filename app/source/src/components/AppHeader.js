import AuthLogoutLink from "./Auth/AuthLogoutLink.js";
import {Link} from "react-router-dom";

export default function AppHeader() {
    return (
            <header>
                <nav className="main-header navbar navbar-expand navbar-white navbar-light">
                    <ul className="navbar-nav">
                        <li className="nav-item">
                            <a className="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                    className="fas fa-bars"></i></a>
                        </li>

                        <Link className="nav-item d-none d-sm-inline-block" to="/">
                            <span className="nav-link">Dashboard</span>
                        </Link>
                    </ul>

                    <ul className="navbar-nav ml-auto">
                        <li className="nav-item d-none d-sm-inline-block">
                            <AuthLogoutLink/>
                        </li>
                    </ul>
                </nav>
            </header>
    );
}
