import { requireAuth }
from "../utils/auth.js";


import { renderNavbar }
from "../components/navbar.js";


import { renderSidebar }
from "../components/sidebar.js";


import { getInventory }
from "../services/inventory.service.js";


import {
    renderTable
}
from "../components/table.js";



requireAuth();


renderNavbar();


renderSidebar();



const inventory =
    document.getElementById(
        "inventory"
    );



async function loadInventory(){


    try {


        const data =
            await getInventory();



        inventory.innerHTML = `


            <h2>

                Inventory Management

            </h2>


            <p>

                Current product stock levels

            </p>


            <hr>


            <div id="inventory-table">

            </div>


        `;



        const table =
            document.getElementById(
                "inventory-table"
            );



        renderTable(


            table,


            [

                {
                    key:"id",
                    label:"ID"
                },


                {
                    key:"sku",
                    label:"SKU"
                },


                {
                    key:"title",
                    label:"Product"
                },


                {
                    key:"price",
                    label:"Price"
                },


                {
                    key:"stock_qty",
                    label:"Stock"
                },


                {
                    key:"low_threshold",
                    label:"Low Stock Limit"
                }


            ],


            data


        );


    }


    catch(error){


        inventory.innerHTML = `


            <h3>

                Error

            </h3>


            <p>

                ${error.message}

            </p>


        `;


    }


}



loadInventory();