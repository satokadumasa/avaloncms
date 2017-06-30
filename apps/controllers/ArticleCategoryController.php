<?php
class ArticleCategoryController extends BaseController{
  public function __construct($uri, $url = null) {
    $conf = Config::get('database.config');
    $database = $conf['default_database'];
    parent::__construct($database, $uri, $url);
    $this->controller_class_name = str_replace('Controller', '', get_class($this));;
    //$this->role_ids = Config::get('acc/article_categories');
  }

  public function index() {
    $article_categories = new ArticleCategoryModel($this->dbh);
    $limit = 10 * (isset($this->request['page']) ? $this->request['page'] : 1);
    $offset = 10 * (isset($this->request['page']) ? $this->request['page'] - 1 : 0);

    $datas = $article_categories->where('ArticleCategory.id', '>', 0)->limit($limit)->offset($offset)->find('all');

    $ref = isset($this->request['page']) ? $this->request['page'] : 0;
    $next = isset($this->request['page']) ? $this->request['page'] + 1 : 2;

    $this->set('Title', 'ArticleCategory List');
    $this->set('datas', $datas);
    $this->set('ArticleCategory', $datas);
    $this->set('ref', $ref);
    $this->set('next', $next);
  }

  public function show() {
    $datas = null;
    $id = $this->request['id'];

    $article_categories = new ArticleCategoryModel($this->dbh);
    $datas = $article_categories->where('ArticleCategory.id', '=', $id)->find('first');
    $this->set('Title', 'ArticleCategory Ditail');
    $this->set('ArticleCategory', $datas['ArticleCategory']);
    $this->set('datas', $datas);
  }

  public function create() {
    $this->debug->log("ArticleCategoryController::create()");
    $article_categories = new ArticleCategoryModel($this->dbh);
    $form = $article_categories->createForm();
    $this->set('Title', 'ArticleCategory Create');
    $this->set('ArticleCategory', $form['ArticleCategory']);
  }

  public function save(){
    $this->debug->log("ArticleCategoryController::save()");
    try {
      $this->dbh->beginTransaction();
      $article_categories = new ArticleCategoryModel($this->dbh);
      $article_categories->save($this->request);
      $this->dbh->commit();
      $url = BASE_URL . 'ArticleCategory' . '/show/' . $article_categories->primary_key_value . '/';
      $this->redirect($url);
    } catch (Exception $e) {
      $this->debug->log("ArticleCategoryController::create() error:" . $e->getMessage());
      $this->set('Title', 'ArticleCategory Save Error');
      $this->set('error_message', '保存ができませんでした。');
    }
  }

  public function edit() {
    $this->debug->log("ArticleCategoryController::edit()");
    try {
      $datas = null;
      $id = $this->request['id'];

      $article_categories = new ArticleCategoryModel($this->dbh);
      $datas = $article_categories->where('ArticleCategory.id', '=', $id)->find('first');
      $this->set('Title', 'ArticleCategory Edit');
      $this->set('ArticleCategory', $datas['ArticleCategory']);
      $this->set('datas', $datas);
    } catch (Exception $e) {
      $this->debug->log("ArticleCategoryController::edit() error:" . $e->getMessage());
    }
  }

  public function delete() {
    try {
      $this->dbh->beginTransaction();
      $article_categories = new ArticleCategoryModel($this->dbh);
      $article_categories->delete($this->request['id']);
      $this->dbh->commit();
      $url = BASE_URL . 'ArticleCategory' . '/index/';
    } catch (Exception $e) {
      $this->debug->log("UsersController::delete() error:" . $e->getMessage());
    }
  }


}