import { getUser }
from "../utils/storage.js";

import { logout }
from "../utils/auth.js";


export function renderNavbar() {


    const navbar =
        document.getElementById(
            "navbar"
        );


    const user =
        getUser();



    navbar.innerHTML = `


        <header class="navbar">


            <div class="navbar-brand">


                <h1>

                    OmniChannel OMS-BI

                </h1>


                <span>

                    Inventory Intelligence Platform

                </span>


            </div>




            <div class="navbar-user">


                <div class="user-info">


                    <strong>

                        ${user.email}

                    </strong>


                    <small>

                        ${user.role}

                    </small>


                </div>



                <button

                    id="logoutBtn"

                    class="logout-btn">

                    Logout

                </button>


            </div>


        </header>


    `;



    document
        .getElementById(
            "logoutBtn"
        )
        .addEventListener(
            "click",
            logout
        );


}