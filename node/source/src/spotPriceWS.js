import WebSocket from 'ws';

const spotWS = new WebSocket('wss://stream.binance.com:9443/ws/!ticker_1h@arr');

spotWS.on('ping', (e) => {
    spotWS.pong();
});

export {spotWS}
