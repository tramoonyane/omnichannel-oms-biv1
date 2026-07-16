export function renderStatCard(
    container,
    title,
    value
){


    const card =
        document.createElement(
            "div"
        );


    card.className =
        "stat-card";


    card.innerHTML = `


        <div class="stat-title">

            ${title}

        </div>


        <div class="stat-value">

            ${value}

        </div>


    `;


    container.appendChild(
        card
    );


}