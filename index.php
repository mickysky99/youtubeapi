<?php
    header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    
    <title>Youtube channel list</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        @media screen and (max-width:480px){
            img{
                width:60px;
                height:60px;
            }
        }
    </style>
</head>
<body>
    <h1 class="list-group-item-heading   media-heading " style="text-align:center;color: red;margin-top:25px">Youtube List</h1>
    <div style='text-align: center;'>
    <div style='display: inline-block; text-align: left; max-width: 800px;'>
    <ul style="margin:auto">
        
      <?php
            
            $channelId = 'UC0JB7TSe49lg56u6qH8y_MQ';
            
            $API_key = 'AIzaSyBhCFzxy3UZeU-wP2bepO7O9Od_RPKfgyc';
            
            $video_list = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&maxResults=50&channelId='.$channelId.'&key='.$API_key.''));
            
            
            foreach($video_list->items as $item)
            {
        		if(isset($item->id->videoId)){
        		    
        		    $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id='.$item->id->videoId.'&key=' . $API_key;
                    $one_video_list = json_decode(file_get_contents($url));
                    
                    
                    $VidDuration = $one_video_list->items[0]->contentDetails->duration;
                    $time = convertiso($VidDuration);
                    $pdate = $one_video_list->items[0]->snippet->publishedAt;
                    $year = substr($pdate,0,4);
                     $channel_title = $one_video_list->items[0]->snippet->channelTitle;
         	        echo '<li style="background-color:white;border: 0px" class="list-group-item media" id="'. $item->id->videoId .'">
         	        
                     	        
                                <a class="media-left" href="https://www.youtube.com/watch?v='. $item->id->videoId .'" title="'. $item->snippet->title .'" target="_blank">
                                <img class="media-object"  src="'. $item->snippet->thumbnails->medium->url .'" alt="Responsive image" width="100px" height="60px"/>
                                </a>
                                <div class="media-body bg-primary" style="background-color: white;color: black;">
                                    <h4 class="list-group-item-heading   media-heading ">
                                    <a class="media-left" href="https://www.youtube.com/watch?v='. $item->id->videoId .'" title="'. $item->snippet->title .'" target="_blank">
                                    '.$item->snippet->title.'s 
                                    </a> 
                                    </h4>
                                    <nobar>'.$channel_title.'</nobar>
                            		<nobr>'.$year.'</nobr>
                                        &middot;
                                    <nobr>'.$time.'</nobr>
                                        &middot;
                                    <nobr>'.$one_video_list->items[0]->statistics->viewCount.' views</nobr>
                                        &middot;
                                    <nobr>'.$one_video_list->items[0]->statistics->likeCount.' likes</nobr>
                                        &middot;
                                    <nobr>'.$one_video_list->items[0]->statistics->dislikeCount.' dislikes</nobr>
                                </div>
                          </li>
                    		
                    		
        	        ';
        		}
            }
            
            
            ?>
            	
        	
        
    </ul>
   <div style="text-align:center"> 	
		<a href="https://www.youtube.com/channel/<?php echo $channelId; ?>/videos" target="_blank" class="btn btn-danger btn-lg"><i class="fa fa-youtube"></i> More videos...</a>
	</div>
<?php
    function convertiso($iso){
        $rem_pt = str_replace('PT', '', $iso); 
        $rem_pt1 = str_replace('H',' hour ',$rem_pt);
        $rem_pt2 = str_replace('M',' minutes ',$rem_pt1);
        $rem_pt3 = str_replace('S',' s ',$rem_pt2);
        return $rem_pt3;
    }
?>
<div></div>

            
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>