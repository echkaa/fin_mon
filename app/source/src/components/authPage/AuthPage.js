export default function AuthPage(props) {
    return (
        <div className="login-page">
            <div className="login-box">
                <div className="card">
                    {props.content}
                </div>
            </div>
        </div>
    );
}
