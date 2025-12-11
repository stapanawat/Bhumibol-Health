import { Config, RouteParam, RouteParamsWithQueryOverload, Router } from 'ziggy-js';

declare global {
    function route(
        name: string,
        params?: RouteParamsWithQueryOverload | RouteParam,
        absolute?: boolean,
        config?: Config,
    ): string;

    function route(
        name?: undefined,
        params?: undefined,
        absolute?: undefined,
        config?: Config,
    ): Router;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof route;
    }
}
