import { getDashboardSummary }
from "../services/dashboard.service.js";


import { requireAuth }
from "../utils/auth.js";


import { renderNavbar }
from "../components/navbar.js";


import { renderSidebar }
from "../components/sidebar.js";


import { renderStatCard }
from "../components/stat-card.js";


import {
    renderTable
}
from "../components/table.js";


requireAuth();


renderNavbar();


renderSidebar();



const stats =
    document.getElementById(
        "stats"
    );


const content =
    document.getElementById(
        "content"
    );



async function loadDashboard(){

    try {


        const data =
            await getDashboardSummary();



        /*
        |
        | Dashboard cards
        |
        */


        renderStatCard(

            stats,

            "Total Products",

            data.inventory.total_products

        );


        renderStatCard(

            stats,

            "Stock Value",

            `M${data.inventory.total_stock_value}`

        );



        if(data.sales){


            renderStatCard(

                stats,

                "Total Orders",

                data.sales.total_orders

            );


            renderStatCard(

                stats,

                "Revenue",

                `M${data.sales.total_revenue}`

            );

        }




        /*
        |
        | Remaining dashboard information
        |
        */


        content.innerHTML = `


            <h2>

                Dashboard

            </h2>


            <p>

                Logged in as:

                <strong>

                    ${data.role}

                </strong>

            </p>


            <hr>


            <h3>

                Alerts

            </h3>


            ${
                data.alerts.length

                ?

                data.alerts.map(alert => `

                    <p>

                        ${alert.message}

                    </p>

                `).join("")

                :

                "<p>No active alerts.</p>"

            }

            <hr>

        `;

        const table =
    document.getElementById(
        "top-products"
    );


renderTable(

    table,

    [

        {
            key:"id",
            label:"ID"
        },

        {
            key:"title",
            label:"Product"
        },

        {
            key:"total_sold",
            label:"Units Sold"
        },

        {
            key:"revenue",
            label:"Revenue"
        }

    ],

    data.top_products

);
    }

    catch(error){


        content.innerHTML = `

            <h3>

                Error

            </h3>


            <p>

                ${error.message}

            </p>

        `;


    }

}



loadDashboard();