import React from 'react'

export default class User extends React.Component {
    state = {
        token: localStorage.getItem("token")
    };

    constructor(props) {
        super(props);
    }
}
