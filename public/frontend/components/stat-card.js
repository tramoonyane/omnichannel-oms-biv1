export function renderStatCard(
    container,
    title,
    value
) {

    container.innerHTML += `

        <div
            style="
                border:1px solid #ddd;
                padding:20px;
                margin:10px;
                border-radius:8px;
                min-width:180px;
            "
        >

            <h4>
                ${title}
            </h4>

            <h2>
                ${value}
            </h2>

        </div>

    `;

}