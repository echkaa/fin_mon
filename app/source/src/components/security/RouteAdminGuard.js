import React from 'react';
import {Navigate} from 'react-router-dom';

const RouteAdminGuard = ({page}) => {

    if (localStorage.getItem("token") === null) {
        return <Navigate to="/login" replace/>;
    }

    return page;
};

export default RouteAdminGuard;
