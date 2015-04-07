
<div id="map_event_list" style="<?php if(isset($listViewWidth) && $listViewWidth!=''){ echo 'width:'.$listViewWidth.'px;';  } if(isset($listViewOpen) && $listViewOpen == 'false'){ echo 'left: -'.$listViewWidth.'px;'; } ?>">

    <div id="eventsList" style="<?php if(isset($listViewWidth) && $listViewWidth!=''){ echo 'width:'.$listViewWidth.'px';  } ?>">

    </div>

    <div id="closeOpenEventList">
        <a id="eventsListOpenClose" class="eventsListOpenClose <?php if(isset($listViewOpen) && $listViewOpen == 'false'){ echo 'open'; } ?>" href="#"></a>
    </div>

</div>
<div id="map_canvas" class="map_canvas" style="width:100%; height:100%"></div>


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
            $.ajax({
                url: baseUrl+'index.php/home/updateListViewWidth/',
                type: "POST",
                data: "width="+ui.size['width'],
                success: function(data){

                }
            });
        }
    });

    <?php
        if(isset($listViewOpen) && $listViewOpen != ''){
            echo 'var open = '.$listViewOpen.';';
        }else{
            echo 'var open = true;';
        }
    ?>

    $('#eventsListOpenClose').click(function(){
        if(open){
            $( "#map_event_list" ).animate({
                left: "-"+closeFullWidth
            }, 1000, function() {
                $('#eventsListOpenClose').addClass('open');
            });
            open = false;
            $.ajax({
                url: baseUrl+'index.php/home/listVieOpenClose/',
                type: "POST",
                data: "isOpen=false",
                dataType: 'json',
                success: function(data){

                }
            });
        }else{
            $( "#map_event_list" ).animate({
                left: "0"
            }, 1000, function() {
                $('#eventsListOpenClose').removeClass('open');
            });
            open = true;
            $.ajax({
                url: baseUrl+'index.php/home/listVieOpenClose/',
                type: "POST",
                data: "isOpen=true",
                dataType: 'json',
                success: function(data){

                }
            });
        }



        return false;
    });
</script>