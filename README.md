# Micro Post Social Media App
**Work in progress**

## Useful commands
- Install composer dependencies ```composer i```
- Install node modules ```npm i```
- Build and start a new docker container ```docker compose up --build```
- Start a local symfony server: ```symfony serve```
- Migrate database: ```symfony console doctrine:migration:migrate```

**To see tailwind CSS styling**
- Run: ```npm run watch```

**To send confirmation email when testing registration**
- Start a worker with: ```symfony console messenger:consume async```