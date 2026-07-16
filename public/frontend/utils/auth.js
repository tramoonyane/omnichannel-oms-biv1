import { getToken, clearAuth }
from "./storage.js";


export function isAuthenticated() {

    return getToken() !== null;

}


export function requireAuth() {

    if (!isAuthenticated()) {

        window.location.href = "login.html";

    }

}


export function logout() {

    clearAuth();

    window.location.href = "login.html";

}