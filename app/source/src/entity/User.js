import React from 'react'

export default class User extends React.Component {
    state = {
        token: localStorage.getItem("token"),
        setting: {
            'binance_public_key': 'test',
            'binance_secret_key': 'tes',
            'mono_bank_token': 'te',
        }
    };

    constructor(props) {
        super(props);
    }
}
