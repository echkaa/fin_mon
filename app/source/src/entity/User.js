import React from 'react'
import {requestWithAuthCheck} from "../functions/RequestFunctions";
import UserContext from "./UserContext";

export default class User extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            token: localStorage.getItem("token"),
            username: '',
            setting: {
                binance_public_key: null,
                binance_private_key: null,
                mono_bank_token: null,
            },
            profile: null,
        };

        this.setBinancePublicKey = this.setBinancePublicKey.bind(this);
        this.setBinancePrivateKey = this.setBinancePrivateKey.bind(this);
        this.setMonoBankToken = this.setMonoBankToken.bind(this);
    }

    setBinancePublicKey(event) {
        let state = this.state;
        state.setting.binance_public_key = event.target.value;

        this.setState(state)
    }

    setBinancePrivateKey(event) {
        let state = this.state;
        state.setting.binance_private_key = event.target.value;

        this.setState(state)
    }

    setMonoBankToken(event) {
        let state = this.state;
        state.setting.mono_bank_token = event.target.value;

        this.setState(state)
    }

    componentDidMount() {
        if (this.state.token) {
            this.setUserInfo();
        }
    }

    setUserInfo() {
        return requestWithAuthCheck(
            '/api/v1/user/info',
            'GET',
            null,
            {
                'Authorization': 'Bearer ' + this.state.token
            }
        ).then(response => {
            this.setState({
                username: response.result.username,
                setting: {
                    binance_public_key: response.result.binance_public_key,
                    binance_private_key: response.result.binance_private_key,
                    mono_bank_token: response.result.mono_bank_token,
                }
            })
        });
    }

    render() {
        return (
            <UserContext.Provider value={{
                state: this.state,
                setBinancePublicKey: this.setBinancePublicKey,
                setBinancePrivateKey: this.setBinancePrivateKey,
                setMonoBankToken: this.setMonoBankToken,
            }}>
                {this.props.children}
            </UserContext.Provider>
        )
    }
}
