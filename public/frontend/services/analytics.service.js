import api from "./api.js";


export async function getSalesOverview() {

    return api.get(
        "/analytics/sales/overview"
    );

}


export async function getDailySales() {

    return api.get(
        "/analytics/sales/daily"
    );

}


export async function getTopProducts() {

    return api.get(
        "/analytics/sales/top-products"
    );

}


export async function getInventoryOverview() {

    return api.get(
        "/analytics/inventory"
    );

}


export async function getLowStock() {

    return api.get(
        "/analytics/inventory/low-stock"
    );

}


export async function getHighStock() {

    return api.get(
        "/analytics/inventory/high-stock"
    );

}