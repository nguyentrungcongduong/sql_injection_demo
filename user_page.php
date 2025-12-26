<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background: #fff;">
    <div class="box">
        <h1>Welcome,<span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>user </span>page</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
    <div id="toast-container" class="toast-container"></div>
    <script>
        function createToast(msg, timeout) {
            timeout = timeout || 3000;
            var container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            var el = document.createElement('div');
            el.className = 'toast-item';
            el.textContent = msg;
            container.appendChild(el);
            // trigger animation
            void el.offsetWidth;
            el.classList.add('show');
            // hide then remove
            setTimeout(function() {
                el.classList.remove('show');
                el.classList.add('hide');
            }, timeout);
            setTimeout(function() {
                if (el.parentNode) el.parentNode.removeChild(el);
            }, timeout + 400);
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($_SESSION['success'])): ?>
                createToast("<?php echo addslashes($_SESSION['success']); ?>", 3000);
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>