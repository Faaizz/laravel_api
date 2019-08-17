# Tables

## settings
**id**  BIGINT UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY  
**content** JSON    NOT NULL

##  products
**id**  BIGINT UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY  
**name**    STRING(100) NOT NULL  
**brand**   STRING(50)  NOT NULL  
**description** LONGTEXT    NOT NULL  
**section** STRING(100) NOT NULL  
**sub_section** STRING(50)  NOT NULL  
**category** STRING(50)  NOT NULL  
**price**   DOUBLE(12,2) NOT NULL  
**material**    STRING(50)  NOT NULL  
**images**  JSON NOT NULL  
**options** JSON NOT NULL  

## orders
**id**  BIGINT  UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY  
**product_id**  BIGINT UNSIGNED (FOREIGN KEY references **products(_id_)**)  NOT NULL  
**product_color**  STRING(100) NOT NULL  
**product_size**  STRING(50) NOT NULL  
**product_quantity**  INT NOT NULL  
**customer_id**  BIGINT UNSIGNED (FOREIGN KEY references **customers(_id_)**)  NOT NULL  
**staff_id**  BIGINT UNSIGNED  
**status**  ENUM("pending", "failed", "delivered")  NOT NULL  DEFAULT "pending"  
**est_del_date**  DATETIME  
**failure_cause**  STRING(200)  NOT NULL DEFAULT ""
**failure_date**  DATETIME
**delivery_date**  DATETIME

## customers  
**id**  BIGINT  UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY  
**first_name**  STRING(50) NOT NULL  
**last_name**  STRING(50) NOT NULL  
**email**  STRING(100) NOT NULL  
**password**    LONGTEXT  NOT NULL  
**address**  LONGTEXT  NOT NULL  
**gender**  ENUM("male", "female") NOT NULL  
**phone_numbers**  JSON  NOT NULL  
**activation_status**  ENUM("yes", "no") NOT NULL  DEFAULT "no"  
**newsletters**  ENUM("yes", "no") NOT NULL  DEFAULT "yes"   
**shopping_cart**  JSON  
**liked_items**  JSON  
**remember_token**   LONGTEXT         

## staffs  
**id**  BIGINT  UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY  
**first_name**  STRING(50) NOT NULL  
**last_name**  STRING(50) NOT NULL  
**email**  STRING(100) NOT NULL  
**password**      LONGTEXT  NOT NULL     
**address**  LONGTEXT  NOT NULL  
**gender**  ENUM("male", "female") NOT NULL  
**phone_numbers**  JSON  NOT NULL   
**privilege_level**  ENUM("staff", "admin") NOT NULL DEFAULT "staff"  


