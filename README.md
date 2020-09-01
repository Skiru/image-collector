### Image collector application
To setup the application run the command to setup docker services.

```
docker-compose up -d --build
```

You should have three containers up and running:
- php
- nginx
- redis


### Running a script 
To run a commad which will download three unique images you have to run:
```
docker-compose exec image-collector-php bin/console img:download
```

### Log file

Log file is located var/log/log.err

### Cleaning redis

Information whether particular image was downloaded is saved in redis. If you
would like to clean the redis use following command:

Connect to redis container 

```
docker exec -it imagecollector_image-collector-redis_1 sh
```

Run redis cli:
```
redis-cli
```

Flush all the keys:
```
FLUSHALL
```

### Images

Images are stored in public/images directory.