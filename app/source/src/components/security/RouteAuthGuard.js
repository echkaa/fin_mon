import React from 'react';
import {Navigate} from 'react-router-dom';

const RouteAuthGuard = ({page}) => {

    if (localStorage.getItem("token") !== null) {
        return <Navigate to="/" replace/>;
    }

    return page;
};

export default RouteAuthGuard;
