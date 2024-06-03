
function updateTotal(infos){
    console.log("updateTotal");

    var refTotal = document.getElementById("total");
    var refTotalInput = document.getElementById("totalinput");

    var refEventsSelect = document.getElementById("date_event");
    var refMenusSelect = document.getElementById("menu");

    refTotal.innerHTML = infos[refEventsSelect.value]["menus"][refMenusSelect.value]["price"];
    refTotalInput.value = infos[refEventsSelect.value]["menus"][refMenusSelect.value]["price"];
}

function updateContent(infos){
    console.log("updateContent");
    var refEventsSelect = document.getElementById("date_event");
    var refMenusSelect = document.getElementById("menu");

    var refContentSelect = document.getElementById("content");
    var refDrinkSelect = document.getElementById("drink");
    var refDessertSelect = document.getElementById("dessert");

    var new_content;

    updateTotal(infos);

    // var refContentSelect = document.getElementById();

    // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["products"]);
    // console.log(Object.keys(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["products"]).length);

    // Récupère et modifie le contenu disponible
    // console.log(infos[refEventsSelect.value]["menus"]);
    // console.log("valeur");
    // console.log(refMenusSelect.value);

    refContentSelect.innerHTML = "";          // On retire l'ancien contenu du selecteur


    for (key in infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"]){
        // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"][key]);


        // Ajout des menus dans la liste de selection
        new_content = document.createElement("option");
        new_content.value = key;
        // console.log("test");
        // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"][key]["name"] + " (" + infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"][key]["quantity"] + ")");
        new_content.innerHTML = infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"][key]["name"] + " (" + infos[refEventsSelect.value]["menus"][refMenusSelect.value]["plat"][key]["quantity"] + ")";

        // console.log(new_content.innerHTML);
        
        refContentSelect.appendChild(new_content);


    }

    refDrinkSelect.innerHTML = "";

    for (key in infos[refEventsSelect.value]["menus"][refMenusSelect.value]["boisson"]){
        // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["boisson"][key]);


        // Ajout des menus dans la liste de selection
        new_content = document.createElement("option");
        new_content.value = key;
        new_content.innerHTML = infos[refEventsSelect.value]["menus"][refMenusSelect.value]["boisson"][key]["name"] + " (" + infos[refEventsSelect.value]["menus"][refMenusSelect.value]["boisson"][key]["quantity"] + ")";
        
        refDrinkSelect.appendChild(new_content);


    }

    refDessertSelect.innerHTML = "";

    for (key in infos[refEventsSelect.value]["menus"][refMenusSelect.value]["dessert"]){
        // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["dessert"][key]);


        // Ajout des menus dans la liste de selection
        new_content = document.createElement("option");
        new_content.value = key;
        new_content.innerHTML = infos[refEventsSelect.value]["menus"][refMenusSelect.value]["dessert"][key]["name"] + " (" + infos[refEventsSelect.value]["menus"][refMenusSelect.value]["dessert"][key]["quantity"] + ")";
        
        refDessertSelect.appendChild(new_content);


    }
    
}

function updateMenus(infos){
    console.log("updateMenus");
    var refEventsSelect = document.getElementById("date_event");
    var refMenusSelect = document.getElementById("menu");

    var new_menu;

    // console.log(infos);

    refMenusSelect.innerHTML = "";          // On retire l'ancien contenu du selecteur

    // console.log(refMenusSelect.value);      // On affiche l'identifiant du menu actuellement selectionné

    // Pour tous les menus de l'événement
    for (key in infos[refEventsSelect.value]["menus"]){
        // console.log(infos[refEventsSelect.value]["menus"][key]);


        // Ajout des menus dans la liste de selection
        new_menu = document.createElement("option");
        new_menu.value = key;
        new_menu.innerHTML = infos[refEventsSelect.value]["menus"][key]["name"];

        refMenusSelect.appendChild(new_menu);

    }

    // console.log(infos);    

    updateContent(infos);

}