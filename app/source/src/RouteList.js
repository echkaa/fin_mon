import {
    Routes,
    Route,
} from "react-router-dom";

import SettingPage from "./pages/Setting";
import DashboardPage from "./pages/Dashboard";
import BinancePage from "./pages/Binance";

import LoginPage from "./pages/auth/Login";
import RegistrationPage from "./pages/auth/Registration";

import AppPage from "./components/page/AppPage";
import AuthPage from "./components/authPage/AuthPage";

import RouteAdminGuard from "./components/security/RouteAdminGuard";
import RouteAuthGuard from "./components/security/RouteAuthGuard";

export default function RouteList() {
    return (
        <Routes>
            <Route path="*" element={<RouteAdminGuard page={<AppPage content={<DashboardPage/>}/>}/>}/>
            <Route path="setting" element={<RouteAdminGuard page={<AppPage content={<SettingPage/>}/>}/>}/>
            <Route path="binance" element={<RouteAdminGuard page={<AppPage content={<BinancePage/>}/>}/>}/>

            <Route path="login" element={<RouteAuthGuard page={<AuthPage content={<LoginPage/>}/>}/>}/>
            <Route path="registration"
                   element={<RouteAuthGuard page={<AuthPage content={<RegistrationPage/>}/>}/>}/>
        </Routes>
    );
}
