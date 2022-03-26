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

    <?php
    require_once '../../vendor/autoload.php';

    use App\MYSQLHandler;

    // if (!filter_var($_GET['id'], FILTER_VALIDATE_INT) || !isset($_GET['id'])) {
    //     header('Location:home.php?index=0');
    // } else {


        $db = new MYSQLHandler();
        // $db->connect();
        $data = $db->get_record_by_id($_GET['id']);

        if (!empty($data)) {

    ?>
            <center style="height: 300px;">
                <h2 style="margin-bottom: 0;"><?= $data->product_name ?></h2>
                <table style="width:50%;height:50%">
                    <tr>
                        <?php foreach ($data as $key => $val) : ?>
                            <td id="thead"><?= $key ?></td>
                            <td style="height: 22px;">
                            <?php
                                if ($key == 'Photo') { ?>
                                <img src="../../Resources/images/<?= $val; ?>" alt="">
                                <?php
                                } else {

                                    echo $val;
                                }
                                ?>
                               
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tr>
                   
                </table>
                <a href="home.php?index=0">Go back</a>
            </center>
    <?php
        }
    // }
    ?>