export function renderChartPlaceholder(
    container,
    title,
    data
) {

    container.innerHTML += `

        <h2>

            ${title}

        </h2>

        <pre>

${JSON.stringify(
    data,
    null,
    2
)}

        </pre>

    `;

}