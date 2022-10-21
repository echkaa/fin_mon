import React from 'react';
import UserContext from "../../../entity/UserContext";
import {requestWithAuthCheck} from "../../../functions/RequestFunctions";


export default class StatisticByCoinBlock extends React.Component {
    static contextType = UserContext;

    constructor(props) {
        super(props);

        this.state = {
            coins: []
        }
    }

    componentDidMount() {
        this.setCoins();
    }

    setCoins() {
        requestWithAuthCheck(
            '/api/v1/binance/statistic/coins',
            'GET',
            null,
            {
                'Authorization': 'Bearer ' + this.context.state.token
            }
        ).then(response => {
            this.setState({
                coins: Object.values(response.result)
            })
        });
    }

    render() {
        return (
            <div style={styles.coinContainer}>
                {this.state.coins.map((coin, index) => {
                    if (coin.factPrice === undefined) {
                        return;
                    }

                    return (
                        <div key={index} style={styles.coinBlock} className={coin.pNL > 0 ? 'plus_pnl' : 'minus_pnl'}>
                            <div style={{
                                color: "rgb(23,72,8)",
                                fontWeight: 'bold'
                            }}>{coin.name}</div>

                            <div>Market price: <span>{coin.marketPrice}</span></div>
                            <div>Fact price: <span>{coin.factPrice}</span></div>
                            <div>PNL: <span>{coin.pNL}</span></div>
                            <div>PNL percent: <span>{coin.pNLPercent}</span></div>
                        </div>
                    );
                })}
            </div>
        );
    }
}

const styles = {
    coinContainer: {
        display: "flex",
        flexWrap: "wrap",
        alignItems: "center",
    },
    coinBlock: {
        border: "1px solid gray",
        borderRadius: "10px",
        margin: "10px",
        padding: "10px",
        flexBasis: "content",
        flexGrow: 1
    }
};
