
function updateContent(event, infos){
    console.log("updateContent");
    var refEventsSelect = document.getElementById("date_event");
    var refMenusSelect = document.getElementById("menu");

    // var refContentSelect = document.getElementById();

    // console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["products"]);
    // console.log(Object.keys(infos[refEventsSelect.value]["menus"][refMenusSelect.value]["products"]).length);

    // Récupère et modifie le contenu disponible
    for (key in infos[refEventsSelect.value]["menus"][refMenusSelect.value]){
        console.log(infos[refEventsSelect.value]["menus"][refMenusSelect.value][key]);
    }
    
}

function updateMenus(event, infos){
    console.log("updateMenus");
    var refEventsSelect = document.getElementById("date_event");
    var refMenusSelect = document.getElementById("menu");

    var new_menu;

    console.log(infos);

    refMenusSelect.innerHTML = "";          // On retire l'ancien contenu du selecteur

    console.log(refMenusSelect.value);      // On affiche l'identifiant du menu actuellement selectionné

    // Pour tous les menus de l'événement
    for (key in infos[refEventsSelect.value]["menus"]){
        console.log(infos[refEventsSelect.value]["menus"][key]);


        // Ajout des menus dans la liste de selection
        new_menu = document.createElement("option");
        new_menu.value = infos[refEventsSelect.value]["menus"][key];
        new_menu.innerHTML = infos[refEventsSelect.value]["menus"][key]["name"];

        refMenusSelect.appendChild(new_menu);

    }

    console.log(infos);    

    updateContent(event, infos);

}