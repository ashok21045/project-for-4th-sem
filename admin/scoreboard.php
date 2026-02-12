<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Scoreboard</title>
    <?php
    include 'admin_auth.php';
    include '../partials/_test.php';

    $res = mysqli_query($conn, "
        SELECT user.username, game, current_streak, higest_streak, total_wins 
        FROM scoreboard 
        JOIN user ON scoreboard.id=user.id
        JOIN games ON scoreboard.game_id=games.game_id
    ");
    ?>

    <style>
        /* Base Reset & Theme */
        * { box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { 
            background: #f8fafc; /* Slate-50 */
            color: #1e293b; /* Slate-900 */
            margin: 0; 
            padding: 40px 20px; 
            line-height: 1.6;
        }

        .container { max-width: 1100px; margin: 0 auto; }

        /* Sleek Back Link Animation */
        .back-nav { margin-bottom: 25px; }
        .back-link {
            text-decoration: none;
            color: #6366f1; /* Indigo-500 */
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        .back-link:hover { color: #4338ca; transform: translateX(-5px); }
        .back-link::before { 
            content: '←'; 
            margin-right: 8px; 
            font-size: 18px; 
            font-weight: bold;
        }

        /* Header Section */
        header { 
            margin-bottom: 40px; 
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
        }
        h2 { 
            font-size: 36px; 
            font-weight: 800;
            margin: 0; 
            color: #0f172a; 
            letter-spacing: -0.025em; 
        }
        .subtitle { color: #64748b; font-size: 16px; margin-top: 5px; }

        /* Sleek Rounded Card & Table */
        .card {
            background: white;
            border-radius: 2rem; /* Matches the 32px rounding from User page */
            border: 1px solid #f1f5f9;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #f8fafc;
        }

        thead th {
            padding: 20px 24px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr {
            border-bottom: 1px solid #f8fafc;
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: #fdfdff;
        }

        tbody td {
            padding: 20px 24px;
            font-size: 15px;
            color: #475569;
        }

        /* Themed UI Components */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 12px;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }

        .user-wrapper { display: flex; align-items: center; }
        .username { font-weight: 700; color: #1e293b; }

        .game-badge {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .stat-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
        }
        .wins { background: #dcfce7; color: #166534; }
        .streak { background: #fef2f2; color: #991b1b; }

        /* Empty State */
        .empty { padding: 60px; text-align: center; color: #94a3b8; font-style: italic; }

    </style>
</head>
<body>

<div class="container">
    <div class="back-nav">
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>

    <header>
        <div>
            <h2>🏆 Scoreboard</h2>
            <p class="subtitle">Global player performance and win streaks.</p>
        </div>
        <div style="background: white; padding: 10px 20px; border-radius: 15px; border: 1px solid #e2e8f0; font-size: 13px; font-weight: 700; color: #64748b;">
            Live Rankings
        </div>
    </header>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Game</th>
                    <th>Total Wins</th>
                    <th>Current Streak</th>
                    <th>Highest Streak</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($res) > 0): ?>
                    <?php while ($s = mysqli_fetch_assoc($res)) { ?>
                        <tr>
                            <td>
                                <div class="user-wrapper">
                                    <div class="user-avatar"><?= strtoupper(substr($s['username'], 0, 1)) ?></div>
                                    <span class="username"><?= htmlspecialchars($s['username']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="game-badge"><?= htmlspecialchars($s['game']) ?></span>
                            </td>
                            <td>
                                <span class="stat-badge wins"><?= $s['total_wins'] ?></span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #475569;"><?= $s['current_streak'] ?></span>
                            </td>
                            <td>
                                <span class="stat-badge streak"><?= $s['higest_streak'] ?></span>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty">No player data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>