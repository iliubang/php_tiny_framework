<?php if(!defined('LINGER')){header('HTTP/1.1 403 Forbidden');die();}?><!-- this file is generated by Linger! 2016/03/31 09:27:45 @author: liubang <it.liubang@qq.com> -->
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="/css/Linger.css" />
    
        <foreach>
            aaa
        </foreach>
    
</head>
<body>
    <h1><?=$aaa?></h1>
    <h1><?php echo $aaa;?></h1>
    <ul>
        <?php foreach ($arr as $val) { ?>
            <?php foreach ($arr as $val) { ?>
            <li><?php echo $val['userId'];?> - <?php echo $val['userName'];?></li>
            <?php } ?>
        <?php } ?>
    </ul>
    <ol>
        <?php foreach ($arr as $key => $val) { ?>
            <li><?php echo $key;?> - <?php echo $val['userId'];?> - <?php echo $val['userName'];?></li>
        <?php } ?>
    </ol>
    <?php if ($flag==true) { ?> 
        <h1>this is if </h1>
     <?php }?>
    <?php if ($flag==false) { ?> 
        <h1>this is false</h1>
        <?php } else  {?>
        <h1>this is true</h1>
     <?php }?>
    <?php if ($flag==false) { ?> 
        <h1>this is false</h1>
        <?php } elseif ($flag==true) {?> 
        <h1>this is true</h1>
     <?php }?>
    <h1><?php echo date('Y-m-d H:i:s', $time);?></h1>
    <h1><?php echo Linger\Linger::C('DB_HOST'); ?></h1>
    <!-- this file is generated by Linger! 2016/03/31 09:27:45 @author: liubang <it.liubang@qq.com> -->
<footer>
    <div style="height: 30px; text-align:center">Powered By liubang</div>
</footer>
</body>
</html>