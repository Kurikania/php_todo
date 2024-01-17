<?php
class TaskController extends ApplicationController
{
    public function indexAction(): void
    {
        $this->view->__set('tasks', []);
    }

    public function createAction()
    {
            $this->view->__set('task', []);
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {

    }
    public function listAction() 
    {
        $this->view->__set('task', []);
    }

}
?>