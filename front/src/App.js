import React, {useState} from 'react';

import './css/App.css';

import AppHeader from "./components/AppHeader";
import AppSitebar from "./components/AppSitebar";
import AppContent from "./components/AppContent";

import AuthContent from "./components/Auth/AuthContent";


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
