<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
header('Content-Type:application/json; charset=utf-8');

require_once('./config.php');
require_once('./model.php');

$verify = trim(isset($_GET['v']) ? $_GET['v'] : '');
$key = strtolower(trim(isset($_GET['k']) ? $_GET['k'] : ''));

$model = new Model($key);

if ($verify !== $secret) {
    if (empty($key)) {
        $result = array('status' => 1, 'key' => null);
        } else {
            $result = array('status' => 1, 'data' => null);
            }
} elseif (empty($key)) {
    $result = array('status' => 0, 'key' => Model::get_key());
} elseif (!$model->is_lock()) {
    $result = array('status' => 2, 'data' => null);
} else {
    $value = $model->data();
    $result = array('status' => 0, 'data' => $value);
}

exit(json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));