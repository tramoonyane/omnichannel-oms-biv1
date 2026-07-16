import { requireAuth }
from "../utils/auth.js";


import { renderNavbar }
from "../components/navbar.js";


import { renderSidebar }
from "../components/sidebar.js";


import { getOrders }
from "../services/orders.service.js";


import {
    renderTable
}
from "../components/table.js";



requireAuth();


renderNavbar();


renderSidebar();



const orders =
    document.getElementById(
        "orders"
    );



async function loadOrders(){


    try {


        const data =
            await getOrders();



        orders.innerHTML = `


            <h2>

                Orders Management

            </h2>


            <p>

                Order processing overview

            </p>


            <hr>


            <div id="orders-table">

            </div>


        `;



        const table =
            document.getElementById(
                "orders-table"
            );



        renderTable(


            table,


            [

                {
                    key:"id",
                    label:"Order ID"
                },


                {
                    key:"channel_source",
                    label:"Channel"
                },


                {
                    key:"channel_ref_id",
                    label:"Reference"
                },


                {
                    key:"customer_name",
                    label:"Customer"
                },


                {
                    key:"order_status",
                    label:"Status"
                },


                {
                    key:"created_at",
                    label:"Created At"
                }


            ],


            data


        );



    }


    catch(error){


        orders.innerHTML = `


            <h3>

                Error

            </h3>


            <p>

                ${error.message}

            </p>


        `;


    }


}



loadOrders();