<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");

function verifUserBdd($login,$passe){
    // Vérifie l'identité d'un utilisateur 
    // dont les identifiants sont passes en paramètre
    // renvoie faux si user inconnu
    // renvoie l'id de l'utilisateur si succès

    $SQL="SELECT email FROM users WHERE email='$login' AND password='$passe'";

    return SQLGetChamp($SQL);
    // si on avait besoin de plus d'un champ
    // on aurait du utiliser SQLSelect
}

function isAdmin($email){
    // vérifie si l'utilisateur est un administrateur
    $SQL ="SELECT admin FROM users WHERE email='$email'";
    return SQLGetChamp($SQL); 
}

// Connexion :
function connecterUtilisateur($email, $password){
	$SQL="SELECT email, first_name, surname, admin, waster_score, FROM users WHERE email = '$email' AND password = '$password'AND banned = 0;";
	return SQLGetChamp($SQL);
}

function getInfoUser($email)
{
    $SQL="SELECT first_name, surname, waster_score, banned FROM users WHERE email='$email'";
    return parcoursRs(SQLSelect($SQL));
}

// Créer un compte :

function verifierUtilisateur($login, $passe){
	$SQL="SELECT first_name, surname FROM users WHERE email = '$email';";
	return SQLGetChamp($SQL);

}


function creerUtilisateur($email, $first_name, $surname, $password){
	$SQL="INSERT INTO users(email, first_name,surname, password) VALUES ('$email', '$first_name', '$surname' ,'$password');";
	return SQLInsert($SQL);
}

// Gestion de menu
function supprimerMenu($id_menu){ 
	$SQL = "DELETE * FROM menus WHERE id_menu = '$id_menu'";
	return SQLDelete($SQL);
}

function ajouterMenu($name, $price){
	$SQL = "INSERT INTO menus(name, price) VALUES('$name', '$price')";
	return SQLInsert($SQL);
}

function ajouterContenuMenu($id_menu, $id_product, $quantity){
	$SQL = "INSERT INTO menus_content(id_menu, id_product, quantity) VALUES('$id_menu', '$id_product', '$quantity')";
	return SQLInsert($SQL);
}

// Commander :
function recupererPrixMenu($id_menu){
	$SQL="SELECT price FROM menus WHERE id_menu = '$id_menu';";
	return SQLGetChamp($SQL);
}

function ajouterCommande($email, $date, $total, $status){
	$SQL="INSERT INTO orders (email, date_event, total, status) VALUES('$email', '$date', '$total' , '$status');";
	return SQLInsert($SQL);
}

function commanderProduit($id_order, $id_product, $quantity){
	$SQL = "INSERT INTO orders_content(id_order, id_produit, quantity) VALUES('$id_order', '$id_product', '$quantity');";
	return SQLInsert($SQL);
}

// Stock :
function recupererProduits(){
    $SQL = "SELECT id_product, name, type, quantity FROM products WHERE type = 'plat';";
    return parcoursRs(SQLSelect($SQL));
}


function modifierStock($id_product){
	$SQL = "UPDATE products SET quantity = quantity + “quantity” WHERE id_product = '$id_product';";
	return SQLUpdate($SQL);
}


// Users : 
function modifierUser($email, $admin, $banned){
	$SQL = "UPDATE users SET admin = '$admin', banned = '$banned' WHERE email  = '$email;";
	return SQLUpdate($SQL);
}

// Caisse :
function validerCommande($id_order){
	$SQL = "UPDATE orders set status = validée WHERE id_order = '$id_order';";
	return SQLUpdate($SQL);
}

function recupererCommandeNonValide(){
	$SQL = "SELECT o.id_order, u.first_name, u.surname, o.total FROM orders as o JOIN users as u ON u.email = o.email WHERE o.status !=validée";
	return parcoursRS(SQLSelect($SQL));
}
function recupererContenuCommande($id_order){
	$SQL = "SELECT p.name FROM product as p JOIN orders_content as o ON o.id_product = p.id_product WHERE id_order ='$id_order' ";
	return parcoursRS(SQLSelect($SQL));
}

function malusUtilisateur($email){
	$SQL = "UPDATE users set waster_score = waster_score + 1 WHERE email ='$email'";
	return SQLUpdate($SQL);
}

// Panier :
function supprimerCommande($id_order){
	$SQL = "DELETE * FROM orders_content WHERE id_order = '$id_order';
	DELETE * FROM orders WHERE id_order = '$id_order;";
	return SQLDelete($SQL);
}


// Gestion de event
function supprimerEvenement($date_event){ 
    $SQL = "DELETE FROM menus_events WHERE date_event = '$date_event'; DELETE FROM events WHERE date_event = '$date_event'; ";
    return SQLDelete($SQL);
}

function ajouterEvenement($name, $date_event, $url){
    $SQL = "INSERT INTO events(date_event, name, menus_url) VALUES('$date_event', '$name', '$url')";
    return SQLInsert($SQL);
}

function clearEvenement($date_event){
    $SQL = "DELETE FROM menus_events WHERE date_event = '$date_event'; ";
    return SQLDelete($SQL);
}
function ajouterMenuEvenement($id_menu, $date_event){
    $SQL = "INSERT INTO menus_events(date_event, id_menu) VALUES('$date_event', '$id_menu')";
    return SQLInsert($SQL);
}

function modifierEvenement($date_event, $name, $url){
    $SQL = "UPDATE events set name = '$name', menus_url='$url' WHERE date_event ='$date_event'";
    return SQLUpdate($SQL);
}


// Utile :
function recupererEvenements(){
	$SQL = "SELECT * FROM events";
	return parcoursRs(SQLSelect($SQL));
}

function recupererMenus(){
	$SQL = "SELECT * FROM menus";
	return parcoursRs(SQLSelect($SQL));
}

function recupererMenusEvenements($date_event){
	$SQL = "SELECT * FROM menus_events JOIN menus ON menus_events.id_menu = menus.id_menu WHERE date_event = '$date_event'";
	return parcoursRs(SQLSelect($SQL));
}

function recupererMenuContent($id_menu, $type=""){
	if ($type != ""){
		$sup = "AND type = '$type'";
	} else {
		$sup = "";
	}
	$SQL = "SELECT * FROM products JOIN menus_content ON products.id_product = menus_content.id_product WHERE menus_content.id_menu = '$id_menu' $sup;";
	// $SQL = "SELECT * FROM products WHERE id_product IN (SELECT id_product FROM menus_content WHERE id_menu = '$id_menu') $sup;";
	return parcoursRs(SQLSelect($SQL));
}


function recupererIngredient(){
    $SQL = "SELECT id_product, name, type, quantity FROM products WHERE quantity IS NOT NULL;";
    return parcoursRs(SQLSelect($SQL));
}

function supprimerIngredient($id_product){
    $SQL = "DELETE FROM products_content WHERE id_ingredient = '$id_product'; DELETE FROM products WHERE id_product = '$id_product'; ";
    return SQLDelete($SQL);
}

function ajouterProduit($name, $price){
    $SQL="INSERT INTO products(name, quantity, price, type) VALUES('$name', '0', '$price', 'plat');";
    return SQLInsert($SQL);
}

function supprimerProduit($id_product){
    $SQL = "DELETE FROM products_content WHERE id_product = '$id_product'; DELETE FROM products WHERE id_product = '$id_product'; ";
    return SQLDelete($SQL);
}


function recupererContenuProduit($id_product){
    $SQL = "SELECT products.id_product, products.name, products.type, products.quantity FROM products JOIN products_content ON products.id_product = products_content.id_ingredient WHERE products_content.id_product = '$id_product'";
    return parcoursRs(SQLSelect($SQL));
}

function isMenuInEvenement($date_event, $id_menu){	// Permet de savoir si un menu est présent dans un événement 
	$SQL = "SELECT id_menu FROM menus_events WHERE id_menu = '$id_menu' AND date_event = '$date_event';";
	return (SQLGetChamp($SQL) !== false);
}

function evenementExiste($date_event){
	$SQL = "SELECT date_event FROM events WHERE date_event = '$date_event';";
	return (SQLGetChamp($SQL) !== false);
}

/*
function produitExiste($id_produit, $type = ""){

	$sup = "";

	if ($type != ""){
		$sup = " AND type = '$type'";
	}

	$SQL = "SELECT * FROM products WHERE id_product = '$id_produit'$sup;";
}
*/

function isProduitInMenu($id_menu, $id_content, $type = ""){
	if ($id_content === false){
		return true;
	}
	if ($type != ""){
		$SQL = "SELECT products.id_product FROM menus_content JOIN products ON menus_content.id_product = products.id_product WHERE menus_content.id_menu = '$id_menu' AND menus_content.id_product = '$id_content' AND products.type = '$type';";
	} else {
		$SQL = "SELECT id_product FROM menus_content WHERE id_menu = '$id_menu' AND id_product = '$id_content';";
	}

	return (SQLGetChamp($SQL) !== false);

}


function isEnStock($id_ingredient, $quantite){

	$SQL = "SELECT quantity FROM products WHERE id_product = '$id_ingredient'";
	$res = SQLGetChamp($SQL);

	if ($res !== false){
		return ($res >= $quantite);
	}

	return false;
}


function recupererIngredientsProduit($id_produit){
	$SQL = "SELECT products_content.id_ingredient, products_content.quantity, products.quantity AS stock FROM products_content JOIN products ON products_content.id_ingredient = products.id_product WHERE products_content.id_product = '$id_produit';";

	return parcoursRs(SQLSelect($SQL));
}

function recupererProduit($id_produit){
	$SQL = "SELECT * FROM products WHERE id_product = '$id_produit';";
	return parcoursRs(SQLSelect($SQL))[0];
}

function recupererStockProduitMenu($id_menu, $id_produit){
	$SQL = "SELECT quantity FROM menus_content WHERE id_menu = '$id_menu' AND id_product = '$id_produit';";
	return SQLGetChamp($SQL);
}

function verifierStockIngredientsProduit($id_produit, $id_menu = ""){

	if ($id_produit === false){
		return true;
	}

	$i = recupererIngredientsProduit($id_produit);

	tprint($i);

	if (!empty($i)){
		for ($k = 0; $k < count($i); $k++){
			if ($i[$k]["quantity"] > $i[$k]["stock"]){
				return false;
			}
		}
	} else {	// Le produit n'est pas composé d'ingrédients, on regarde directement son stock
		tprint("produit :");
		$p = recupererProduit($id_produit);

		tprint($p);
		return $p["quantity"] >= recupererStockProduitMenu($id_menu, $id_produit);
	}

	return true;

}


function recupererContenuNonProduit($id_product){
    $SQL = "SELECT products.id_product, products.name, products.type, products.quantity FROM products JOIN products_content ON products.id_product = products_content.id_ingredient WHERE products_content.id_product != '$id_product'";
    return parcoursRs(SQLSelect($SQL));
}
function ajouterIngredientProduit($id_product, $id_ingredient, $quantity){
    $SQL = "INSERT INTO `products_content`(`id_product`, `id_ingredient`, `quantity`) VALUES ('$id_product','$id_ingredient','$quantity')";
    return SQLInsert($SQL);
}
function supprimerIngredientProduit($id_product, $id_ingredient){
    $SQL = "DELETE FROM products_content WHERE id_ingredient = '$id_product' AND id_product = '$id_product';";
    return SQLDelete($SQL);
}

function recupererQuantité($id_product){
	$SQL = "SELECT quantity FROM products WHERE id_product =  '$id_product'";
    return SQLGetChamp($SQL);

}
?>
