<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$former = isset($_REQUEST['f']) ? trim($_REQUEST['f']) : null;
$latter = isset($_REQUEST['l']) ? trim($_REQUEST['l']) : null;

if ($former === null || $latter === null) {
    $res = array(
        'code' => 10,
        'message' => '有一侧文本未输入'
    );
    exit(json_encode($res));
}
require_once 'lib/Diff.php';
require_once 'lib/Diff/Renderer/Html/SideBySide.php';
$former = explode("\n", preg_replace( ['/\n\n*/', '/\s(?=\s)/', '/…/', '/’/'], ["\n\n", "\\0", '...', "'"], $former ));
$latter = explode("\n", preg_replace( ['/\n\d*:/', '/\n\n*/', '/\s(?=\s)/', '/…/', '/’/', '/\n.*:/'], ["", "\n\n", "\\0", '...', "'", "\n- "], $latter ));

// Options for generating the diff
$options = array(
);

// Initialize the diff class
$diff = new Diff($former, $latter, $options);

$renderer = new Diff_Renderer_Html_SideBySide;
$res0 = iconv('GB2312', 'UTF-8//IGNORE', $diff->Render($renderer));
$res = array(
    'code' => 0,
    'message' => $res0,
    'f1' => $former,
    'l1' => $latter
);
exit(json_encode($res, 384));


