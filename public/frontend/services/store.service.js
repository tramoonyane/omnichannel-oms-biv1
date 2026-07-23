export function saveStore(data){


    localStorage.setItem(

        "oms_store",

        JSON.stringify(data)

    );


}



export function getStore(){


    return JSON.parse(

        localStorage.getItem(
            "oms_store"
        )

    );


}