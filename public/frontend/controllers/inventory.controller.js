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


import { renderStatCard }
from "../components/stat-card.js";



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



        /*
        |
        | Prepare inventory presentation data
        |
        */


        const inventoryData =
            data.map(product => {


                return {


                    ...product,


                    status:


                        product.stock_qty <= product.low_threshold


                        ?


                        `
                        <span class="stock-status stock-low">

                            Low Stock

                        </span>
                        `


                        :


                        `
                        <span class="stock-status stock-ok">

                            Healthy

                        </span>
                        `


                };


            });




        /*
        |
        | Inventory KPI calculations
        |
        */


        const totalProducts =
            data.length;



        const totalUnits =
            data.reduce(

                (sum, product) => {

                    return sum + product.stock_qty;

                },

                0

            );



        const lowStockItems =
            data.filter(

                product =>

                    product.stock_qty <= product.low_threshold

            ).length;





        /*
        |
        | Page structure
        |
        */


        inventory.innerHTML = `


<h2>
Inventory Management
</h2>



<p class="muted">

Monitor product availability and stock levels

</p>




<div
id="inventory-stats"
class="stats-grid">

</div>




<div class="section-card">


<div id="inventory-table">


</div>


</div>


        `;




        /*
        |
        | Render KPI cards
        |
        */


        const stats =
            document.getElementById(
                "inventory-stats"
            );



        renderStatCard(

            stats,

            "Total Products",

            totalProducts

        );



        renderStatCard(

            stats,

            "Total Units",

            totalUnits

        );



        renderStatCard(

            stats,

            "Low Stock Items",

            lowStockItems

        );





        /*
        |
        | Render inventory table
        |
        */


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
                },


                {
                    key:"status",
                    label:"Status"
                }


            ],


            inventoryData


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