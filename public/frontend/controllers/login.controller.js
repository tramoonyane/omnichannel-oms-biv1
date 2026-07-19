import { login } from "../services/auth.service.js";
import { saveToken, saveUser } from "../utils/storage.js";
import "../utils/theme.js";


const form =
    document.getElementById("loginForm");


const message =
    document.getElementById("message");


const loginButton =
    document.getElementById("loginButton");



form.addEventListener(

    "submit",

    async function(event) {


        event.preventDefault();



        const email =
            document.getElementById("email").value.trim();



        const password =
            document.getElementById("password").value;



        /*
        ----------------------------------------
        LOGIN LOADING STATE
        ----------------------------------------
        */


        loginButton.disabled = true;

        loginButton.textContent =
            "Authenticating...";

        message.textContent = "";

        message.className =
            "message";



        try {


            const response =
                await login(
                    email,
                    password
                );



            /*
            ----------------------------------------
            STORE JWT AUTH DATA
            ----------------------------------------
            */


            saveToken(
                response.token
            );


            saveUser(
                response.user
            );



            /*
            ----------------------------------------
            SUCCESS MESSAGE
            ----------------------------------------
            */


            message.textContent =
                "Login successful. Redirecting...";


            message.style.color =
                "#16a34a";



            /*
            ----------------------------------------
            SMALL DELAY FOR UX
            ----------------------------------------
            */


            setTimeout(

                () => {

                    window.location.href =
                        "dashboard.html";

                },

                800

            );



        }


        catch(error) {



            /*
            ----------------------------------------
            ERROR HANDLING
            ----------------------------------------
            */


            message.textContent =
                error.message ||
                "Authentication failed.";


            message.style.color =
                "#dc2626";



            loginButton.disabled =
                false;


            loginButton.textContent =
                "Login";

        }



    }

);