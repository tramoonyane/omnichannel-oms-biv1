import api from "./api.js";


export function getOrders(){

    return api.get(
        "/orders"
    );

}