import React from 'react';
import UserContext from "../../entity/UserContext";
import {requestWithAuthCheck} from "../../functions/RequestFunctions";
import {NotificationInfo} from "../../functions/NotificationFunctions";

export default class SettingBlock extends React.Component {
    static contextType = UserContext;

    constructor(props) {
        super(props);

        this.saveSetting = this.saveSetting.bind(this);
    }

    saveSetting() {
        requestWithAuthCheck(
            '/api/v1/setting',
            'PUT',
            this.context.state.setting,
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

                            <input value={this.context.state.setting.binance_public_key || ''}
                                   onChange={this.context.setBinancePublicKey}
                                   type="text"
                                   className="form-control"/>
                        </div>

                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">Binance Private Key</span>
                            </div>

                            <input value={this.context.state.setting.binance_private_key || ''}
                                   onChange={this.context.setBinancePrivateKey}
                                   type="text"
                                   className="form-control"/>
                        </div>

                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">MonoBank Token</span>
                            </div>

                            <input value={this.context.state.setting.mono_bank_token || ''}
                                   onChange={this.context.setMonoBankToken}
                                   type="text"
                                   className="form-control"/>

                            <a style={styles.link} target="_blank" href="https://api.monobank.ua/">Token</a>
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

const styles = {
    link: {
        marginTop: "5px",
        marginLeft: "15px",
    }
}
