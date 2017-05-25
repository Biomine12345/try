<?php
/**
 * Parent class for all php files that serve as web pages.
 */
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../utils/header.php';

abstract class WebPage {
  protected $twig;

  function __construct() {
    $this->twig = $GLOBALS['twig'];
  }

  public final function serve() {
    if (check_permission($this->get_page_path())) {
      $_GET = sanitize($_GET);
      $_POST = sanitize($_POST);

      if ($this->is_ajax_call()) {
        // Handle the ajax request and output result directly.
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          echo $this->handle_ajax_get(_get('method'));
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          echo $this->handle_ajax_post(_post('method'));
        }
      } else {
        // Handle the get/post request and save result.
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          $this->handle_simple_get();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $this->handle_simple_post();
        }

        // Render and output HTML according to the result.
        $twig_params = $this->get_basic_twig_params();
        $twig_params += $this->get_twig_params();
        echo $this->render_twig($this->get_twig_path(), $twig_params);
      }
    } else if (get_user_type() === UNKNOWN) {
      redirect_login();
    } else {
      echo_forbidden();
    }
  }

  protected final function get_basic_twig_params() {
    $twig_params = ['user' => get_user_model()];
    $twig_params += ['response' => get_post_response()];
    clear_post_response();
    return $twig_params;
  }

  // Generates (but not echo) HTML code from the twig template.
  protected final function render_twig($twig_path, $twig_params) {
    if (!empty($twig_path)) {
      $twig_path = $this->to_localized_twig_path($twig_path);
      $twig_params['user'] = get_user_model();
      return $this->twig->render($twig_path, $twig_params);
    } else {
      return '';
    }
  }

  // Converts the standard service response from the backend to a standard
  // client-side response. It is usually used by AJAX functions that simply
  // pass along the service responses to the client side.
  protected final function to_client_response($service_resp, $suppress_msg = false) {
    $response = null;
    if (!empty($service_resp)) {
      if (isset($service_resp['error_code'])) { // Service response from backend.
        $response['error_code'] = isset($service_resp['error_code']) ? $service_resp['error_code'] : null;
        $response['ret_long'] = isset($service_resp['ret_long']) ? $service_resp['ret_long'] : null;
        $response['ret_double'] = isset($service_resp['ret_double']) ? $service_resp['ret_double'] : null;
        $response['ret_string'] = isset($service_resp['ret_string']) ? $service_resp['ret_string'] : null;
        $response['ret_object'] = isset($service_resp['ret_object']) ? $service_resp['ret_object'] : null;
        $response['ret_blob'] = isset($service_resp['ret_blob']) ? $service_resp['ret_blob'] : null;
        $response['ret_array'] = isset($service_resp['ret_array']) ? $service_resp['ret_array'] : null;
        if ($suppress_msg && $response['error_code'] === SUCCESS) {
          $response['message'] = '';
        } else {
          $response['message'] = response_message($service_resp);
        }
      } else {
        $response = $service_resp;
      }
    } else {
      $response = $service_resp;
    }
    return json_encode($response);
  }

  // A simple success response for the client side.
  protected final function simple_success_response() {
    return json_encode(['error_code' => 0]);
  }

  // e.g. about_us.twig -> about_us_sc.twig.
  private function to_localized_twig_path($twig_path) {
    if (ends_with($twig_path, '.twig')) {
      $locale_id = get_locale_id_in_url();
      if (strlen($locale_id) > 0) {
        $localized_path = substr($twig_path, 0, -5) . '_' . $locale_id . '.twig';
        if (file_exists(__DIR__ . '/../../template/' . $localized_path)) {
          return $localized_path;
        }
      }
    }
    return $twig_path;
  }

  private function is_ajax_call() {
    return _post('method') !== null || _get('method') !== null;
  }

  // Override this method to provide more params for the page rendering.
  protected function get_twig_params() {
    return [];
  }

  protected function get_page_path() {
    return strtok($_SERVER['REQUEST_URI'], '?');
  }

  protected abstract function handle_simple_get();
  protected abstract function handle_simple_post();
  protected abstract function handle_ajax_get($method);
  protected abstract function handle_ajax_post($method);
  protected abstract function get_twig_path();
}
