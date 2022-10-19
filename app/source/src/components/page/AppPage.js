import AppHeader from "./AppHeader";
import AppSitebar from "./AppSitebar";

export default function AppPage(props) {
    return (
        <div className="wrapper">
            <AppHeader/>
            <AppSitebar/>

            <div className="content-wrapper px-4 py-2">
                {props.content}
            </div>
        </div>
    );
}
