import React from 'react';
import {Navigate} from 'react-router-dom';
import UserContext from "../../entity/UserContext";

const RouteAdminGuard = ({page}) => {
    const {state} = React.useContext(UserContext);

    if (state.token === null) {
        return <Navigate to="/login" replace/>;
    }

    return page;
};

export default RouteAdminGuard;
