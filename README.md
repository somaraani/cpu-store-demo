# cpu-store-demo
A sample project for a CPU store with a PHP Backend, and Angular Front-End. 

This application consists of 3 parts, and they are all dockerized. You can bring up all 3 by running 

```
docker-compose up 
``` 
In the root directory (where the `docker-compose.yml`) file is. 

This should start everything up, however it may take a few minutes the first time to download all images and dependencies. 

Once it's done (you can tell when you can see the database and server logs), you can access the UI at:

```
http://localhost:8888
```

If the data doesn't load initially, give it a few seconds and refresh your browser, since it's possible the DB/Server weren't completely done setting up.
