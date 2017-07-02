<?php
class Migrate20170701165512CreateTableArticle extends BaseMigrate{
  private $dbh = null;
  public function __construct($default_database) {
    parent::__construct($default_database);
  }

  public function up() {
    $sql = <<<EOM
CREATE TABLE articles (
  id int(9) NOT NULL AUTO_INCREMENT,
  user_id int(8) NOT NULL,
  article_category_id int(8) NOT NULL,
  file_name varchar(128) NOT NULL,
  title varchar(128) NOT NULL,
  body text NOT NULL,
  created_at datetime NOT NULL,
  modified_at datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY index_articles_id (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
EOM;
    parent::up($sql);
  }

  public function down(){
    $sql = <<<EOM
DROP TABLE articles;
EOM;
    parent::down($sql);
  } 
}