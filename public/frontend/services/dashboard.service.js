import api from "./api.js";


export async function getDashboardSummary() {

    return api.get(
        "/analytics/dashboard/summary"
    );

}