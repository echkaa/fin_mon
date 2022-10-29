import {redisStore} from "./redis.js";
import WebSocket from 'ws';

const ws = new WebSocket('wss://stream.binance.com:9443/ws/!ticker_1h@arr');

ws.on('ping', (e) => {
    ws.pong();
});

var skipCount = 1;

ws.on('message', (data) => {
    if (data && ++skipCount === 5) {
        skipCount = 0;

        const coins = JSON.parse(data); // parsing single-trade record

        coins.map(function (coin) {
            redisStore('coin-price_' + coin.s, coin.c);
        });
    }
});
