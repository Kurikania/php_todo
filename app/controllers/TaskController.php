<?php
class TaskController extends ApplicationController
{
      public function listAction() 
    {
        $tasks = new Task();
        $tasks = $tasks->fetchAll();
        $this->view->__set('tasks', $tasks);
    }
  
    public function indexAction(): void
    {
        $tasks = new Task();
        $tasks = $tasks->fetchAll();
        $this->view->__set('tasks', $tasks);
    }

    public function createAction()
    {
        // create action can be post or get
        $task = new Task();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view->__set('task', $task);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // implement save
            print_r($_POST);
            // populate object, don't save from post directly
            $task->title = $_POST['title'];
            $task->status = StatusEnum::fromValue((int) $_POST['status']);
            $task->save();
            $this->redirect('/');
        }
    }

    public function editAction()
    {
        $taskId = $this->_getParam('id');
        // find task
        $task = new Task();
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $task = $task->fetchOne((int) $taskId);
            $this->view->__set('task', $task);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // implement save
            $task->id = $_POST['id'];
            $task->title = $_POST['title'];
            $task->created_at = $_POST['created_at'];
            $task->status = StatusEnum::fromValue((int) $_POST['status']);
            // todo add description and in class task too
            $task->save();
            $this->redirect('/');
        }
    }

    public function deleteAction()
    {
        
        // make sure there is the task
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['id'];
            $task = new Task();
            $task->delete($taskId);

            $this->redirect('/');
        }
    }
    public function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

}
