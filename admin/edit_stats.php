<?php
require '../db.php';

// Fetch current stats
$result = $conn->query("SELECT * FROM stats LIMIT 1");
$stats = $result->fetch_assoc();

$message = "";

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $villages = (int)$_POST['villages_served'];
    $blind = (int)$_POST['blind_children_supported'];
    $patients = (int)$_POST['patients_treated'];
    $women = (int)$_POST['women_empowered'];

    $stmt = $conn->prepare("UPDATE stats 
        SET villages_served=?, blind_children_supported=?, patients_treated=?, women_empowered=? 
        WHERE id=?");
    $stmt->bind_param("iiiii", $villages, $blind, $patients, $women, $stats['id']);
    $stmt->execute();
    $stmt->close();

    // Refresh stats after update
    $result = $conn->query("SELECT * FROM stats LIMIT 1");
    $stats = $result->fetch_assoc();

    $message = "Stats updated successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Stats</title>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
        }
        th {
            background-color: #f4f4f4;
        }
        form input {
            padding: 6px;
            margin-bottom: 10px;
            width: 200px;
        }
        button {
            padding: 8px 14px;
        }
    </style>
</head>
<body>
<h1>Edit Stats</h1>

<?php if (!empty($message)): ?>
    <p style="color: green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<h3>Current Stats</h3>
<table>
    <tr>
        <th>Villages Served</th>
        <th>Blind Children Supported</th>
        <th>Patients Treated</th>
        <th>Women Empowered</th>
    </tr>
    <tr>
        <td><?= $stats['villages_served'] ?></td>
        <td><?= $stats['blind_children_supported'] ?></td>
        <td><?= $stats['patients_treated'] ?></td>
        <td><?= $stats['women_empowered'] ?></td>
    </tr>
</table>

<h3>Update Stats</h3>
<form method="POST">
    <label>Villages Served:</label><br>
    <input type="number" name="villages_served" value="<?= $stats['villages_served'] ?>" required><br>

    <label>Blind Children Supported:</label><br>
    <input type="number" name="blind_children_supported" value="<?= $stats['blind_children_supported'] ?>" required><br>

    <label>Patients Treated:</label><br>
    <input type="number" name="patients_treated" value="<?= $stats['patients_treated'] ?>" required><br>

    <label>Women Empowered:</label><br>
    <input type="number" name="women_empowered" value="<?= $stats['women_empowered'] ?>" required><br>

    <button type="submit">Update Stats</button>
</form>
</body>
</html>
