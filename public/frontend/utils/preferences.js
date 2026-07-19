const THEME_KEY =
    "oms_theme";


const CURRENCY_KEY =
    "oms_currency";


const DATE_FORMAT_KEY =
    "oms_date_format";


const NOTIFICATIONS_KEY =
    "oms_notifications";




export function saveTheme(theme){

    localStorage.setItem(
        THEME_KEY,
        theme
    );

}



export function getTheme(){

    return localStorage.getItem(
        THEME_KEY
    ) || "light";

}




export function saveCurrency(currency){

    localStorage.setItem(
        CURRENCY_KEY,
        currency
    );

}



export function getCurrency(){

    return localStorage.getItem(
        CURRENCY_KEY
    ) || "LSL";

}





export function saveDateFormat(format){

    localStorage.setItem(
        DATE_FORMAT_KEY,
        format
    );

}



export function getDateFormat(){

    return localStorage.getItem(
        DATE_FORMAT_KEY
    ) || "YYYY-MM-DD";

}





export function saveNotifications(settings){

    localStorage.setItem(

        NOTIFICATIONS_KEY,

        JSON.stringify(settings)

    );

}



export function getNotifications(){

    return JSON.parse(

        localStorage.getItem(
            NOTIFICATIONS_KEY
        )

    ) || {

        lowStock:true,

        orders:true

    };

}





export function applyTheme(){


    const theme =
        getTheme();


    document.body.classList.toggle(

        "dark",

        theme === "dark"

    );


}