import ReactDOM from 'react-dom/client';
import {BrowserRouter} from "react-router-dom";

import '../node_modules/admin-lte/dist/css/adminlte.css';
import './css/index.css';

import '../node_modules/admin-lte/dist/js/adminlte.js'

import RouteList from "./RouteList";

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
        <BrowserRouter>
            <RouteList/>
        </BrowserRouter>
);
