<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");



// Connexion :
function connecterUtilisateur($email, $password){
	$SQL="SELECT email, first_name, surname, admin, waster_score, FROM users WHERE email = '$email' AND password = '$password'AND banned = 0;";
	return SQLGetChamp($SQL);
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
	$SQL = "SELECT id_product, name, type, quantity FROM products;";
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
?>
