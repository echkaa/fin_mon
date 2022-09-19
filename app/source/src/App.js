import './css/App.css';

import AppHeader from "./components/AppHeader.js";
import AppSitebar from "./components/AppSitebar.js";
import AppContent from "./components/AppContent.js";

import AuthContent from "./components/Auth/AuthContent.js";


export default function App() {
    if (localStorage.getItem('token') === null) {
        return <AuthContent/>
    }

    return (
            <div className="wrapper">
                <AppHeader/>
                <AppSitebar/>
                <AppContent/>
            </div>
    );
}
