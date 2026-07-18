export function renderLineChart(
    container,
    title,
    labels,
    values,
    datasetLabel
) {


    container.innerHTML = `

    
        <div class="chart-container">

            <canvas></canvas>

        </div>

    `;



    const canvas =
        container.querySelector(
            "canvas"
        );



    new Chart(

        canvas,

        {

            type:"line",


            data:{

                labels,


                datasets:[

                    {

                        label: datasetLabel,


                        data:values,


                        borderWidth:2,


                        tension:0.3

                    }

                ]

            },


            options:{

                responsive:true,


                maintainAspectRatio:false

            }


        }

    );


}

export function renderBarChart(

    container,

    title,

    labels,

    values,

    datasetLabel

) {


    container.innerHTML = `

    <div class="chart-container">

        <canvas></canvas>

    </div>

`;



    const canvas =
        container.querySelector(
            "canvas"
        );



    new Chart(

        canvas,

        {

            type:"bar",


            data:{


                labels,


                datasets:[

                    {

                        label:datasetLabel,


                        data:values,


                        borderWidth:1


                    }

                ]

            },


            options:{


                responsive:true,


                maintainAspectRatio:false


            }


        }

    );


}