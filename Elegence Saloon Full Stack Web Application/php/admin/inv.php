<?php
include "config.php";

$success = "";
$error = "";

// Add Item
if (isset($_POST['add_item'])) {
    $name = trim($_POST['item_name']);
    $category = trim($_POST['item_category']);
    $quantity = intval($_POST['item_quantity']);
    $cost = floatval($_POST['item_cost']);
    $supplier = trim($_POST['item_supplier']);
    $description = trim($_POST['item_description']);

    if (empty($name) || empty($category) || empty($supplier) || $quantity < 0 || $cost < 0) {
        $error = "Please fill all required fields correctly.";
    } else {
        $sql = "INSERT INTO inventory (item_name, category, quantity, supplier, cost, description) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisis", $name, $category, $quantity, $supplier, $cost, $description);
        if ($stmt->execute()) {
            $success = "Item added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}

// Delete Item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM inventory WHERE id=$id");
    $success = "Item deleted successfully!";
}

// Stats Queries
$totalItems = $conn->query("SELECT COUNT(*) AS total FROM inventory")->fetch_assoc()['total'];
$lowStock = $conn->query("SELECT COUNT(*) AS low FROM inventory WHERE quantity < 10")->fetch_assoc()['low'];
$totalValue = $conn->query("SELECT SUM(quantity * cost) AS value FROM inventory")->fetch_assoc()['value'];
$suppliers = $conn->query("SELECT COUNT(DISTINCT supplier) AS suppliers FROM inventory")->fetch_assoc()['suppliers'];

// Get Inventory Data
$result = $conn->query("SELECT * FROM inventory ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/inv.css">
</head>
<body>

<?php include "side.php"; ?>

<div class="main-content">
  <div class="page-header">
    <div>
      <h1 class="page-title">Inventory Management</h1>
      <div class="breadcrumb">
        <a href="#">Dashboard</a> / Inventory
      </div>
    </div>
    <div class="page-actions">
      <button class="btn btn-primary" id="addItemBtn">
        <i class="fas fa-plus"></i> Add Inventory Item
      </button>
    </div>
  </div>

  <?php if ($success): ?>
    <div style="color:green; margin:10px 0;"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div style="color:red; margin:10px 0;"><?= $error ?></div>
  <?php endif; ?>

  <!-- Stats Boxes -->
  <div class="inventory-stats">
    <div class="stat-card">
      <div class="stat-value"><?= $totalItems ?></div>
      <div class="stat-label">Total Items</div>
      <i class="fas fa-boxes stat-icon"></i>
    </div>
    <div class="stat-card">
      <div class="stat-value"><?= $lowStock ?></div>
      <div class="stat-label">Low Stock Items</div>
      <i class="fas fa-exclamation-triangle stat-icon"></i>
    </div>
    <div class="stat-card">
      <div class="stat-value">$<?= number_format($totalValue ?? 0, 2) ?></div>
      <div class="stat-label">Total Inventory Value</div>
      <i class="fas fa-dollar-sign stat-icon"></i>
    </div>
    <div class="stat-card">
      <div class="stat-value"><?= $suppliers ?></div>
      <div class="stat-label">Suppliers</div>
      <i class="fas fa-truck stat-icon"></i>
    </div>
  </div>

  <!-- Inventory Table -->
  <div class="inventory-table-container">
    <table class="table">
      <thead>
        <tr>
          <th>Item Name</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Supplier</th>
          <th>Cost</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['item_name']) ?></td>
            <td><?= ucfirst($row['category']) ?></td>
            <td class="<?= ($row['quantity'] < 10 ? 'quantity-low' : '') ?>"><?= $row['quantity'] ?></td>
            <td><?= htmlspecialchars($row['supplier']) ?></td>
            <td>$<?= number_format($row['cost'], 2) ?></td>
            <td>
              <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this item?')" class="btn btn-danger">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Item Modal -->
<div class="modal" id="itemModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Add Inventory Item</h3>
      <button class="close-btn" id="closeModal">&times;</button>
    </div>
    <div class="modal-body">
      <form method="POST">
        <div class="form-group">
          <label>Item Name *</label>
          <input type="text" name="item_name" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select name="item_category" class="form-select" required>
            <option value="hair">Hair Products</option>
            <option value="skin">Skin Care</option>
            <option value="nails">Nail Products</option>
            <option value="tools">Tools & Equipment</option>
            <option value="other">Other</option>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Quantity *</label>
            <input type="number" name="item_quantity" class="form-input" min="0" required>
          </div>
          <div class="form-group">
            <label>Cost per Unit ($) *</label>
            <input type="number" name="item_cost" class="form-input" step="0.01" min="0" required>
          </div>
        </div>
        <div class="form-group">
          <label>Supplier *</label>
          <input type="text" name="item_supplier" class="form-input" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="item_description" class="form-input" rows="3"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
          <button type="submit" name="add_item" class="btn btn-primary">Save Item</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src = js/inv.js>

</script>

</body>
</html>
