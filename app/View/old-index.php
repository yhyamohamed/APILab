<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>DB Lab</title>
</head>

<body>
    <div id="content" class="container">
        <form action="home.php?index=0" method="POST">
            <input type="checkbox" id="id" name="check[]" value="id">
            <label for="id"> id </label><br>
            <input type="checkbox" id="PRODUCT_code" name="check[]" value="PRODUCT_code">
            <label for="PRODUCT_code"> PRODUCT code </label><br>
            <input type="checkbox" id="product_name" name="check[]" value="product_name">
            <label for="product_name"> product name </label><br>
            <input type="checkbox" id="category" name="check[]" value="category">
            <label for="category"> category </label><br>
            <input type="checkbox" id="CouNtry" name="check[]" value="CouNtry">
            <label for="CouNtry"> Country </label><br>
            <input type="checkbox" id="Rating" name="check[]" value="Rating">
            <label for="Rating"> Rating</label><br>
            <input type="checkbox" id="list_price" name="check[]" value="list_price">
            <label for="list_price"> list price</label><br>
            <input type="checkbox" id="*" name="check[]" value="*">
            <label for="*"> all ?</label><br><br>
            <input type="submit" value="Submit">

        </form>
    </div>
</body>

</html>