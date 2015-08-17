<?php


aop_add_after_returning('wp_head()', function() {
   echo "<meta aop-test='wp_head after ' content='aop-test , thanks.'/>";

   if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=="/index.php")
   {  
      //echo "<script type='text/javascript' src='/extra/public/js/jquery.js'></script>  " ;
      echo "<script type='text/javascript'> window.$=jQuery; </script> ";
      echo "<script type='text/javascript' src='/extra2.1/common/public/js/underscore.min.js'></script>  " ;
      echo "<script type='text/javascript' src='/extra2.1/common/public/js/behavior.js'></script>  " ;
      echo "<script type='text/javascript' src='/extra2.1/common/public/4aop-home.js'></script>  " ;
      

    }
   
});

?> 
