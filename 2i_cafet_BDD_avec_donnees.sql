
CREATE TABLE users (
    email VARCHAR(320) PRIMARY KEY,
    first_name VARCHAR(40) NOT NULL,
    surname VARCHAR(40) NOT NULL,
    password VARCHAR(30) NOT NULL,
    admin BOOL NOT NULL DEFAULT 0,
    banned BOOL NOT NULL DEFAULT 0,
    waster_score SMALLINT NOT NULL DEFAULT 0
);

CREATE TABLE menus (
    id_menu INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    price DECIMAL(5, 2) UNSIGNED
);

CREATE TABLE events (
    date_event DATE PRIMARY KEY,
    name VARCHAR(40) NOT NULL DEFAULT "Nouvel événement",
    cancelable_orders BOOL NOT NULL DEFAULT 1,
    menus_url VARCHAR(250) DEFAULT NULL
);

CREATE TABLE menus_events (
    date_event DATE NOT NULL,
    id_menu INT NOT NULL,
    
    FOREIGN KEY (date_event) REFERENCES events(date_event),
    FOREIGN KEY (id_menu) REFERENCES menus(id_menu),
    
    PRIMARY KEY (date_event, id_menu)
);

CREATE TABLE products (
    id_product INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT "autre",
    quantity SMALLINT UNSIGNED,
    price DECIMAL(5, 2) UNSIGNED NOT NULL
);

CREATE TABLE products_content (
    id_product INT NOT NULL,
    id_ingredient INT NOT NULL,
    quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,

    FOREIGN KEY (id_product) REFERENCES products(id_product),
    FOREIGN KEY (id_ingredient) REFERENCES products(id_product),

    PRIMARY KEY (id_product, id_ingredient)
);

CREATE TABLE menus_content (
    id_menu INT NOT NULL,
    id_product INT NOT NULL,
    quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    
    FOREIGN KEY (id_menu) REFERENCES menus(id_menu),
    FOREIGN KEY (id_product) REFERENCES products(id_product),
    
    PRIMARY KEY (id_menu, id_product)
);

CREATE TABLE orders (
    id_order INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320) NOT NULL,
    date_event DATE NOT NULL,
    total SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    status VARCHAR(30) NOT NULL DEFAULT "en cours...",
    
    FOREIGN KEY (email) REFERENCES users(email),
    FOREIGN KEY (date_event) REFERENCES events(date_event)
);

CREATE TABLE orders_content (
    id_order INT NOT NULL,
    id_product INT NOT NULL,
    quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    
    FOREIGN KEY (id_order) REFERENCES orders(id_order),
    FOREIGN KEY (id_product) REFERENCES products(id_product),
    
    PRIMARY KEY (id_order, id_product)
);

-- Ajout de données d'exemples

-- Les requêtes imbriquées sont obligatoires ici pour récupérer certains identifiants, mais nous n'en aurons pas besoin par la suite

-- Ajout d'un utilisateur
INSERT INTO users(email, first_name, surname, password) VALUES ("quentin.vaniet@ig2i.centralelille.fr", "Quentin", "Vaniet", "1234");

-- Création d'un produit :
INSERT INTO products (name, type, price) VALUES ("Croque-monsieur", "plat", 1.5);

-- Création des ingrédients pour le croque-monsieur
INSERT INTO products (name, type, quantity, price) VALUES ("Jambon", "plat", 15, 0.5);

INSERT INTO products (name, type, quantity, price) VALUES ("Tranche de pain de mie", "autre", 20, 0.2);

INSERT INTO products (name, type, quantity, price) VALUES ("Emmental", "autre", 50, 2.0);

-- Ajout de ces ingrédients dans la "recette" du croque-monsieur
-- sur le site, on pourra directement récupérer l'identifiant du croque-monsieur et de ses ingrédients, il n'y aura donc pas de requêtes imbriquées

INSERT INTO products_content (id_product, id_ingredient, quantity) VALUES 
    (
        (    -- Croque-monsieur
        SELECT id_product
        FROM products
        WHERE name = "Croque-monsieur"
        LIMIT 1
        ), 
        
        ( -- Jambon
        SELECT id_product
        FROM products
        WHERE name = "Jambon"
        LIMIT 1
        ),
        
        1 -- quantité (une tranche de jambon dans le croque-monsieur)
    );


INSERT INTO products_content (id_product, id_ingredient, quantity) VALUES 
    (
        (    -- Croque-monsieur
        SELECT id_product
        FROM products
        WHERE name = "Croque-monsieur"
        LIMIT 1
        ), 
        
        ( -- Tranche de pain de mie
        SELECT id_product
        FROM products
        WHERE name = "Tranche de pain de mie"
        LIMIT 1
        ),
        1
    );

INSERT INTO products_content (id_product, id_ingredient, quantity) VALUES 
    (
        (    -- Croque-monsieur
        SELECT id_product
        FROM products
        WHERE name = "Croque-monsieur"
        LIMIT 1
        ), 
        
        ( -- Emmental
        SELECT id_product
        FROM products
        WHERE name = "Emmental"
        LIMIT 1
        ),
        
        1
    );

-- Création d'un autre produit (hot-dog)
INSERT INTO products (name, type, price) VALUES ("Hot-dog", "plat", 1.5);

-- Création de ses ingrédients
INSERT INTO products (name, type, quantity, price) VALUES ("Pain hot-dog", "autre", 15, 0);     -- Certains produits ne seront jamais mis à la vente seuls, on peut donc leur mettre un prix de 0€

INSERT INTO products (name, type, quantity, price) VALUES ("Saucisse", "plat", 15, 1.0);

-- Ajout de ces ingrédients dans la "recette" du hot-dog
INSERT INTO products_content (id_product, id_ingredient, quantity) VALUES 
    (
        (    -- Hot-dog
        SELECT id_product
        FROM products
        WHERE name = "Hot-dog"
        LIMIT 1
        ), 
        
        ( -- Pain Hot-dog
        SELECT id_product
        FROM products
        WHERE name = "Pain hot-dog"
        LIMIT 1
        ),
        1
    );

INSERT INTO products_content (id_product, id_ingredient, quantity) VALUES 
    (
        (    -- Hot-dog
        SELECT id_product
        FROM products
        WHERE name = "Hot-dog"
        LIMIT 1
        ), 
        
        ( -- Saucisse
        SELECT id_product
        FROM products
        WHERE name = "Saucisse"
        LIMIT 1
        ),
        1
    );

-- Création d'un menu
INSERT INTO menus (name, price) VALUES ("Menu Croque-monsieur / Hot-dog", 3.5);

-- Ajout des produits au menu
INSERT INTO menus_content (id_menu, id_product, quantity) VALUES (
    (	-- Menu Croque-monsieur / Hot-dog 
    	SELECT id_menu
        FROM menus
        WHERE name = "Menu Croque-monsieur / Hot-dog"
        LIMIT 1
    ),
	(	-- Croque-monsieur
        SELECT id_product
    	FROM products
    	WHERE name = "Croque-monsieur"
    	LIMIT 1
    ),
    3
);

INSERT INTO menus_content (id_menu, id_product, quantity) VALUES (
    (	-- Menu Croque-monsieur / Hot-dog 
    	SELECT id_menu
        FROM menus
        WHERE name = "Menu Croque-monsieur / Hot-dog"
        LIMIT 1
    ),
	(	-- Croque-monsieur
        SELECT id_product
    	FROM products
    	WHERE name = "Hot-dog"
    	LIMIT 1
    ),
    2
);

-- Création d'un événement
INSERT INTO events (date_event, name) VALUES ("2024-01-08", "Événement du 8 janvier");


-- Ajout du menu Croque-monsieur / Hot-dog pour l'événement
INSERT INTO menus_events (date_event, id_menu) VALUES (
	(
        SELECT date_event
        FROM events
        WHERE name = "Événement du 8 janvier"
        LIMIT 1
    ),
    (
    	SELECT id_menu
        FROM menus
        WHERE name = "Menu Croque-monsieur / Hot-dog"
        LIMIT 1
    )
    
);

-- Création d'une commande
INSERT INTO orders (email, date_event, total) VALUES (
	"quentin.vaniet@ig2i.centralelille.fr",
    "2024-01-08",
    3.5 	-- sera calculé automatiquement plus tard
);

-- Ajout des produits choisis dans les menus proposés, (on imagine que c'est le client qui les a choisis, ces valeurs sont des exemples)
INSERT INTO orders_content (id_order, id_product, quantity) VALUES (1, 1, 3);