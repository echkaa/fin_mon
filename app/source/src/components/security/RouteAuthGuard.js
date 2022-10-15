import React from 'react';
import {Navigate} from 'react-router-dom';
import UserContext from "../../entity/UserContext";

const RouteAuthGuard = ({page}) => {
    const {state} = React.useContext(UserContext);

    if (state.token !== null) {
        return <Navigate to="/" replace/>;
    }

    return page;
};

export default RouteAuthGuard;
