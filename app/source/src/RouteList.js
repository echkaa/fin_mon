import {
    Routes,
    Route,
} from "react-router-dom";

import TestPage from "./pages/Test";
import DashboardPage from "./pages/Dashboard";

import LoginPage from "./pages/auth/Login";
import RegistrationPage from "./pages/auth/Registration";

import AppPage from "./components/AppPage";
import AuthPage from "./components/Auth/AuthPage";

import RouteAdminGuard from "./components/security/RouteAdminGuard";
import RouteAuthGuard from "./components/security/RouteAuthGuard";

export default function RouteList() {
    return (
            <Routes>
                <Route path="*" element={<RouteAdminGuard page={<AppPage content={<DashboardPage/>}/>}/>}/>
                <Route path="test" element={<RouteAdminGuard page={<AppPage content={<TestPage/>}/>}/>}/>

                <Route path="login" element={<RouteAuthGuard page={<AuthPage content={<LoginPage/>}/>}/>}/>
                <Route path="registration"
                       element={<RouteAuthGuard page={<AuthPage content={<RegistrationPage/>}/>}/>}/>
            </Routes>
    );
}
