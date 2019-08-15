# Tables

# settings
**id**  BIGINT  NOT NULL    AUTO_INCREMENT  PRIMARY KEY 
**content** JSON    NOT NULL

#  products
**id**  BIGINT  NOT NULL    AUTO_INCREMENT  PRIMARY KEY
**name**    STRING(100) NOT NULL
**brand**   STRING(50)  NOT NULL
**description** LONGTEXT    NOT NULL
**section** STRING(100) NOT NULL
**sub_section** STRING(50)  NOT NULL
**price**   DOUBLE(12,2) NOT NULL
**material**    STRING(50)  NOT NULL
**images**  JSON NOT NULL
**options** JSON NOT NULL
