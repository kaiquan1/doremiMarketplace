<?php
session_start();
include("adminAuth.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Admin Products
    </title>
    <link rel="stylesheet" href="style.css">
    <script src="javascript.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="admin_function">
        <h2>Products List<br>Records</h2>
        <?php
        include("database.php");
        $result = $conn->query("SELECT * from product");
        //Store each product
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $result->free_result();
        ?>
        <!--Back Button-->
        <button style="position: relative; left:1%" onclick="location.href='adminDashboard.php'">Back</button>
        <!--Add Button-->
        <button style="position: relative; left:94%;" onclick="AddPopup()">Add</button>
        <!--Add Pop-up Form-->
        <div id="add_popup" style="width:31%">
            <h2>Add</h2>
            <span class="close" onclick="CloseAddPopup()">&times</span>
            <form action="add.php" method="post" enctype="multipart/form-data" onsubmit="return confirmation('add')">
                <label for="sku">Sku</label>
                <label for="category" style="position:relative; left:150px;">Category</label>
                <input type="text" name="sku" placeholder="Enter sku" required>
                <input type="text" name="category" style="position:relative; left:18px;" placeholder="Enter category" required>
                <br><br>
                <label for="name">Name</label>
                <br>
                <textarea name="name" maxlength="100" rows=8 cols=60 placeholder="Enter name" required></textarea>
                <br><br>
                <label for="description">Description</label>
                <br>
                <textarea name="description" rows=8 cols=60 placeholder="Enter description" required></textarea>
                <br><br>
                <label for="price">Price</label>
                <label for="discount" style="position:relative; left:155px;">Discount</label>
                <input type="number" name="price" step="0.01" placeholder="Enter price" required>
                <input type="number" name="discount" step="0.01" style="position:relative; left:18px;"
                    placeholder="Enter discount" required>
                <br><br>
                <label for="image">Image</label>
                <label for="type" style="position:relative; left:210px;">Type</label><br>
                <input type="file" name="image" accept="image/png, image/jpeg, image/jpg" required>
                <input type="text" name="type" placeholder="Enter what the type" required>
                <br><br>
                <div style="text-align:center;">
                    <input type="submit" name="add_product" value="Submit">
                </div>
            </form>
        </div>
        <table class="admin_table table_center">
            <!--Table Header-->
            <tr>
                <th>sku</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            $count = 0;
            foreach ($products as $product) {
                $count++; ?>
            <tr>
                <td>
                    <?php echo $product['sku']; ?>
                </td>
                <td>
                    <?php echo $product['name']; ?>
                </td>
                <td>
                    <?php echo strtoupper($product['category']); ?>
                </td>
                <td>
                    <?php echo $product['description']; ?>
                </td>
                <td>
                    <?php echo $product['price']; ?>
                </td>
                <td>
                    <?php echo $product['discount']; ?>
                </td>
                <td>
                    <?php echo strtoupper($product['type']); ?>
                </td>
                <td>
                    <img src="<?php echo $product['image']; ?>" width="100px" height="120px">
                </td>
                <td>
                    <!--Edit Button-->
                    <button class="edit_button" onclick="EditPopup(<?php echo $count; ?>)">Edit</button>
                    <!--Edit Pop-up Form-->
                    <div class="edit_popup admin_product" style="width:31%">
                        <h2>Edit</h2>
                        <span class="close" onclick="CloseEditPopup(<?php echo $count; ?>)">&times</span>
                        <form action="edit.php" method="post" enctype="multipart/form-data"
                            onsubmit=" return confirmation('edit')">
                            <label for="category">Category</label>
                            <input type="text" name="category" style="position:relative; left:18px;"
                                value="<?php echo $product['category']; ?>">
                            <br><br>
                            <label for="name">Name</label>
                            <br>
                            <textarea name="name" maxlength="100" rows=8 cols=60
                                required><?php echo $product['name']; ?></textarea>
                            <br><br>
                            <label for="description">Description</label>
                            <br>
                            <textarea name="description" rows=8 cols=60
                                required><?php echo $product['description']; ?></textarea>
                            <br><br>
                            <label for="price">Price</label>
                            <label for="discount" style="position:relative; left:155px;">Discount</label>
                            <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>">
                            <input type="number" name="discount" step="0.01" style="position:relative; left:18px;"
                                value="<?php echo $product['discount']; ?>">
                            <br><br>
                            <label for="image">Image</label>
                            <label for="type" style="position:relative; left:210px;">Type</label><br>
                            <input type="file" name="image" accept="image/png, image/jpeg, image/jpg">
                            <input type="text" name="type" value="<?php echo $product['type']; ?>">
                            <br><br>
                            <div style="text-align:center;">
                                <input type="submit" name="edit_product" value="Submit">
                            </div>
                            <input type="hidden" name="sku" value="<?php echo $product['sku'] ?>">
                        </form>
                    </div>
                </td>
                <!--Delete Button-->
                <td>
                    <form action="delete.php" method="post" onsubmit="return confirmation('delete')">
                        <input type="submit" name="delete_product" value="Delete">
                        <input type="hidden" name="sku" value="<?php echo $product['sku']; ?>">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        </form>
    </div>

    </div>
    <div id="overlay"></div>
</body>

</html>