import { AxiosInstance } from "axios";
import { Config, InputParams, Router } from "ziggy-js";

declare global {
    interface Window {
        _: Lodash,
        axios: AxiosInstance,
    }

    declare function route(): Router;
    declare function route(name: string, params?: InputParams, absolute?: boolean, customZiggy?: Config): string;
}

import { UnwrapRef } from 'vue'
declare module 'vue' {
    interface ComponentCustomProperties {
        readonly route: UnwrapRef<typeof route>
    }
}
