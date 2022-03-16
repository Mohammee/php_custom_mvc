<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        .navtop {
            background-color: #2f3947;
            height: 60px;
            width: 100%;
            border: 0;
        }

        .navtop div {
            display: flex;
            margin: 0 auto;
            width: 1000px;
            height: 100%;
        }

        .navtop div h1, .navtop div a {
            display: inline-flex;
            align-items: center;
        }

        .navtop div h1 {
            flex: 1;
            font-size: 24px;
            padding: 0;
            margin: 0;
            color: #eaebed;
            font-weight: normal;
        }

        .navtop div a {
            padding: 0 20px;
            text-decoration: none;
            color: #c1c4c8;
            font-weight: bold;
        }

        .navtop div a i {
            padding: 2px 8px 0 0;
        }

        .navtop div a:hover {
            color: #eaebed;
        }

        body.loggedin {
            background-color: #f3f4f7;
        }

        .content {
            width: 1000px;
            margin: 0 auto;
        }

        .content h2 {
            margin: 0;
            padding: 25px 0;
            font-size: 22px;
            border-bottom: 1px solid #e0e0e3;
            color: #4a536e;
        }

        .content > p, .content > div {
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
            margin: 25px 0;
            padding: 25px;
            background-color: #fff;
        }

        .content > p table td, .content > div table td {
            padding: 5px;
        }

        .content > p table td:first-child, .content > div table td:first-child {
            font-weight: bold;
            color: #4a536e;
            padding-right: 15px;
        }

        .content > div p {
            padding: 5px;
            margin: 0 0 10px 0;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .content table tr th, table tr td {
            padding: 5px;
            border: 1px #888 solid;
        }

        .content tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        .content tfoot tr th {
            text-align: right;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }

    </style>
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1><a href="/">Website Title</a></h1>
        <a href="/profile"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Transaction Page</h2>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th># Check</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($data['transactions'])): ?>
            <?php
            foreach ($data['transactions'] as $key => $transaction): ?>
                <tr>
                    <td><?= $transaction['date'] ?></td>
                    <td><?= $transaction['check'] ?></td>
                    <td><?= $transaction['description'] ?></td>
                    <td class="<?= $transaction['class'] ?>"><?= $transaction['amount'] ?></td>
                </tr>
            <?php
            endforeach; ?>
        <?php
        else: ?>
            <tr>
                <td colspan="4">No Data</td>
            </tr>
        <?php
        endif ?>

        </tbody>
        <tfoot>

        <tr>
            <th colspan="3">Total Income:</th>
            <td><?= $data['income'] ?></td>
        </tr>
        <tr>
            <th colspan="3">Total Expense:</th>
            <td><?= $data['expense'] ?></td>
        </tr>
        <tr>
            <th colspan="3">Net Total:</th>
            <td><?= $data['total'] ?></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>