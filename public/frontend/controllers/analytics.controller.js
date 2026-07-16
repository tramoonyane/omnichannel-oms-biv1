import { requireAuth }
from "../utils/auth.js";

import { renderNavbar }
from "../components/navbar.js";

import { renderSidebar }
from "../components/sidebar.js";

import { renderStatCard }
from "../components/stat-card.js";

import { renderTable }
from "../components/table.js";

import { renderChartPlaceholder }
from "../components/chart-placeholder.js";

import {

    getSalesOverview,

    getDailySales,

    getTopProducts,

    getInventoryOverview,

    getLowStock,

    getHighStock

}
from "../services/analytics.service.js";


requireAuth();

renderNavbar();

renderSidebar();


const stats =
    document.getElementById(
        "stats"
    );

const dailySales =
    document.getElementById(
        "daily-sales"
    );

const topProducts =
    document.getElementById(
        "top-products"
    );

const highStock =
    document.getElementById(
        "high-stock"
    );

const lowStock =
    document.getElementById(
        "low-stock"
    );


async function loadAnalytics() {

    try {

        const [

            sales,

            daily,

            products,

            inventory,

            low,

            high

        ] = await Promise.all([

            getSalesOverview(),

            getDailySales(),

            getTopProducts(),

            getInventoryOverview(),

            getLowStock(),

            getHighStock()

        ]);


        renderStatCard(

            stats,

            "Orders",

            sales.total_orders

        );


        renderStatCard(

            stats,

            "Revenue",

            `M${sales.total_revenue}`

        );


        renderStatCard(

            stats,

            "Products",

            inventory.total_products

        );


        renderStatCard(

            stats,

            "Stock Value",

            `M${inventory.total_stock_value}`

        );


        renderChartPlaceholder(

            dailySales,

            "Daily Sales",

            daily

        );


        renderTable(

            topProducts,

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

            products

        );


        renderTable(

            highStock,

            [

                {
                    key:"sku",
                    label:"SKU"
                },

                {
                    key:"title",
                    label:"Product"
                },

                {
                    key:"stock_qty",
                    label:"Quantity"
                }

            ],

            high

        );


        renderTable(

            lowStock,

            [

                {
                    key:"sku",
                    label:"SKU"
                },

                {
                    key:"title",
                    label:"Product"
                },

                {
                    key:"stock_qty",
                    label:"Quantity"
                }

            ],

            low

        );

    }

    catch(error) {

        console.error(error);

    }

}


loadAnalytics();