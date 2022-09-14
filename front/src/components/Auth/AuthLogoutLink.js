export default function AuthLogoutLink() {
    const logout = async e => {
        e.preventDefault();

        localStorage.removeItem('token');

        window.location.reload();
    }

    return (
            <a href="#" onClick={logout} className="nav-link">Logout</a>
    );
}
