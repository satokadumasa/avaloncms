<?php
class ArticleController extends BaseController{
  public function __construct($uri, $url = null) {
    $conf = Config::get('database.config');
    $database = $conf['default_database'];
    parent::__construct($database, $uri, $url);
    $this->controller_class_name = str_replace('Controller', '', get_class($this));;
    //$this->role_ids = Config::get('acc/articles');
  }

  public function index() {
    $articles = new ArticleModel($this->dbh);
    $limit = 10 * (isset($this->request['page']) ? $this->request['page'] : 1);
    $offset = 10 * (isset($this->request['page']) ? $this->request['page'] - 1 : 0);

    $datas = $articles->where('Article.id', '>', 0)->limit($limit)->offset($offset)->find('all');

    $ref = isset($this->request['page']) ? $this->request['page'] : 0;
    $next = isset($this->request['page']) ? $this->request['page'] + 1 : 2;

    $this->set('Title', 'Article List');
    $this->set('datas', $datas);
    $this->set('Article', $datas);
    $this->set('ref', $ref);
    $this->set('next', $next);
  }

  public function show() {
    $datas = null;
    $id = $this->request['id'];

    $articles = new ArticleModel($this->dbh);
    $datas = $articles->where('Article.id', '=', $id)->find('first');
    $this->set('Title', 'Article Ditail');
    $this->set('Article', $datas['Article']);
    $this->set('datas', $datas);
  }

  public function create() {
    $this->debug->log("ArticleController::create()");
    $articles = new ArticleModel($this->dbh);
    $form = $articles->createForm();
    $this->set('Title', 'Article Create');
    $this->set('Article', $form['Article']);
  }

  public function save(){
    $this->debug->log("ArticleController::save()");
    try {
      $this->dbh->beginTransaction();
      $articles = new ArticleModel($this->dbh);
      $articles->save($this->request);
      $this->dbh->commit();
      $url = BASE_URL . 'Article' . '/show/' . $articles->primary_key_value . '/';
      $this->redirect($url);
    } catch (Exception $e) {
      $this->debug->log("ArticleController::create() error:" . $e->getMessage());
      $this->set('Title', 'Article Save Error');
      $this->set('error_message', '保存ができませんでした。');
    }
  }

  public function edit() {
    $this->debug->log("ArticleController::edit()");
    try {
      $datas = null;
      $id = $this->request['id'];

      $articles = new ArticleModel($this->dbh);
      $datas = $articles->where('Article.id', '=', $id)->find('first');
      $this->set('Title', 'Article Edit');
      $this->set('Article', $datas['Article']);
      $this->set('datas', $datas);
    } catch (Exception $e) {
      $this->debug->log("ArticleController::edit() error:" . $e->getMessage());
    }
  }

  public function delete() {
    try {
      $this->dbh->beginTransaction();
      $articles = new ArticleModel($this->dbh);
      $articles->delete($this->request['id']);
      $this->dbh->commit();
      $url = BASE_URL . 'Article' . '/index/';
    } catch (Exception $e) {
      $this->debug->log("UsersController::delete() error:" . $e->getMessage());
    }
  }


}