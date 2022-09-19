import {
    Routes,
    Route,
} from "react-router-dom";

import PageDashboard from "../pages/Dashboard.js";
import TestPage from "../pages/Test.js";

export default function AppContent() {
    return (
            <div className="content-wrapper px-4 py-2">
                <Routes>
                    <Route path="*" element={<PageDashboard/>}/>
                    <Route path="test" element={<TestPage/>}/>
                </Routes>
            </div>
    );
}
