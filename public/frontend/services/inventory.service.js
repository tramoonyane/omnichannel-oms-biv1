import api from "./api.js";


export function getInventory(){

    return api.get(
        "/inventory"
    );

}