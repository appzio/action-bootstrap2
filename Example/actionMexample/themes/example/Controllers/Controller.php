<?php

namespace Packages\actionMexample\themes\example\controllers;

use Packages\actionMexample\themes\example\Views\Main;
use Packages\actionMexample\themes\example\Views\View as ArticleView;
use Packages\actionMexample\themes\example\Models\Model as ArticleModel;

class Controller extends \Packages\actionMexample\Controllers\Controller {

    /* @var ArticleView */
    public $view;

    /* @var ArticleModel */
    public $model;
    public $title;

    public function __construct($obj){
        parent::__construct($obj);
    }



}