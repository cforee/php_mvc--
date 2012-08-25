<?php

class Controller {

  public $load;
  public $model;
  public $location = 'home';
  public $action = '';
  public $format = 'html';

  function set_format($format) {
    $this->format = $format;
  }
  
  function render() {
    $this->model = new Model();
    $this->load = new Load();
    if (isset($_GET['q'])) {
      // if it's there, get routing token (used in routes.php) from URL
      $this->location = trim($_GET['q']);
    }
    if (isset($_GET['action'])) {
      // if it's there, get action from URL
      $this->action = trim($_GET['action']);
    }
    // render output
    if ($this->format == 'html') include('views/layout/top.php');  // render top half of layout
    include('config/routes.php');  // route to the requested controller method
    if ($this->format == 'html') include('views/layout/bottom.php');  // render bottom half of layout
  }

  function home($action = null) {
    // render default view
    $this->load->view('home/index');
  }

  /* cases for managing pages */
  function thing($action = null) {
    switch ($action) {

      /* new Thing */
      case 'new':
        // $data['form_target_for_thing'] = "?q=thing&action=create";
        // $this->load->view('things/show', $data);
        break;

      /* show Thing */
      case 'show':
        // $data['thing'] = $this->model->find(THINGS, $thing_id);
        // $this->load->view('things/show', $data);
        break;

      /* persist Thing */
      case 'create':
        // $this->model->create(THINGS, $data);
        break;

      /* update Thing */
      case 'update':
        break;

      /* destroy Thing */
      case 'destroy':
        // $this->model->destroy(THINGS, $id);
        // $data['things'] = $this->model->find(THINGS);
        // $this->load->view('things/index', $data);
        break;

      /* list Things */
      default:
        // $data['things'] = $this->model->find(THINGS);
        // $this->load->view('things/index', $data);
        break;

    }
  }

}

?>
