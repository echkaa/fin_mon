import WebSocket from 'ws';

const futuresWS = new WebSocket('wss://stream.binance.com:9443/ws/!markPrice@arr@1s');

futuresWS.on('ping', (e) => {
    futuresWS.pong();
});

export {futuresWS}
