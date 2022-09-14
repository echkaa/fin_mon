import {Link} from "react-router-dom";

export default function AppSitebar() {
    return (
            <aside className="main-sidebar sidebar-dark-primary elevation-4">
                <Link className="brand-link" to="/">
                    <span className="brand-text font-weight-light">Dashboard</span>
                </Link>

                <div className="sidebar">
                    <div className="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div className="info">
                            <a href="#" className="d-block">TODO::username</a>
                        </div>
                    </div>

                    <nav className="mt-2">
                        <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li className="nav-item menu-open">
                                <ul className="nav nav-treeview">
                                    <li className="nav-item">
                                        <Link className="nav-link active" to="/">
                                            <i className="far fa-circle nav-icon"></i>
                                            <p>Dashboard</p>
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/test">
                                            <i className="far fa-circle nav-icon"></i>
                                            <p>Test</p>
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
    );
}
