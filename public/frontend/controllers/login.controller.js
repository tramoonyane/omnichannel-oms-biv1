import { login } from "../services/auth.service.js";
import { saveToken, saveUser } from "../utils/storage.js";


const form =
    document.getElementById("loginForm");

const message =
    document.getElementById("message");


form.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();

        const email =
            document.getElementById("email").value;

        const password =
            document.getElementById("password").value;

        try {

            const response =
                await login(
                    email,
                    password
                );

            saveToken(
                response.token
            );

            saveUser(
                response.user
            );

            message.textContent =
                "Login successful.";

            window.location.href =
                "dashboard.html";

        }

        catch (error) {

            message.textContent =
                error.message;

        }

    }
);