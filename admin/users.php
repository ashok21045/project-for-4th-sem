<?php
include 'admin_auth.php';
include '../partials/_test.php';

if(isset($_GET['block'])){
    // Sanitize input to prevent SQL injection
    $block_id = mysqli_real_escape_with_string($conn, $_GET['block']);
    mysqli_query($conn,"UPDATE user SET status='blocked' WHERE id=".$block_id);
}
$users=mysqli_query($conn,"SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        /* Modern Reset & Base Styles */
        * { box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { background-color: #f4f7fa; margin: 0; padding: 40px; color: #333; }
        
        .container { max-width: 900px; margin: 0 auto; }

        /* Sleek Back Button */
        .back-nav { margin-bottom: 20px; }
        .back-link {
            text-decoration: none;
            color: #6366f1;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .back-link:hover { color: #4338ca; transform: translateX(-5px); }
        .back-link::before { content: '←'; margin-right: 8px; font-size: 18px; }

        h2 { font-size: 28px; font-weight: 700; margin-bottom: 25px; color: #1e293b; }

        /* Glassmorphism Table Design */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        
        th {
            background-color: #f8fafc;
            padding: 16px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
        }

        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 15px; }
        
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #fbfcfe; }

        /* Status Badges */
        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-active { background: #dcfce7; color: #166534; }
        .status-blocked { background: #fee2e2; color: #991b1b; }

        /* Action Button */
        .btn-block {
            text-decoration: none;
            background-color: #ef4444;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-block:hover { background-color: #dc2626; box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.2); }
    </style>
</head>
<body>

<div class="container">
    <div class="back-nav">
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>

    <h2>User Management</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($u = mysqli_fetch_assoc($users)){ 
                    $statusClass = ($u['status'] == 'blocked') ? 'status-blocked' : 'status-active';
                ?>
                <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td style="font-weight: 500; color: #1e293b;"><?= htmlspecialchars($u['username']) ?></td>
                    <td>
                        <span class="status <?= $statusClass ?>">
                            <?= htmlspecialchars($u['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if($u['status'] !== 'blocked'): ?>
                            <a href="?block=<?= $u['id'] ?>" class="btn-block" onclick="return confirm('Block this user?')">Block</a>
                        <?php else: ?>
                            <span style="color: #cbd5e1; font-size: 13px;">No Actions</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>