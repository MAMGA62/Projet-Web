
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

                $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["products"] = array();


                $products = recupererMenuContent($menus[$m]["id_menu"]);

                for ($p = 0; $p < count($products); $p++){

                    //$infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]][$products[$p]["id_product"]] = array();

                    $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["products"][$products[$p]["id_product"]]["name"] = $products[$p]["name"];
                    $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["products"][$products[$p]["id_product"]]["type"] = $products[$p]["type"];
                    $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["products"][$products[$p]["id_product"]]["quantity"] = $products[$p]["quantity"];
                    $infos[$events[$e]["date_event"]]["menus"][$menus[$m]["id_menu"]]["products"][$products[$p]["id_product"]]["price"] = $products[$p]["price"];

                }

            }

        }

        return $infos;

    }

    
    //if (valider("connecte", "SESSION")){
        $infos = getInfos();
        $products = recupererMenuContent(1);

        // tprint($products);

        $menus = recupererMenus();


                    
?>

        <label for="date_event">Date :</label>

        <?php
            $dates = recupererEvenements();

            // tprint($dates);

            mkSelect("date_event", $dates, "date_event", "date_event", $selected="",$champLabel2=false, "id=\"date_event\" onchange='updateMenus(event, " . json_encode($infos) . ")'\"");
        
        ?>

        <hr>

        <div>
            <label>Menu :</label>

            <?php
            // $menus = recupererMenusEvenements($date_event);
            // tprint($menus);
            ?>

            <?php
            mkSelect("id_menu", $menus, "id_menu", "name", $selected="",$champLabel2=false, "id=\"menu\" onchange=\"updateProducts(event)\"");
            ?>

        </div>

        <hr>
        
        <div>
            <label>Contenu :</label>
            <?php
            // $menu_content = recupererMenuContent();
            $content = recupererMenuContent(, "plat");
            mkSelect("id_menu", $menus, "id_menu", "name", $selected="",$champLabel2=false, "id=\"menu\" onchange=\"updateProducts(event)\"");
            // tprint($menu_content);
            ?>
        </div>

        <hr>

        <div>
            <label>Boisson :</label>
        </div>

        <hr>
        
        <div>
            <label>Dessert</label>
        </div>

<?php
    
    //}

?>