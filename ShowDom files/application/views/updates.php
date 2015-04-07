<div id="popup">
    <div id="popupInner" class="clearfix">

		<div id="popupInnerFull" class="clearfix">
        
            <div id="events" class="favourites">

                <p>
                    There are no event updates in your area at this time. Please check back soon.
                </p>

                <?php
                /*
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://showdom.com/blog/?feed=rss2');
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch);
                curl_close($ch);

                foreach($xml->channel->item as $post) {
                    echo $post->title;
                }
                */

                ?>

            </div>
       </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#eventNew').addClass('active');
});
</script>