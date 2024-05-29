
<script src="js/script.js"></script>

<?php
    // Récupère toutes les informations sur les événements, leurs menus, leurs produits sous la forme d'un tableau associatif
    function getInfos(){

        $infos = array();

        $events = recupererEvenements();

        // tprint($events);

        for ($e = 0; $e < count($events); $e++){

            // tprint($events[$e]);
            
            $infos[$events[$e]["date_event"]] = array();

            $infos[$events[$e]["date_event"]]["name"] = $events[$e]["name"];
            $infos[$events[$e]["date_event"]]["cancelable_orders"] = $events[$e]["cancelable_orders"];
            $infos[$events[$e]["date_event"]]["menus_url"] = $events[$e]["menus_url"];

            $infos[$events[$e]["date_event"]]["menus"] = array();



            $menus = recupererMenusEvenements($events[$e]["date_event"]);
            
            for ($m = 0; $m < count($menus); $m++){

                // tprint($menus[$m]);

                $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]] = array();

                $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["name"] = $menus[$m]["name"];
                $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["price"] = $menus[$m]["price"];


                $types = array("plat", "boisson", "dessert", "autre");          // On stocke chaque type de produits

                for ($i = 0; $i < count($types); $i++){

                    $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$types[$i]] = array();

                    $products = recupererMenuContent($menus[$m]["id_menu"], $types[$i]);

                    for ($p = 0; $p < count($products); $p++){

                        //$infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$products[$p]["id_product"]] = array();

                        $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$types[$i]][$products[$p]["id_product"]]["name"] = $products[$p]["name"];
                        $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$types[$i]][$products[$p]["id_product"]]["type"] = $products[$p]["type"];
                        $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$types[$i]][$products[$p]["id_product"]]["quantity"] = $products[$p]["quantity"];
                        $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$types[$i]][$products[$p]["id_product"]]["price"] = $products[$p]["price"];

                    }
                }


            }

        }

        return $infos;

    }

    
    //if (valider("connecte", "SESSION")){
        $infos = getInfos();
        
        // tprint($infos);
        $selected_values = array();     // Tableau qui contient les valeurs sélectionnées

        if (!empty($infos)){            // Si le tableau contient des événements
            $selected_values["date_event"] = array_key_first($infos);       // On ajoute par défaut le 1er événement de la liste

            if (!empty($m = $infos[$selected_values["date_event"]]["menus"])){      // Si l'événement contient des menus
                // tprint($m);
                $selected_values["menu"] = array_key_first($m);   // On ajoute par défaut le 1er menu de la liste

                if (!empty($p = $m[$selected_values["menu"]]["plat"])){
                    $selected_values["content"] = array_key_first($p);
                }

                if (!empty($p = $m[$selected_values["menu"]]["boisson"])){
                    $selected_values["drink"] = array_key_first($p);
                }

                if (!empty($p = $m[$selected_values["menu"]]["dessert"])){
                    $selected_values["dessert"] = array_key_first($p);
                }

            }
        }

        // tprint($selected_values);
        $products = recupererMenuContent(1);

        // tprint($products);


                    
?>
    <form action="controleur.php">
        <div>
        <label for="date_event">Date :</label>

        <?php
            $dates = recupererEvenements();

            // tprint($dates);

            mkSelect("date_event", $dates, "date_event", "date_event", $selected_values["date_event"],$champLabel2=false, "id=\"date_event\" onchange='updateMenus(" . json_encode($infos) . ")'\"");
        
        ?>
        </div>

        <hr>

        <div>
            <label for="menu">Menu :</label>

            <?php
            $menus = recupererMenusEvenements($selected_values["date_event"]);
            // tprint($menus);
            ?>

            <?php
            mkSelect("id_menu", $menus, "id_menu", "name", $selected_values["menu"], $champLabel2=false, "id=\"menu\" onchange='updateContent(" . json_encode($infos) . ")'\"");
            ?>

        </div>

        <hr>
        
        <div>
            <label for="content">Contenu :</label>
            <?php
            // $menu_content = recupererMenuContent();
            
            $content = recupererMenuContent($selected_values["menu"], "plat");
            mkSelect("id_product", $content, "id_product", "name", $selected_values["content"], "quantity", "id=\"content\"");
            // tprint($menu_content);
            ?>
        </div>

        <hr>

        <div>
            <label for="drink">Boisson :</label>
            <?php
            $drink = recupererMenuContent($selected_values["menu"], "boisson");
            mkSelect("id_product", $drink, "id_product", "name", $selected_values["content"], "quantity", "id=\"drink\"");
            ?>
        </div>

        <hr>
        
        <div>
            <label for="dessert">Dessert</label>
            <?php
            $dessert = recupererMenuContent($selected_values["menu"], "dessert");
            mkSelect("id_product", $dessert, "id_product", "name", $selected_values["content"], "quantity", "id=\"dessert\"");
            ?>
        </div>
        
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <button type="submit" name="action" value="order">Finaliser la commande</button>
    
    </form>

<?php
    
    //}

?>