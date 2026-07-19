export function renderSidebar(){


    const sidebar =
        document.getElementById(
            "sidebar"
        );


    const currentPage =
        window.location.pathname
        .split("/")
        .pop();



    const menuItems = [

        {
            name:"Dashboard",
            link:"dashboard.html"
        },

        {
            name:"Inventory",
            link:"inventory.html"
        },

        {
            name:"Orders",
            link:"orders.html"
        },

        {
            name:"Analytics",
            link:"analytics.html"
        },

        {
            name:"Settings",
            link:"settings.html"
        }

    ];



    sidebar.innerHTML = `


        <nav class="sidebar-nav">


            <ul>


                ${
                    menuItems.map(item => `


                        <li class="
                            ${
                                currentPage === item.link
                                ?
                                "active"
                                :
                                ""
                            }
                        ">


                            <a href="${item.link}">


                                ${item.name}


                            </a>


                        </li>


                    `).join("")
                }


            </ul>


        </nav>


    `;


}