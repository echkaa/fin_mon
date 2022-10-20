import React from 'react';
import UserContext from "../../entity/UserContext";
import {requestWithAuthCheck} from "../../functions/RequestFunctions";
import {NotificationInfo} from "../../functions/NotificationFunctions";

export default class SettingBlock extends React.Component {
    static contextType = UserContext;

    constructor(props) {
        super(props);

        this.state = {
            setting: {
                binance_public_key: '',
                binance_secret_key: '',
                mono_bank_token: '',
            }
        };

        this.setBinancePublicKey = this.setBinancePublicKey.bind(this);
        this.setBinanceSecretKey = this.setBinanceSecretKey.bind(this);
        this.setMonoBankToken = this.setMonoBankToken.bind(this);
        this.saveSetting = this.saveSetting.bind(this);
    }

    setBinancePublicKey(event) {
        let state = this.state;
        state.setting.binance_public_key = event.target.value;

        this.setState(state)
    }

    setBinanceSecretKey(event) {
        let state = this.state;
        state.setting.binance_secret_key = event.target.value;

        this.setState(state)
    }

    setMonoBankToken(event) {
        let state = this.state;
        state.setting.mono_bank_token = event.target.value;

        this.setState(state)
    }

    componentDidMount() {
        this.setState({
            setting: {
                binance_public_key: this.context.state.setting.binance_public_key,
                binance_secret_key: this.context.state.setting.binance_secret_key,
                mono_bank_token: this.context.state.setting.mono_bank_token,
            }
        })
    }

    saveSetting() {
        requestWithAuthCheck(
            '/api/v1/setting',
            'PUT',
            this.state.setting,
            {
                'Authorization': 'Bearer ' + this.context.state.token
            }
        ).then((response) => {
            NotificationInfo('Success save')
        });
    }

    render() {
        return (
            <div>
                <div className="row">
                    <div className="form-group">
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">Binance Public Key</span>
                            </div>

                            <input value={this.state.setting.binance_public_key || ''}
                                   onChange={this.setBinancePublicKey}
                                   type="text"
                                   className="form-control"/>
                        </div>

                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">Binance Secret Key</span>
                            </div>

                            <input value={this.state.setting.binance_secret_key || ''}
                                   onChange={this.setBinanceSecretKey}
                                   type="text"
                                   className="form-control"/>
                        </div>

                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">MonoBank Token</span>
                            </div>

                            <input value={this.state.setting.mono_bank_token || ''}
                                   onChange={this.setMonoBankToken}
                                   type="text"
                                   className="form-control"/>
                        </div>

                        <button onClick={this.saveSetting}
                                className="btn margin-around btn-primary"
                                type="button">Save
                        </button>
                    </div>
                </div>
            </div>
        );
    }
}
