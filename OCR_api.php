<?php
require 'vendor/autoload.php';
use thiagoalessio\TesseractOCR\TesseractOCR;

header('Content-Type: application/json');

$minNetPay = 5000;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payslip'])) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileTmp  = $_FILES['payslip']['tmp_name'];
    $fileName = uniqid("payslip_") . "_" . basename($_FILES['payslip']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $targetFile)) {
        try {
            $extractedText = (new TesseractOCR($targetFile))
                ->lang('eng')
                ->psm(6)
                ->oem(3)
                ->run();
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "OCR Error: ".$e->getMessage()]);
            exit;
        }

        $netPayAmount = null;
        $patterns = [
            '/NET\s*PAY[^0-9]*([\d,]+\.\d{2})/i',
            '/NET\s*PAY[^0-9]*([\d,]+)/i',
            '/SALARY[^0-9]*([\d,]+\.\d{2})/i',
            '/SALARY[^0-9]*([\d,]+)/i',
            '/GROSS\s*PAY[^0-9]*([\d,]+)/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $extractedText, $matches)) {
                $netPayAmount = floatval(str_replace(",", "", $matches[1]));
                break;
            }
        }

        if ($netPayAmount !== null) {
            echo json_encode([
                "success" => true,
                "netPay" => $netPayAmount,
                "eligible" => $netPayAmount >= $minNetPay
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Could not detect 'Net Pay' in your file."
            ]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "File upload failed"]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
