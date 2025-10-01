<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/opt/lampp/htdocs/chat/error.log');

header('Content-Type: application/json');

define('CHAT_DIR', '/opt/lampp/htdocs/chat/chat_his/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB in bytes

function getLatestFile() {
    if (!is_dir(CHAT_DIR)) {
        if (!mkdir(CHAT_DIR, 0755, true)) {
            error_log("Failed to create directory: " . CHAT_DIR);
            return false;
        }
    }
    $files = glob(CHAT_DIR . '*.txt');
    return $files ? end($files) : CHAT_DIR . date('mdy') . '.txt';
}

function saveMessage($message, $ip) {
    $file = getLatestFile();
    if (!$file) return false;
    
    if (file_exists($file) && filesize($file) >= MAX_FILE_SIZE) {
        $file = CHAT_DIR . date('mdy') . '.txt';
    }
    
    $formattedMessage = json_encode([
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $ip,
        'message' => $message
    ]);
    
    if (file_put_contents($file, $formattedMessage . PHP_EOL, FILE_APPEND) === false) {
        error_log("Failed to write to file: $file");
        return false;
    }
    return true;
}

function getMessages() {
    $file = getLatestFile();
    if (!$file) return [];

    $messages = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $decoded = json_decode($line, true);
            if (is_array($decoded) && isset($decoded['timestamp'], $decoded['ip'], $decoded['message'])) {
                $messages[] = $decoded;
            } else {
                error_log("Invalid message format: $line");
            }
        }
    } else {
        error_log("Chat file does not exist: $file");
    }
    return $messages;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['message'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $message = htmlspecialchars($input['message']);
        if (saveMessage($message, $ip)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No message provided']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $messages = getMessages();
    echo json_encode(['messages' => $messages]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

error_log("Script executed. Method: " . $_SERVER['REQUEST_METHOD'] . ", Response: " . ob_get_contents());
