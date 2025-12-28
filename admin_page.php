<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$result = $conn->query("SELECT id, name, email, role FROM users");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .query-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .query-box h2 {
            color: #856404;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .query-box pre {
            background: white;
            color: #d00;
            font-weight: bold;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #f00;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }

        .warning {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body style="background: #fff;">
    <div class="box">
        <h1>Welcome,<span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>admin </span>page</p>
        <button onclick="window.location.href='logout.php'">Logout</button>


        <!-- Hien thi SQL -->
        <?php if (isset($_SESSION['query_display'])): ?>
            <div class="query-box">
                <div class="warning">
                    ⚠️ <strong>Debug Mode:</strong> Query này chỉ hiển thị để demo SQL Injection.
                </div>
                <h2>📝 SQL Query Used:</h2>
                <!-- hoặc có thể dùng htmlspecialchars() để tránh xss -->
                <pre><?php echo ($_SESSION['query_display']); ?></pre>
            </div>
        <?php
            // Xóa query display sau khi hiển thị
            unset($_SESSION['query_display']);
        endif;
        ?>


        <h2 style="margin-top:30px;">👥 User List</h2>

        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead style="background:#f2f2f2;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <!-- Hien thi SQL -->
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