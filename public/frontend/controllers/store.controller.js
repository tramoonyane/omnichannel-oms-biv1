import {
    renderNavbar
}
from "../components/navbar.js";


import {
    renderSidebar
}
from "../components/sidebar.js";


import {
    applyTheme
}
from "../utils/preferences.js";


import {
    saveStore,
    getStore
}
from "../services/store.service.js";



renderNavbar();

renderSidebar();

applyTheme();




function loadStore(){


    const store =
        getStore();



    if(!store){

        return;

    }




    document.getElementById(
        "storeName"
    ).value =
        store.name || "";



    document.getElementById(
        "description"
    ).value =
        store.description || "";



    document.getElementById(
        "businessEmail"
    ).value =
        store.email || "";



    document.getElementById(
        "phone"
    ).value =
        store.phone || "";



    document.getElementById(
        "website"
    ).value =
        store.website || "";



    document.getElementById(
        "address"
    ).value =
        store.address || "";


    document.getElementById(
    "logo"
).value =
    store.logo || "";


document.getElementById(
    "banner"
).value =
    store.banner || "";


document.getElementById(
    "primaryColor"
).value =
    store.primaryColor || "#2563eb";


    document.getElementById(
        "currency"
    ).value =
        store.currency || "LSL";


}




function collectStoreData(){


    return {


        name:

            document.getElementById(
                "storeName"
            ).value,



        description:

            document.getElementById(
                "description"
            ).value,



        email:

            document.getElementById(
                "businessEmail"
            ).value,



        phone:

            document.getElementById(
                "phone"
            ).value,



        website:

            document.getElementById(
                "website"
            ).value,



        address:

            document.getElementById(
                "address"
            ).value,

        logo:

document.getElementById(
    "logo"
).value,


banner:

document.getElementById(
    "banner"
).value,


primaryColor:

document.getElementById(
    "primaryColor"
).value,

        currency:

            document.getElementById(
                "currency"
            ).value


    };


}




loadStore();




const button =
document.getElementById(
    "saveStore"
);




button.addEventListener(
    "click",
    ()=>{


        const data =
            collectStoreData();



        saveStore(
            data
        );



        alert(
            "Store information saved"
        );


    }
);