<?php

function ssbg_display_background() {
	global $ssbg_option_name, $ssbg_settings;
  
  if($ssbg_settings['enabled']){
    $images = get_option($ssbg_option_name);

    if($images) {
      $image_html  = '<img id="ssbg_image1"/>';
      $image_html .= '<img id="ssbg_image2"/>';
      $image_html .= '<script language="JavaScript1.2">
                      var imgs=new Array() 
                      ';

      for($i = 0; $i < count($images); $i++){
        $image_html .= 'imgs['.$i.']="'.$images[$i]['picture']."\";\n";
      }

      $image_html .= '
                    if( ! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                      //preload images
                      var pathToImg=new Array()
                      for (i=0;i<imgs.length;i++)
                      {
                        pathToImg[i]=new Image()
                        pathToImg[i].src=imgs[i]
                      }

                      var inc = Math.floor(Math.random()*imgs.length);

                      jQuery(\'#ssbg_image1\').attr(\'src\',imgs[inc]);

                      fadeout = 1;
                      fadein = 2; 

                      function simpleSlideshow()
                      { 
                        if (inc<imgs.length-1)
                          inc++
                        else
                          inc=0

                        jQuery(\'#ssbg_image\'+fadein).css(\'zIndex\', -9999);  
                        jQuery(\'#ssbg_image\'+fadeout).css(\'zIndex\', -9998); 

                        jQuery(\'#ssbg_image\'+fadein).attr(\'src\', imgs[inc]);
                        jQuery(\'#ssbg_image\'+fadein).show();

                        jQuery(\'#ssbg_image\'+fadeout).fadeOut(1000,function(){});

                        temp = fadeout;
                        fadeout = fadein;
                        fadein = temp;
                      }

                      jQuery(\'document\').ready(setInterval(function() { simpleSlideshow() },'.$ssbg_settings['delay'].'000));
                    }
                  </script>';
    }
    // output the image
    echo $image_html;
  }
}
add_action('wp_footer', 'ssbg_display_background');