CREATE TABLE user(
    pk_id_user        INT             NOT NULL AUTO_INCREMENT,
    nm_user           VARCHAR(255),
    cd_password       VARCHAR(255),
    ds_email          VARCHAR(255),
    dt_born           DATE,
    nm_img            VARCHAR(255), 'Identifies which image is in the dirtiest scheme'
    cd_cep            VARCHAR(255),
    ds_country        VARCHAR(255),
    ds_state          VARCHAR(255),
    ds_city           VARCHAR(255),
    ds_address        VARCHAR(255),
    nr_address        INT,

    dt_creation       DATE,
    dt_update         DATE,

    PRIMARY KEY(pk_id_user)
);

INSERT INTO user 
VALUES(0, 'sus','suspass','suspass','2012-01-01','dsa','dasd','dsa','dasd','dsa','dasd',32,'2012-01-01','2012-01-01');

CREATE TABLE market(
    pk_id_market        INT             NOT NULL AUTO_INCREMENT,
    nm_market           VARCHAR(255),
    ds_email            VARCHAR(255),
    nm_img              VARCHAR(255), 'Identifies which image is in the dirtiest scheme'
    dt_market_creation  DATE,
    ds_market           VARCHAR(255),
    ie_status           VARCHAR(255), 'Active or Inactive'
    
    dt_creation         DATE,
    dt_update           DATE,

    PRIMARY KEY(pk_id_market)
);

INSERT INTO market 
VALUES(0, 'Frisia','nicolasprado0028@gmail.com','imgnicolasprado0028@gmail.com.png','2019-05-14','Nemfodendo','Active','2012-01-01','2012-01-01');

INSERT INTO market 
VALUES(0, 'Pgtronic','nicolasprado0028@gmail.com','imgnicolasprado0028@gmail.com.png','2019-05-14','andrepika','Active','2012-01-01','2012-01-01');

CREATE TABLE employer(
    pk_employer_relation    INT            NOT NULL AUTO_INCREMENT,
    fk_id_user              INT, 
    fk_id_market            INT, 

    ds_role                 VARCHAR(255),
    dt_hiring               DATE,
    
    dt_creation             DATE,
    dt_update               DATE,

    PRIMARY KEY(pk_employer)
);

INSERT INTO employer 
VALUES(0, 1, 4, 'Boss', '2023-03-07', '2012-01-01', '2012-01-01');

INSERT INTO employer 
VALUES(0, 1, 5, 'Boss', '2023-03-07', '2012-01-01', '2012-01-01');
--VALUES(0, 1, 1, 'Boss', '2023-03-07', '2012-01-01', '2012-01-01');

CREATE TABLE product(
    pk_id_product           INT             NOT NULL AUTO_INCREMENT,
    fk_id_market            INT,
    fk_id_category          INT,

    nm_product              VARCHAR(255),
    ds_product              VARCHAR(255),
    vl_price                VARCHAR(255),
    ds_mark                 VARCHAR(255),
    dt_fabrication          DATE,
    ie_selled               VARCHAR(50),

    dt_creation             DATE,
    dt_update               DATE,
    ie_deleted              VARCHAR(50),

    PRIMARY KEY(pk_id_product)
)

CREATE TABLE category(
    pk_id_category          INT             NOT NULL AUTO_INCREMENT,
    fk_id_market            INT,

    nm_category             VARCHAR(255),
    ds_category             VARCHAR(255),
    cd_color                VARCHAR(255),

    dt_creation             DATE,
    dt_update               DATE,
    ie_deleted              VARCHAR(50),

    PRIMARY KEY(pk_id_category)
)