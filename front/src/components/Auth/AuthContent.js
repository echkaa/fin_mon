import {
    Routes,
    Route,
} from "react-router-dom";

import LoginPage from "../../pages/auth/Login";

export default function AppContent() {
    return (
            <div className="login-page">
                <div className="login-box">
                    <div className="card">
                        <Routes>
                            <Route path="" element={<LoginPage/>}/>
                        </Routes>
                    </div>
                </div>
            </div>
    );
}
