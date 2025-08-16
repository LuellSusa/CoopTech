<?php
require 'vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

// Loan eligibility threshold
$minNetPay = 1500;

// If form is submitted and file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payslip'])) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmp  = $_FILES['payslip']['tmp_name'];
    $fileName = basename($_FILES['payslip']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $targetFile)) {
        try {
            // 1. OCR extraction
            $extractedText = (new TesseractOCR($targetFile))
                ->lang('eng')
                ->run();
        } catch (Exception $e) {
            die("❌ OCR Error: " . $e->getMessage());
        }

        // 2. AI validation (demo scores)
        $aiResult = [
            "labels" => ["real", "tampered", "fake"],
            "scores" => [0.69220340251923, 0.18190902471542, 0.12588749825954]
        ];

        // 3. Extract NET PAY using regex
        $netPayAmount = null;
        if (preg_match('/NET\s*PAY[^0-9]*([\d,]+\.\d{2})/i', $extractedText, $matches)) {
            $netPayAmount = floatval(str_replace(",", "", $matches[1]));
        }else {
            // Fallback regex for different formats
            if (preg_match('/Net\s*Pay[^0-9]*([\d,]+)/i', $extractedText, $matches)) {
                $netPayAmount = floatval(str_replace(",", "", $matches[1]));
            }
        }

        // 4. Display results
        echo "<pre style='font-family:Arial, sans-serif;'>";
        echo "📝 Extracted Text:\n";
        echo htmlspecialchars(trim($extractedText));
        echo "\n\n";

        echo "🔍 AI Validation Result:\n";
        echo "Confidence (Real): " . round($aiResult['scores'][0] * 100, 2) . "%\n";
        echo "Confidence (Tampered): " . round($aiResult['scores'][1] * 100, 2) . "%\n";
        echo "Confidence (Fake): " . round($aiResult['scores'][2] * 100, 2) . "%\n\n";

        // 5. Authenticity decision
        $threshold = 0.85; // 85% confidence required to accept
        if ($aiResult['scores'][0] >= $threshold) {
            echo "💡 Decision: ✅ ACCEPTED (Payslip authenticity verified)\n";
        } else {
            echo "💡 Decision: ❌ REJECTED (Payslip authenticity failed — "
                 . round($aiResult['scores'][0] * 100, 2) . "% confidence)\n";
        }

        // 6. Loan eligibility check
        if ($netPayAmount !== null) {
            echo "\n💰 NET PAY Detected: {$netPayAmount}\n";
            if ($netPayAmount >= $minNetPay) {
                echo "📋 Loan Eligibility: ✅ ELIGIBLE (Net Pay meets minimum of {$minNetPay})\n";
            } else {
                echo "📋 Loan Eligibility: ❌ NOT ELIGIBLE (Net Pay below {$minNetPay})\n";
            }
        } else {
            echo "\n⚠️ Could not detect NET PAY in the payslip.\n";
        }

        echo "</pre>";

        echo "<br><a href='".$_SERVER['PHP_SELF']."'>🔙 Upload another file</a>";
        exit;
    } else {
        echo "❌ File upload failed!";
    }
}
?>

<!-- HTML Upload Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Payslip OCR & Validation</title>
</head>
<body style="font-family:Arial, sans-serif; text-align:center; margin-top:50px;">
    <h2>📄 Upload Your Payslip</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="payslip" accept="image/*" required>
        <br><br>
        <button type="submit">Upload & Validate</button>
    </form>
</body>
</html>
