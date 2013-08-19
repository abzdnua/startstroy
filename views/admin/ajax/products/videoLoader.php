<?php
if(!empty($_POST['link']))
{
    $str  = strpos($_POST['link'],'v=');
    $str2 = strpos($_POST['link'],'feature');
    if($str>$str2)
    {$video_url=substr($_POST['link'], $str+2, $str);}
    else
    {$video_url=substr($_POST['link'], $str+2, $str2-$str-3);}
    $video_url='http://www.youtube.com/v/'.$video_url;

    echo '<div class="del_video" title="Удалить скидку"><img src="sc_img/admin/remove.png" /></div>
        <object width="400" height="240">
        <param name="movie" value="'.$video_url.'"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowscriptaccess" value="always"></param>
        <embed src="'.$video_url.'" type="application/x-shockwave-flash" width="400" height="240" allowscriptaccess="always" allowfullscreen="true"></embed>
        </object>
        <div><input type="hidden" name="video" value="'.$video_url.'"></div>';
}
else
{
    echo 'Ошибка, введи ссылку на видеоролик';
}

