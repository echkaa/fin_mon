import {createClient} from 'redis';

const redisClient = createClient({
    socket: {
        host: 'redis'
    }
});

redisClient.on('error', (err) => console.log('Redis Client Error', err));

await redisClient.connect();

function redisStore(key, value) {
    redisClient.set(key, value).then(() => {
        console.log(key + " - " + value);
    });
}

export {redisStore}
