export function renderSidebar() {

    const sidebar =
        document.getElementById(
            "sidebar"
        );

    sidebar.innerHTML = `

        <ul
            style="list-style:none;padding:0;">

            <li>

                <a href="dashboard.html">

                    Dashboard

                </a>

            </li>

            <br>

            <li>

                <a href="inventory.html">

                    Inventory

                </a>

            </li>

            <br>

            <li>

                <a href="orders.html">

                    Orders

                </a>

            </li>

            <br>

            <li>

                <a href="analytics.html">

                    Analytics

                </a>

            </li>

        </ul>

    `;

}