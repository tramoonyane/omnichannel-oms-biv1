export function renderTable(
    container,
    columns,
    rows
) {


    let header = "";

    columns.forEach(column => {

        header += `

            <th>
                ${column.label}
            </th>

        `;

    });



    let body = "";


    rows.forEach(row => {


        body += "<tr>";


        columns.forEach(column => {


            body += `

                <td>
                    ${row[column.key] ?? ""}
                </td>

            `;


        });


        body += "</tr>";


    });



    container.innerHTML = `


<table class="data-table">


    <thead>

        <tr>

            ${header}

        </tr>

    </thead>



    <tbody>

        ${body}

    </tbody>


</table>


    `;


}