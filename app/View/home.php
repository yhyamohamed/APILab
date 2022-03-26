<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../styles.css">
    <title>DB Lab</title>
</head>

<body>
    <?php if (!isset($_SESSION)) {
        session_start();
        if (isset($_POST['check']))
            $_SESSION['check'] = $_POST['check'];
    }
    ?>
    <center>
        <form action="" method="POST">
            <input type="text" id="search" class="search" name="searchkey" placeholder="Type a keyword and hit enter">
            <br>
            <br>
            <input type="submit" name="get_data" value="get selected data">
            <br>
            <br>
            <input type="submit" name="get_by_id" value="select by id">
        </form>
        <script>
            let timeoutID = 0;

            function search(str) {
                // console.log('search: ' + str)
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        word: str
                    },
                    success: (data) => {
                        // console.log(data)
                        table = $('#datatable');
                        table.empty();
                        $(`<tr id='head'></tr>`).appendTo(table)

                        head = $('#head');

                        // console.log()
                        for (const [k, val] of Object.entries(data[0])) {
                            // if(k=='Photo')continue;
                            $('<th></th>').text(k).appendTo(head);

                        }
                        $(`<th></th>`).text('details').appendTo(head)
                        for (const [key, value] of Object.entries(data)) {

                            $(`<tr id='row_${key}'></tr>`).appendTo(table)
                            row = $(`#row_${key}`);
                            for (let [k, val] of Object.entries(value)) {
                                if (k == 'Photo') {
                                    val = val.replace('.', 'tz.');
                                    $(`<img src="../../Resources/images/${val}" alt="">`).appendTo($('<td></td>').appendTo(row))
                                } else {
                                    $('<td></td>').text(val).appendTo(row);
                                }
                                // $('#tbody').html(`<td >${value}</td>`);
                            }
                            $(`<td id='more_${key}'></td>`).appendTo(row)
                            more = $(`#more_${key}`);
                            $(`<a href='product.php?id=${value['id']}'></a>`).text(`read more`).appendTo(more)
                        }
                    }
                });
            }
            $('#search').keyup(function(e) {
                clearTimeout(timeoutID);
                const val = $('#search').val();
                // console.log(val);
                timeoutID = setTimeout(() => search(val), 500)
            });
        </script>
        <?php
        require_once '../../vendor/autoload.php';

        use App\MYSQLHandler;

        $db = new MYSQLHandler();
        $db->connect();

        if (isset($_GET['index'])) {
            $options = array(
                'default' => 0,
                'min_range' => 0
            );
            if (!filter_var($_GET['index'], FILTER_VALIDATE_INT, $options)) {
                $_GET['index'] = 0;
            }
        } else {
            $_GET['index'] = 0;
        }

        // echo "<pre>";
        // print_r($_POST);
        // echo "<pre>";
        // die();
        // if (isset($_POST["get_data"])) {
        if (!empty($_SESSION['check'])) {
            $feilds  = $_SESSION['check'];
        } else {
            $feilds = array();
        }
        $data = $db->get_data($feilds, $_GET['index']);
        if (isset($_POST["searchkey"]) && !empty($_POST["searchkey"])) {
            // header("location:allposts.php?serachword=".$_POST["searchkey"]."");
            $_POST["searchkey"];
        } else if (isset($_POST["get_by_id"])) {
            unset($data);
        ?>
            <form id='primaryKey' action='' method='POST'>
                <label for='id'> Enter id:</label><br>
                <input type='number' id='num' name='id'>
                <input type='submit' id='pk' name='pk'>
            </form>
            <script>
                $('#primaryKey').submit(function(e) {
                    e.preventDefault();
                    let pk = $('#num').val();
                    request = $.ajax({
                        url: "h.php",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            num: pk
                        },
                        success: function(data) {
                            console.log(typeof data);
                            row = $('#tbody');
                            row.empty();
                            for (let [key, value] of Object.entries(data)) {
                                console.log(key, value);
                                if (key == 'Photo') {
                                    value = value.replace('.', 'tz.');
                                    $(`<img src="../../Resources/images/${value}" alt="">`).appendTo($('<td></td>').appendTo(row))
                                } else {
                                    $('<td></td>').text(value).appendTo(row);
                                }
                            }
                            $(`<td id='more'></td>`).appendTo(row)
                            more = $('#more');
                            $(`<a href='product.php?id=${data['id']}'></a>`).text(`read more`).appendTo(more)
                            // console.log(data['id'])
                        }
                    });
                });
            </script>
        <?php


            $singleRowData =  $db->get_record_by_id(17);
        }
        if (isset($data)) {
            //          echo"<pre>";
            // print_r($data);
            //          echo"<pre>";  
            //          die(); 
        ?>
            <h2>Data set</h2>

            <table id="datatable" style="width:50%">
                <tr>
                    <?php foreach ($_SESSION['check'] as $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach; ?>
                    <th>photo</th>
                    <th>details</th>
                </tr>

                <?php foreach ($data as $row) : ?>
                    <tr>
                        <?php
                        foreach ($row as $k => $v) :
                            if ($k == 'id' && !in_array('id', $_SESSION['check'])) continue;
                            if ($k == 'Photo') {
                                $v = str_replace('.', 'tz.', $v);
                        ?>
                                <td> <img src='../../Resources/images/<?= $v ?> ' alt=''></td>
                            <?php
                            } else {
                            ?>
                                <td><?= $v ?></td>
                        <?php }
                        endforeach; ?>

                        <td> <a href='product.php?id=<?= $row->id; ?>'>read more</td>
                    </tr>
                <?php endforeach;
            } else if (isset($singleRowData)) {
                ?>
                <h2>Data set</h2>

                <table style="width:50%">
                    <tr>
                        <?php foreach ($singleRowData as $key => $val) : ?>
                            <th id="thead"><?= $key ?></th>
                        <?php endforeach; ?>
                        <th>details</th>
                    </tr>
                    <tr id="tbody">
                        <?php foreach ($singleRowData as $k => $data) :
                            if ($k == 'Photo') {
                                $data = str_replace('.', 'tz.', $data);
                        ?>
                                <td> <img src='../../Resources/images/<?= $data ?> ' alt=''></td>
                            <?php
                            } else {
                            ?>
                                <td><?= $data ?></td>
                        <?php }
                        endforeach; ?>
                        <td><a href='product.php?id=<?= $singleRowData->id; ?>'>read more</td>
                    </tr>


                <?php } ?>
                </table>
                <br>
                <?php
                $next = ($_GET['index'] + _rec_per_page);
                $prev = (($_GET['index'] - _rec_per_page) >= 0) ? ($_GET['index'] - _rec_per_page) : 0;
                // echo $next;
                // die();
                ?>
                <a href="home.php?index=<?= $prev ?>">
                    <<< prev </a>|| <a href="home.php?index=<?= $next ?>">next >>></a>
                        <br>
                        <a href="index.php">Go back</a>

    </center>