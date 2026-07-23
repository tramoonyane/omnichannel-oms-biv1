import { requireAuth } from "../utils/auth.js";

import { renderNavbar } from "../components/navbar.js";

import { renderSidebar } from "../components/sidebar.js";

import { getOrders } from "../services/orders.service.js";

import { renderTable } from "../components/table.js";

import { renderStatCard } from "../components/stat-card.js";

import "../utils/theme.js";

requireAuth();

renderNavbar();

renderSidebar();

const orders = document.getElementById("orders");

async function loadOrders() {

    try {

        const data = await getOrders();

        /*
        |--------------------------------------------------------------------------
        | Prepare order presentation data
        |--------------------------------------------------------------------------
        */

        const ordersData = data.map(order => {

            return {

                ...order,

                status:

                    order.status === "pending"

                        ?

                        `
                        <span class="stock-status stock-warning">
                            Pending
                        </span>
                        `

                        :

                        order.status === "completed"

                            ?

                            `
                            <span class="stock-status stock-ok">
                                Completed
                            </span>
                            `

                            :

                            `
                            <span class="stock-status stock-low">
                                ${order.status}
                            </span>
                            `

            };

        });


        /*
        |--------------------------------------------------------------------------
        | KPI calculations
        |--------------------------------------------------------------------------
        */

        const totalOrders = data.length;

        const pendingOrders = data.filter(

            order => order.status === "pending"

        ).length;

        const completedOrders = data.filter(

            order => order.status === "completed"

        ).length;


        /*
        |--------------------------------------------------------------------------
        | Page layout
        |--------------------------------------------------------------------------
        */

        orders.innerHTML = `

            <h2>Orders Management</h2>

            <p class="muted">
                Order processing overview
            </p>

            <div
                id="orders-stats"
                class="stats-grid">
            </div>

            <div class="section-card">

                <div id="orders-table"></div>

            </div>

        `;


        /*
        |--------------------------------------------------------------------------
        | KPI Cards
        |--------------------------------------------------------------------------
        */

        const stats = document.getElementById("orders-stats");

        renderStatCard(
            stats,
            "Total Orders",
            totalOrders
        );

        renderStatCard(
            stats,
            "Pending Orders",
            pendingOrders
        );

        renderStatCard(
            stats,
            "Completed Orders",
            completedOrders
        );


        /*
        |--------------------------------------------------------------------------
        | Orders Table
        |--------------------------------------------------------------------------
        */

        const table = document.getElementById("orders-table");

        renderTable(

            table,

            [

                {
                    key: "id",
                    label: "Order ID"
                },

                {
                    key: "channel",
                    label: "Channel"
                },

                {
                    key: "reference",
                    label: "Reference"
                },

                {
                    key: "customer_name",
                    label: "Customer"
                },

                {
                    key: "status",
                    label: "Status"
                },

                {
                    key: "created_at",
                    label: "Created At"
                }

            ],

            ordersData

        );

    }

    catch (error) {

        orders.innerHTML = `

            <h3>Error</h3>

            <p>${error.message}</p>

        `;

    }

}

loadOrders();