
<div id="map_event_list" style="<?php if(isset($listViewWidth) && $listViewWidth!=''){ echo 'width:'.$listViewWidth.'px';  } ?>">

        <div id="eventsList" style="<?php if(isset($listViewWidth) && $listViewWidth!=''){ echo 'width:'.$listViewWidth.'px';  } ?>">

        </div>

            <div id="closeOpenEventList">
                <a id="eventsListOpenClose" class="eventsListOpenClose" href="#"></a>
            </div>

</div>
<div id="map_canvas" class="map_canvas" style="width:100%; height:100%"></div>

<style>

    #map_event_list{
        background: none repeat scroll 0 0 #333333;
        border-right: 1px solid rgba(0, 0, 0, 0.5);
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.5);
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 302px;
        z-index: 100;
    }
    #headerSmall,#header{
        z-index: 101;
    }

    #map_event_list > div#eventsList{
        float: left;
        height: 100%;
        margin-top: 50px;
        overflow-x: hidden;
        overflow-y: scroll;
        position: relative;
        width: 300px;
    }

    #closeOpenEventList{
        background: #333333; /* Old browsers */
        background: -moz-linear-gradient(left, #333333 0%, #000000 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right top, color-stop(0%,#333333), color-stop(100%,#000000)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(left, #333333 0%,#000000 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(left, #333333 0%,#000000 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(left, #333333 0%,#000000 100%); /* IE10+ */
        background: linear-gradient(to right, #333333 0%,#000000 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#333333', endColorstr='#000000',GradientType=1 ); /* IE6-9 */
        overflow: hidden !important;
        width: 2px !important;

        overflow: visible !important;
    }

    #map_canvas{
        border-left:1px solid rgba(255, 255, 255, 0.1);
    }



    #map_event_list .googleMapsInfoWindowInner{
        border: none;
        float: left;
        padding: 0px;
        margin: 20px !important;
    }

    #map_event_list .eventTitle{
        text-indent: 0px;
        padding-left: 10px;
        padding-right: 10px;
    }


    #map_event_list .eventImage {
        height: auto;
        max-width: 120px;
        min-height: 100px;
    }

    #map_event_list .eventDate{
        height: 111px;
    }

    #map_event_list .googleMapsInfoWindowInner{
        max-height: 113px;
        overflow: hidden;
    }


</style>

<script>

    var closeFullWidth = <?php if(isset($listViewWidth) && $listViewWidth!=''){ echo $listViewWidth;  }else{ echo '300'; } ?>;

    $( "#map_event_list" ).resizable({
        handles: 'e',
        alsoResize: '#eventsList',
        maxWidth: 575,
        minWidth: 250,
        stop: function(event,ui){
            console.log(ui.size['width']);
            closeFullWidth = ui.size['width'];
        }
    });

    var open = true;
    $('#eventsListOpenClose').click(function(){
        if(open){
            $( "#map_event_list" ).animate({
                left: "-"+closeFullWidth
            }, 1000, function() {
                $('#eventsListOpenClose').addClass('open');
            });
            open = false;
        }else{
            $( "#map_event_list" ).animate({
                left: "0"
            }, 1000, function() {
                $('#eventsListOpenClose').removeClass('open');
            });
            open = true;
        }

        return false;
    });
</script>