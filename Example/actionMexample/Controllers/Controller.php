<?php

namespace packages\actionMexample\Controllers;
use Bootstrap\Controllers\BootstrapController;
use packages\actionMexample\Views\View as ArticleView;
use packages\actionMexample\Models\Model as ArticleModel;

class Controller extends BootstrapController {

    /* @var ArticleView */
    public $view;

    /* @var ArticleModel */
    public $model;


    /* this is the default action inside the controller. This gets called, if
    nothing else is defined for the route */
    public function actionDefault(){

        /* if user has already completed the first phase, move to phase 2 */
        if($this->model->sessionGet('reg_phase') == 2){
            return $this->actionPagetwo();
        }

        $data['fieldlist'] = $this->model->getFieldlist();
        $data['current_country'] = $this->model->getCountry();

        /* if user has clicked the signuop, we will first validate
        and then save the data. validation errors are also available to views and components. */
        if($this->getMenuId() == 'signup'){
            $this->model->validatePage1();

            if(empty($this->model->validation_errors)){
                /* if validation succeeds, we save data to variables and move user to page 2*/
                $this->model->savePage1();
                $this->model->sessionSet('reg_phase', 2);
                return ['Pagetwo',$data];
            }
        }

        return ['View',$data];
    }


    public function actionPagetwo(){

        $data['mode'] = 'show';

        /* no validation here */
        if($this->getMenuId() == 'done'){
            $this->model->closeLogin();
            $data['mode'] = 'close';
        }

        return ['Pagetwo',$data];

    }



}