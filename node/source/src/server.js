import {redisStore} from "./redis.js";
import {spotWS} from "./spotPriceWS.js";

function writingSpotPrice() {
    var skipCount = 1;

    spotWS.on('message', (data) => {
        if (data && ++skipCount === 5) {
            skipCount = 0;

            const coins = JSON.parse(data); // parsing single-trade record

            coins.map(function (coin) {
                redisStore('spot_coin-price_' + coin.s, coin.c);
            });
        }
    });
}

function writingFuturesPrice() {
    var skipCount = 1;

    spotWS.on('message', (data) => {
        if (data && ++skipCount === 5) {
            skipCount = 0;

            const coins = JSON.parse(data); // parsing single-trade record

            coins.map(function (coin) {
                redisStore('futures_coin-price_' + coin.s, coin.c);
            });
        }
    });
}


writingSpotPrice();
writingFuturesPrice();
