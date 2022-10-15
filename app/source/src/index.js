import ReactDOM from 'react-dom/client';
import React from 'react';
import {BrowserRouter} from "react-router-dom";
import {ToastContainer} from 'react-toastify';

import '../node_modules/admin-lte/dist/css/adminlte.css';
import './css/index.css';

import '../node_modules/admin-lte/dist/js/adminlte.js';

import RouteList from "./RouteList";
import {UserProvider} from "./entity/UserContext";
import User from "./entity/User";

const user = new User();
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
        <BrowserRouter>
            <UserProvider value={user}>
                <RouteList/>

                <ToastContainer/>
            </UserProvider>
        </BrowserRouter>
);
