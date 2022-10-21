import React from 'react';
import StatisticByCoinBlock from "../components/block/binance/StatisticByCoin";

export default class BinancePage extends React.Component {
    constructor(props) {
        super(props)
    }

    render() {
        return (
            <div>
                <StatisticByCoinBlock/>
            </div>
        );
    }
}
