<?php if(!defined('LINGER')){header('HTTP/1.1 403 Forbidden');die();}?><!-- this file is generated by Linger! 2016/03/30 17:34:33 @author: liubang <it.liubang@qq.com> -->
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LingerErrorPage</title>
    <link rel="stylesheet" href="/css/Linger/Linger.css">
    <style>
        .container {width: 98%; margin: 10px auto;}
        .bt1 {color:red;font-size: 30px;}
        .bt2 {color:#656e73; padding: 18px; margin-top: 15px; background: #e9e9e9; border-radius: 10px;}
        .bt3 {font-weight: bold; margin-top: 10px; line-height: 150%;
            margin-bottom: 20px;}
    </style>
</head>
<body>
    <div class="container">
        <p class="bt1"><?php echo $type;?></p>
        <p class="bt2"><?php echo $message;?></p>
        <?php if (!empty($trace)) {?> 
            <p class="bt3">PHP Trace</p>
            <table class="lg-table lg-table-list">
                <tr>
                    <th>No.</th><th>File</th><th>Line</th><th>Code</th>
                </tr>
                <?php foreach ($trace as $key => $val) { ?>
                    <tr>
                        <td><?php echo $key;?></td>
                        <td><?php echo \Linger\Linger::_default($val['file']);?></td>
                        <td><?php echo \Linger\Linger::_default($val['line'],0);?></td>
                        <td><?php echo \Linger\Linger::_default($val['class']);?>:<?php echo \Linger\Linger::_default($val['function']);?>()</td>
                    </tr>
                <?php } ?>
            </table>
         <?php }?>

        <p class="bt2">程序运行时间：<?php echo number_format($time,6);?>(s)</p>
    </div>
</body>
</html>