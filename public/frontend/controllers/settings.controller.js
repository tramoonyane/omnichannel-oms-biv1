import {
    renderNavbar
}
from "../components/navbar.js";


import {
    renderSidebar
}
from "../components/sidebar.js";


import {

    saveTheme,

    getTheme,

    applyTheme,

    saveCurrency,

    getCurrency,

    saveDateFormat,

    getDateFormat,

    saveNotifications,

    getNotifications

}
from "../utils/preferences.js";



renderNavbar();

renderSidebar();



applyTheme();



const light =
document.getElementById(
    "lightTheme"
);


const dark =
document.getElementById(
    "darkTheme"
);



const current =
getTheme();



if(current === "dark"){

    dark.checked = true;

}

else{

    light.checked = true;

}



light.addEventListener(
    "change",
    ()=>{

        saveTheme(
            "light"
        );

        applyTheme();

    }
);



dark.addEventListener(
    "change",
    ()=>{

        saveTheme(
            "dark"
        );

        applyTheme();

    }
);

const currency =
document.getElementById(
    "currency"
);


const dateFormat =
document.getElementById(
    "dateFormat"
);


const lowStock =
document.getElementById(
    "lowStock"
);


const orderAlerts =
document.getElementById(
    "orderAlerts"
);



currency.value =
getCurrency();



dateFormat.value =
getDateFormat();



const notifications =
getNotifications();



lowStock.checked =
notifications.lowStock;



orderAlerts.checked =
notifications.orders;




currency.addEventListener(
"change",
()=>{

saveCurrency(
    currency.value
);

});




dateFormat.addEventListener(
"change",
()=>{

saveDateFormat(
    dateFormat.value
);

});





function saveNotificationSettings(){

saveNotifications({

lowStock:
lowStock.checked,

orders:
orderAlerts.checked

});


}




lowStock.addEventListener(
"change",
saveNotificationSettings
);



orderAlerts.addEventListener(
"change",
saveNotificationSettings
);