<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
	// die('发出善子的声音（子曦）');
}
$IP = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';