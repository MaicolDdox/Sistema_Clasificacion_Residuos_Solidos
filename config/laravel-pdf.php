<?php

$laragonNodeCandidates = glob('C:/laragon/bin/nodejs/node-v*/node.exe') ?: [];
natsort($laragonNodeCandidates);
$laragonNodeCandidates = array_values($laragonNodeCandidates);

$defaultNodeBinary = env('LARAVEL_PDF_NODE_BINARY');

if (! $defaultNodeBinary && ! empty($laragonNodeCandidates)) {
    $defaultNodeBinary = end($laragonNodeCandidates);
}

$defaultNpmBinary = env('LARAVEL_PDF_NPM_BINARY');

if (! $defaultNpmBinary && $defaultNodeBinary) {
    $candidateNpm = str_replace('node.exe', 'npm.cmd', $defaultNodeBinary);

    if (is_file($candidateNpm)) {
        $defaultNpmBinary = $candidateNpm;
    }
}

$defaultChromePath = env('LARAVEL_PDF_CHROME_PATH');

if (! $defaultChromePath) {
    $chromeCandidates = [
        'C:/Program Files/Google/Chrome/Application/chrome.exe',
        'C:/Program Files (x86)/Google/Chrome/Application/chrome.exe',
    ];

    foreach ($chromeCandidates as $chromeCandidate) {
        if (is_file($chromeCandidate)) {
            $defaultChromePath = $chromeCandidate;
            break;
        }
    }
}

return [
    'browsershot' => [
        'node_binary' => $defaultNodeBinary,
        'npm_binary' => $defaultNpmBinary,
        'include_path' => env('LARAVEL_PDF_INCLUDE_PATH'),
        'chrome_path' => $defaultChromePath,
        'node_modules_path' => env('LARAVEL_PDF_NODE_MODULES_PATH', base_path('node_modules')),
        'bin_path' => env('LARAVEL_PDF_BIN_PATH'),
        'temp_path' => env('LARAVEL_PDF_TEMP_PATH'),
        'write_options_to_file' => env('LARAVEL_PDF_WRITE_OPTIONS_TO_FILE', false),
        'no_sandbox' => env('LARAVEL_PDF_NO_SANDBOX', false),
    ],
];
