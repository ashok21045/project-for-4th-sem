<?php
include 'admin_auth.php';
include '../partials/_test.php';

$message = "";

// --- Handle Deletion ---
if (isset($_POST['remove'])) {
    $game_id = $_POST['game_id'];
    
    // Optional: Delete the physical file before removing from DB
    $res = mysqli_query($conn, "SELECT image FROM games WHERE game_id = $game_id");
    $row = mysqli_fetch_assoc($res);
    if($row['image'] && file_exists($row['image'])) { unlink($row['image']); }

    $stmt = $conn->prepare("DELETE FROM games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    
    if ($stmt->execute()) {
        $message = "Game removed successfully!";
    }
    $stmt->close();
}

// --- Handle Form Submission (Add with Image) ---
if (isset($_POST['add'])) {
    $game_name = $_POST['game'];
    $game_link = $_POST['link'];
    $image_path = "";

    // Image Upload Logic
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . uniqid() . '.' . $file_ext; // Unique name
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    if (!empty(trim($game_name)) && !empty(trim($game_link))) {
        $stmt = $conn->prepare("INSERT INTO games (game, link, image, status) VALUES (?, ?, ?, 'Active')");
        $stmt->bind_param("sss", $game_name, $game_link, $image_path);
        
        if ($stmt->execute()) {
            $message = "Game added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

$games = mysqli_query($conn, "SELECT * FROM games ORDER BY game_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

<div class="container mx-auto p-8 max-w-5xl">
    
    <div class="mb-6">
        <a href="dashboard.php" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-blue-600 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">🎮 Game Console</h2>
            <p class="text-sm text-gray-500">Manage your library thumbnails and links</p>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg bg-white border-l-4 border-blue-500 text-gray-700 shadow-sm flex items-center">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Game</h3>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input name="game" placeholder="Game Title" required class="p-3 border border-gray-200 rounded-lg bg-gray-50 outline-none focus:ring-2 focus:ring-blue-500">
                <input name="link" type="url" placeholder="Game URL (https://...)" required class="p-3 border border-gray-200 rounded-lg bg-gray-50 outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col md:flex-row items-center gap-4">
                <div class="w-full">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Game Thumbnail</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button name="add" class="w-full md:w-48 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-md mt-5">
                    Confirm Add
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Preview</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Game Details</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php while($g = mysqli_fetch_assoc($games)){ ?>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($g['image']): ?>
                            <img src="<?= htmlspecialchars($g['image']) ?>" class="w-16 h-10 object-cover rounded-md shadow-sm border border-gray-200" alt="thumb">
                        <?php else: ?>
                            <div class="w-16 h-10 bg-gray-200 rounded-md flex items-center justify-center text-[10px] text-gray-400">No Img</div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800"><?= htmlspecialchars($g['game']) ?></div>
                        <div class="text-xs text-blue-500 truncate max-w-xs"><a href="<?= htmlspecialchars($g['link']) ?>" target="_blank"><?= htmlspecialchars($g['link']) ?></a></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span>
                            <?= htmlspecialchars($g['status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-6 items-center">
                            <a href="<?= htmlspecialchars($g['link']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Launch</a>
                            <form method="POST" onsubmit="return confirm('Remove this game?');">
                                <input type="hidden" name="game_id" value="<?= $g['game_id'] ?>">
                                <button name="remove" class="text-red-400 hover:text-red-600 transition">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>