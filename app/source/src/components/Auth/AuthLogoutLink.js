import {logout} from "../../functions/AuthFunction";

export default function AuthLogoutLink() {
    const handleLogout = async e => {
        e.preventDefault();

        logout()
    }

    return (
            <a href="#" onClick={handleLogout} className="nav-link">Logout</a>
    );
}
