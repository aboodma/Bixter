<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle()?></title>
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/custom.css" media="screen" title="" charset="utf-8">
     <script src="<?=PROOT?>js/jquery-3.3.1.min.js"></script>
     <script src="<?=PROOT?>js/bootstrap.min.js"></script>



    <?=$this->content('head')?>
  </head>
  <body>

    <?=$this->content('body')?>

  </body>
</html>
