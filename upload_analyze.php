<?php
require_once __DIR__ . '/vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payslip'])) {
    $file = $_FILES['payslip'];
    $uploadDir = __DIR__ . '/uploads/payslips/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $targetFile = $uploadDir . time() . "_" . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo json_encode(["status" => "error", "message" => "Upload failed."]);
        exit;
    }

    try {
        // 👇 Use your Windows Tesseract path
        $ocr = new TesseractOCR($targetFile);
        $ocr->executable('C:\\Program Files\\Tesseract-OCR\\tesseract.exe'); 
        $text = $ocr->lang('eng')->psm(6)->oem(3)->run();

        // Match Net Pay in any format
        if (preg_match('/net\s*pay\s*[:\-]?\s*([\d,]+)/i', $text, $matches)) {
            echo json_encode([
                "status" => "success",
                "message" => "Payslip valid",
                "netPay" => $matches[1]
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Could not detect Net Pay. Please upload a clearer payslip."
            ]);
        }

    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "OCR error: " . $e->getMessage()
        ]);
    }
}
