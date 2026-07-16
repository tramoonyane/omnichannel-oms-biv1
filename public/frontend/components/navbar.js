import { getUser }
from "../utils/storage.js";

import { logout }
from "../utils/auth.js";


export function renderNavbar() {

    const navbar =
        document.getElementById("navbar");

    const user =
        getUser();


    navbar.innerHTML = `

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            ">

            <h2>
                OmniChannel OMS-BI
            </h2>

            <div>

                <strong>

                    ${user.email}

                </strong>

                |

                ${user.role}

                <button id="logoutBtn">

                    Logout

                </button>

            </div>

        </div>

    `;


    document
        .getElementById("logoutBtn")
        .addEventListener(
            "click",
            logout
        );

}