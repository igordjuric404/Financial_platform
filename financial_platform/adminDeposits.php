<?php
session_start();
include('php/connection.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Dohvati sve depozite sa email-om korisnika
$query = "
    SELECT d.id, u.email, d.coin, d.amount, d.created_at 
    FROM deposits d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.created_at DESC
";
$stmt = $conn->prepare($query);
$stmt->execute();
$deposits = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Deposits</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    button.delete-btn { background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer; }
</style>
</head>
<body>

<h2>All Deposits</h2>
<table id="depositsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>User Email</th>
            <th>Coin</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($deposits): ?>
            <?php foreach ($deposits as $deposit): ?>
                <tr data-id="<?= $deposit['id'] ?>">
                    <td><?= htmlspecialchars($deposit['id']) ?></td>
                    <td><?= htmlspecialchars($deposit['email']) ?></td>
                    <td><?= htmlspecialchars($deposit['coin']) ?></td>
                    <td><?= htmlspecialchars($deposit['amount']) ?></td>
                    <td><?= htmlspecialchars($deposit['created_at']) ?></td>
                    <td><button class="delete-btn">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No deposits found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


<script>
$(document).ready(function() {
    $('#depositsTable').on('click', '.delete-btn', function() {
        const $row = $(this).closest('tr');
        const depositId = $row.data('id');

        if (!confirm('Are you sure you want to delete this deposit?')) return;

        $.ajax({
            url: 'php/deleteDeposit.php',
            method: 'POST',
            data: { id: depositId },
            success: function(response) {
                const data = (typeof response === 'string') ? JSON.parse(response) : response;
                if (data.success) {
                    $row.remove();
                    alert('Deposit deleted successfully');
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error while deleting deposit');
            }
        });
    });
});
</script>

</body>
</html>
