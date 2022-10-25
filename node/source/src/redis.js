import {createClient} from 'redis';

const redisClient = createClient({
    socket: {
        host: 'redis'
    }
});

redisClient.on('error', (err) => console.log('Redis Client Error', err));

await redisClient.connect();

export default redisClient;
