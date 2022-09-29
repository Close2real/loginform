import {Router} from 'symfony-ts-router';

const routes = require('./ajax_routes.json');

const ApiRouter = new Router();

ApiRouter.setRoutingData(routes);

export default ApiRouter;


