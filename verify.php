<?php
session_start();
include "conn.php";
require 'mail_config.php'; // PHPMailer config

// Make sure user came from registration
if (!isset($_SESSION['user_email'])) {
    die("No email in session. Please register first.");
}

$email = $_SESSION['user_email'];
$message = "";

// --- HANDLE VERIFICATION CODE SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $code = trim($_POST['verify']);

    if (!empty($code)) {
        // Fetch user
        $stmt = $conn->prepare("SELECT verification_code, is_verified FROM users WHERE email = ? AND is_verified = 0");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['verification_code'] == $code) {
                // Mark as verified
                $update = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
                $update->execute([$email]);

                unset($_SESSION['user_email']); // Optional: clear session after verification
                header("Location: login.php"); // or "index.php" if you want auto-login
                exit;
            } else {
                $message = "Invalid verification code.";
            }
        } else {
            $message = "Account already verified or not found.";
        }
    } else {
        $message = "Please enter the code.";
    }
}

// --- HANDLE RESEND REQUEST ---
if (isset($_GET['resend'])) {
    $cooldown_minutes = 5;
    $stmt = $conn->prepare("SELECT code_sent_at FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $lastSent = strtotime($user['code_sent_at']);
        $now = time();

        if (($now - $lastSent) < ($cooldown_minutes * 60)) {
            $remaining = ($cooldown_minutes * 60) - ($now - $lastSent);
            $message = "Please wait " . ceil($remaining / 60) . " minutes before resending.";
        } else {
            $new_code = rand(100000, 999999);
            $update = $conn->prepare("UPDATE users SET verification_code = ?, code_sent_at = NOW() WHERE email = ?");
            $update->execute([$new_code, $email]);

            if (sendConfirmationMail($email, $new_code)) {
                $message = "New verification code sent!";
            } else {
                $message = "Failed to resend email.";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login Page</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE 4 | Login Page" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->

    <meta name="supported-color-schemes" content="light dark" />

    <!-- Fonts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />

    <!-- OverlayScrollbars -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="dist/css/adminlte.css" />
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="login-page bg-body-secondary">
   <p style="background-image: url('bg1.png');">
    <div class="login-box">
      <div class="login-logo">
        <a href="#">CTU-Main Multipurpose Cooperative</a>
      </div>

      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Enter the code sent from email!</p>

          <form action="verify.php" method="post">
            
            <div class="input-group mb-3">
              <input type="text" name="verify" class="form-control" placeholder="Input Code" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-link" id="resendBtn" disabled>Resend code</button>
<span id="countdown"></span>

              </div>
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Verify</button>
                </div>
              </div>
            </div>
          </form>

          <!-- Removed social-auth-links here -->

          
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="dist/js/adminlte.js"></script>

    <!-- OverlayScrollbars Config -->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });

      <script>
const cooldownMinutes = 5; // Change this value to test (e.g., 0.1 for 6 sec)
let remainingTime = cooldownMinutes * 60; // in seconds

const resendBtn = document.getElementById('resendBtn');
const countdownEl = document.getElementById('countdown');

function updateCountdown() {
    let minutes = Math.floor(remainingTime / 60);
    let seconds = remainingTime % 60;
    countdownEl.textContent = ` (${minutes}:${seconds.toString().padStart(2, '0')})`;
    if (remainingTime <= 0) {
        resendBtn.disabled = false;
        countdownEl.textContent = '';
    } else {
        remainingTime--;
        setTimeout(updateCountdown, 1000);
    }
}

// Start countdown
updateCountdown();

resendBtn.addEventListener('click', () => {
    resendBtn.disabled = true;
    fetch('resend.php')
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                remainingTime = cooldownMinutes * 60;
                updateCountdown();
            }
        });
});
</script>
    </script>
  </body>
  <!--end::Body-->
</html>
