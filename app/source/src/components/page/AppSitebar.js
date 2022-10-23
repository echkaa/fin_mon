import React from 'react';
import {Link} from "react-router-dom";
import UserContext from "../../entity/UserContext";

export default function AppSitebar() {
    const {state} = React.useContext(UserContext);

    return (
        <aside className="main-sidebar sidebar-dark-primary elevation-4">
            <div className="sidebar">
                <div className="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div className="info">
                        <a href="#" className="d-block">{state.username}</a>
                    </div>
                </div>

                <nav className="mt-2">
                    <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li className="nav-item menu-open">
                            <ul className="nav nav-treeview">
                                <li className="nav-item">
                                    <Link className="nav-link" to="/">
                                        <i className="fa-solid fa-chart-line nav-icon"></i>
                                        <p>Dashboard</p>
                                    </Link>
                                </li>

                                <li className="nav-item">
                                    <Link className="nav-link" to="/binance">
                                        <i className="fa-solid fa-wallet nav-icon"></i>
                                        <p>Binance</p>
                                    </Link>
                                </li>

                                <li className="nav-item">
                                    <Link className="nav-link" to="/setting">
                                        <i className="fa-solid fa-gear nav-icon"></i>
                                        <p>Setting</p>
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
