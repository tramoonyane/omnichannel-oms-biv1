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

import { renderLineChart, renderBarChart }
from "../components/chart.js";

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

const dailyRevenue =
    document.getElementById(
        "daily-revenue"
    );


const dailyOrders =
    document.getElementById(
        "daily-orders"
    );

const topProducts =
    document.getElementById(
        "top-products"
    );

const topProductsChart =
    document.getElementById(
        "top-products-chart"
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


        renderLineChart(

    dailyRevenue,

    "Daily Revenue Trend",

    daily.map(
        item => item.date
    ),

    daily.map(
        item => Number(item.revenue)
    ),

    "Revenue"

);



renderLineChart(

    dailyOrders,

    "Daily Orders Trend",

    daily.map(
        item => item.date
    ),

    daily.map(
        item => item.orders
    ),

    "Orders"

);
        renderBarChart(

    topProductsChart,

    "Top Products by Revenue",


    products.map(
        item => item.title
    ),


    products.map(
        item => Number(item.revenue)
    ),


    "Revenue"

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