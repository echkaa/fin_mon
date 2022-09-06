import './css/App.css';

import AppHeader from "./components/AppHeader";
import AppSitebar from "./components/AppSitebar";
import AppContent from "./components/AppContent";


function App() {
    return (
            <div className="wrapper">
                <AppHeader/>
                <AppSitebar/>
                <AppContent/>
            </div>
    );
}

export default App;
