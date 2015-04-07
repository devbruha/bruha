<a id="eventListOpenClose" href="#"></a>



<script>
    var open = true;

    $('#eventListOpenClose').click(function(){

        if(open){
            $( "#map_event_list" ).animate({
                "margin-left": "0"
            }, 500, function() {
                $('#eventListOpenClose').addClass('close');
            });

            open = false;
        }else{
            $( "#map_event_list" ).animate({
                "margin-left": "-100%"
            }, 500, function() {
                $('#eventListOpenClose').removeClass('close');
            });

            open = true;
        }

        return false;
    });
</script>

<script type="text/javascript">
var map;
var oms;
var iw;
var allMarkers;
var markersArray = Array();
var markersArray2 = Array();
var inSearch;
var inAdvancedSearch;

var searchString;
var startDate;
var endDate;
var anyDate;
var theLocation;
var catString;
var twelvehour=0;
var featured = 0;
var styles = [
    {
        stylers: [
            { saturation: -100 }
        ]
    }
];

var showFor = "<?php echo $showForCookie; ?>";


var currentStartSearch;
var currentEndSearch;

function initialize() {
    var gm = google.maps;
    var mapOptions = {
        center: new gm.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),
        zoom: Number(<?php echo $zoomCookie; ?>),
        minZoom : 5,
        mapTypeId: gm.MapTypeId.ROADMAP
    };
    map = new gm.Map(document.getElementById("map_canvas"),mapOptions);
    oms = new OverlappingMarkerSpiderfier(map,{markersWontMove: false, markersWontHide: true,keepSpiderfied:true});
    map.setOptions({styles: styles});
    iw = new gm.InfoWindow({
        maxWidth : 265
    });

    infoBubble2 = new InfoBubble({
        borderRadius: 0,
        disableAutoPan : true
    });

    // Listen for user click on map to close any open info bubbles
    google.maps.event.addListener(map, "click", function () {
        infoBubble2.close();
    });

    google.maps.event.addListener(map, 'zoom_changed', function() {
        if(inSearch == true){
            preAddMarkers(searchString,startDate,endDate,anyDate,twelvehour);
        }else{
            preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0,twelvehour);
        }
        updateLatLngCookie();
    });

    google.maps.event.addListener(map, 'dragend', function() {
        if(inSearch == true){
            preAddMarkers(searchString,startDate,endDate,anyDate,twelvehour);
        }else{
            preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0,twelvehour);
        }
        updateLatLngCookie();
    });

    function updateLatLngCookie(){

        bounds = map.getBounds();
        center = bounds.getCenter();
        var lat = center.lat();
        var lng = center.lng();
        var zoom = map.getZoom();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateLatLong/',
            type: "POST",
            data: "lat="+lat+"&lng="+lng+"&zoom="+zoom,
            success: function(data){

            }
        });
    }

    oms.addListener('click', function(marker) {
        //map.panTo(marker.getPosition());

        $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/events/checkEventAge/'+marker['id'],
            success: function(data){
                json_obj = jQuery.parseJSON(data);
                minAge = json_obj[0].event_min_age;
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/events/loadContent/'+marker['id']+'/mobile',
                    success: function(data){
                        infoBubble2.setContent(data);
                        infoBubble2.open(map, marker);
                        $('.loadingGif').remove();

                         var clickedLng = marker.getPosition().lng();
                         var clickedLat = Number(marker.getPosition().lat()) + Number(0);
                         var latLng = new google.maps.LatLng(clickedLat, clickedLng);
                         map.panTo(latLng);
                        map.panBy(0, -400 / 2);
                    }
                });
            }
        });
    });
    oms.addListener('spiderfy', function(markers) {
        for(var i = 0; i < markers.length; i ++) {
            markers[i].setIcon(iconWithColor(spiderfiedColor));
            markers[i].setShadow(null);
        }

    });
    oms.addListener('unspiderfy', function(markers) {
        for(var i = 0; i < markers.length; i ++) {
            markers[i].setIcon(iconWithColor(usualColor));
            markers[i].setShadow(shadow);
        }
    });

    addMarkers("35",<?php echo $lat; ?>,<?php echo $lng; ?>);

    if(showFor != '' || showFor != undefined){
        google.maps.event.addListenerOnce(map, 'idle', function(){
            $('#'+showFor).click();
        });

    }
}

function addMarkers(distance,lat,lng){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/events/getMarkers",
        dataType: "json",
        data: "distance="+distance+"&lat="+lat+"&lng="+lng,
        success: function(result){
            allMarkers = result;
            for (var i = 0;i < allMarkers.length; i += 1) {
                if( !$('#markerfilter_'+allMarkers[i].event_cat).hasClass('disabled') ){
                    if( $.inArray(allMarkers[i].event_id, markersArray) == -1 ){
                        var id = allMarkers[i].event_id;
                        var lat = allMarkers[i].event_lat;
                        var lon = allMarkers[i].event_lon;
                        var title = allMarkers[i].event_title;
                        if(allMarkers[i].event_type == 1){
                            var markerImage = 'featured-'+allMarkers[i].cat_icon;
                        }else{
                            var markerImage = allMarkers[i].cat_icon;
                        }


                        var cat = allMarkers[i].event_cat;
                        addMarker(id,lat,lon,title,markerImage,cat,i,true);
                        markersArray.push(allMarkers[i].event_id);

                        addToList(allMarkers[i],i);
                    }
                }

            };
            $('.loadingGif').remove();
        }
    });

}

function addMarker(id,lat,lng,title,markerImage,cat,no,visible){
    var latlng = new google.maps.LatLng(lat,lng);
    var marker = new google.maps.Marker({
        position: latlng,
        title: title,
        id: id,
        cat: cat,
        icon: '<?php echo base_url(); ?>/themes/showdom/images/markers/small/'+markerImage,
        backupIcon: '<?php echo base_url(); ?>/themes/showdom/images/markers/small/'+markerImage,
        lat: lat,
        lng: lng,
        map: map
    });
    marker.setVisible(visible);
    marker.metadata = { cat: cat };
    oms.addMarker(marker);
    markersArray2.push(marker);
};

function preAddMarkers(searchString,startDate,endDate,anyDate,twelvehourvalue,lat,lng,cats,featured,subCats){

    bounds = map.getBounds();
    center = bounds.getCenter();
    ne = bounds.getNorthEast();
    sw = bounds.getSouthWest();
    var r = 3963.0;
    var lat1 = center.lat() / 57.2958;
    var lon1 = center.lng() / 57.2958;
    var lat2 = ne.lat() / 57.2958;
    var lon2 = ne.lng() / 57.2958;
    var dis = r * Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));
    if(inAdvancedSearch == true){
        console.log(subCats);
        if(twelvehourvalue==1){
            twelvehour = 1;
        }else{
            twelvehour = 0;
        }
        searchMarkers(dis,lat,lng,searchString,startDate,endDate,anyDate,cats,twelvehour,featured,subCats);
        inAdvancedSearch = false;
        inSearch = true;
    }else if(inSearch == true){
        if(twelvehourvalue==1){
            twelvehour = 1;
        }else{
            twelvehour = 0;
        }
        searchMarkers(dis,center.lat(),center.lng(),searchString,startDate,endDate,anyDate,"1,2,3,4,5,6",twelvehour,featured);
    }else{
        addMarkers(dis,center.lat(),center.lng());
    }
}

function searchMarkers(distance,lat,lng,searchString,startDate,endDate,anyDate,cats,twelvehour,featured,subCats){

    if(twelvehour == undefined){
        twelvehour = 0;
    }
    if(featured == undefined){
        featured = 0;
    }

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/events/searchMarkers",
        dataType: "json",
        data: "distance="+distance+"&lat="+lat+"&lng="+lng+"&searchString="+searchString+"&startDate="+startDate+"&endDate="+endDate+"&anyDate="+anyDate+"&cats="+cats+"&twelvehour="+twelvehour+"&featured="+featured+"&subCats="+subCats,
        success: function(result){
            console.log('test');
            $('#map_event_list > div#eventsList').html(' ');
            inSearch = true;
            allMarkers = result;
            for (var i = 0;i < allMarkers.length; i += 1) {
                if( $.inArray(allMarkers[i].event_id, markersArray) == -1 ){
                    var id = allMarkers[i].event_id;
                    var lat = allMarkers[i].event_lat;
                    var lon = allMarkers[i].event_lon;
                    var title = allMarkers[i].event_title;
                    //var markerImage = allMarkers[i].cat_icon;

                    if(allMarkers[i].event_type == 1){
                        var markerImage = 'featured-'+allMarkers[i].cat_icon;
                    }else{
                        var markerImage = allMarkers[i].cat_icon;
                    }

                    var cat = allMarkers[i].event_cat;
                    if( !$('#markerfilter_'+allMarkers[i].event_cat).hasClass('disabled') ){
                        addMarker(id,lat,lon,title,markerImage,cat,i,true);

                    }else{
                        addMarker(id,lat,lon,title,markerImage,cat,i,false);

                    }
                    markersArray.push(allMarkers[i].event_id);
                }
                //}
                addToList(allMarkers[i],i);


            };
            $('.loadingGif').remove();
        }
    });
}

function checkNumber(theNumber){
    if(theNumber < 10){
        theNumber = '0'+theNumber;
    }
    return theNumber;
}

function addToList(allMarkers,i){
    /*--- ADD TO EVENT LIST----*/
    var eventContent = '';

    eventContent += '<div>';
    eventContent += '<h2 class="eventTitle eventTitleCat'+allMarkers.event_cat+'">'+allMarkers.event_title+'</h2>';

    var m_names = new Array("Jan", "Feb", "Mar",
        "Apr", "May", "Jun", "Jul", "Aug", "Sep",
        "Oct", "Nov", "Dec");

    today = new Date();
    var todayyyyy = today.getFullYear().toString();
    var todaymm = (today.getMonth()+1).toString();
    var todaydd  = today.getDate().toString();

    todaymm = checkNumber(todaymm);
    todaydd = checkNumber(todaydd);

    if(allMarkers.start_date_time_start_date < todayyyyy+'-'+todaymm+'-'+todaydd){
        var eventDate = new Date(todayyyyy+'-'+todaymm+'-'+todaydd);
        //var eventDate = new Date(allMarkers.start_date_time_start_date.replace(/-/g, "/"));
    }else{
        var eventDate = new Date(allMarkers.start_date_time_start_date.replace(/-/g, "/"));
    }

    var d = new Date(eventDate);

    var myMonth = d.getMonth();
    myMonth = m_names[myMonth];
    var myDay = d.getDate()+1;

    var myYear = d.getFullYear();

    eventContent += '<div class="googleMapsInfoWindowInner clearfix nomargin">';
    eventContent += '<div class="eventDate">';
    eventContent += '<span class="day">'+myDay+'</span>';
    eventContent += '<span class="month">'+myMonth+'</span>';
    eventContent += '<span class="year">'+myYear+'</span>';
    eventContent += '</div>';
    if(allMarkers.event_image == ''){
        eventImage = 'http://showdom.com/themes/showdom/images/file_not_found_200x200.jpg';
    }else{
        eventImage = 'http://showdom.com/themes/showdom/images/events/'+allMarkers.event_id+'/'+allMarkers.event_image+'';
    }
    eventContent += '<img class="eventImage" src="'+eventImage+'">';
    eventContent += '</div>';

    eventContent += '<div class="eventContent listViewContent">';
    eventContent += '<p>';
    eventContent += '<span class="catColor1">';
    eventContent += '<strong>'+allMarkers.cat_name+'</strong>';
    eventContent += '</span>';
    if(allMarkers.sub_cat_name != 'null' && allMarkers.sub_cat_name != null){
        eventContent += '- '+allMarkers.sub_cat_name+'';
    }
    eventContent += '</p>';
    eventContent += '<p>';
    eventContent += '<span>'+allMarkers.venue_name+'</span>';
    eventContent += '</p>';
    eventContent += '<p>';
    eventContent += '<span>'+formatDate("February 04, 2011 "+allMarkers.start_date_time_start_time+"")+' - '+formatDate("February 04, 2011 "+allMarkers.start_date_time_end_time+"")+'</span>';
    eventContent += '</p>';
    eventContent += '<a onclick="eventListClick('+allMarkers.event_id+')" class="yellowButton viewOnMap" href="#">VIEW ON MAP</a>';
    eventContent += '<a  class="yellowButton viewEventListView" href="http://showdom.com/index.php/mobile/viewEvent/'+allMarkers.event_id+'" onclick="return ajaxLoadEvent('+allMarkers.event_id+')">VIEW EVENT</a>';
    eventContent += '</div>';
//start_date_time_start_date
//start_date_time_start_time
    eventContent += '</div>';

    $('#map_event_list > div#eventsList').append(eventContent);
}

function eventListClick(id){

    $('#popupMobile').fadeOut();

    for (var i=0; i<markersArray2.length; i++) {
        markersArray2[i].setIcon(markersArray2[i].backupIcon);
    }


    $('#eventListOpenClose').click();
    for (var i=0; i<markersArray2.length; i++) {
        if (markersArray2[i].id==id){
            arrayPosition = i;
        }
    }
    markersArray2[arrayPosition].setIcon("http://showdom.com/themes/showdom/images/markers/medium/hover.png");
    map.setCenter(markersArray2[arrayPosition].getPosition());
    map.setZoom(20);
    return false;
    /*
     $('#eventListOpenClose').click();
     for (var i=0; i<markersArray2.length; i++) {
     if (markersArray2[i].id==id){
     arrayPosition = i;
     }
     }
     google.maps.event.trigger(markersArray2[arrayPosition], 'click');
     return false;
     */
}

$('.viewEventListView').click(function(){
    $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
});


function formatDate(date) {
    var d = new Date(date);
    var hh = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var dd = "AM";
    var h = hh;
    if (h >= 12) {
        h = hh-12;
        dd = "PM";
    }
    if (h == 0) {
        h = 12;
    }
    m = m<10?"0"+m:m;

    s = s<10?"0"+s:s;

    /* if you want 2 digit hours:
     h = h<10?"0"+h:h; */

    var pattern = new RegExp("0?"+hh+":"+m+":"+s);

    var repalcement = h+":"+m;
    /* if you want to add seconds
     repalcement += ":"+s;  */
    repalcement += " "+dd;

    return repalcement;
}

function clearMarkers(){
    for (var i = 0; i < markersArray2.length; i++) {
        markersArray2[i].setMap(null);
    }
    markersArray2.length = 0;
    markersArray.length = 0;
}

function hideMarkers(category) {
    $('#eventsList .eventTitleCat'+category).parent('div').css('display','none');
    for (var i = 0; i < markersArray2.length; i++) {
        if(markersArray2[i].cat == category){
            markersArray2[i].setVisible(false);
        }
    }
}

function showMarkers(category) {
    $('#eventsList .eventTitleCat'+category).parent('div').css('display','block');
    for (var i = 0; i < markersArray2.length; i++) {
        if(markersArray2[i].cat == category){
            markersArray2[i].setVisible(true);
        }
    }
    preAddMarkers("",currentStartSearch,currentEndSearch,0,0);
}


function fancybox(elm){
    var eventId = elm.id;
    eventId = eventId.split('_');
    eventId = eventId[1];
    console.log(eventId);

    $.ajax({
        url: '<?php echo base_url(); ?>index.php/mobile/quickPreview/'+eventId+'',
        success: function(data){
            $('body').append(data);
        }
    });

    $(document.body).on('click', '#closeQuickPreview', function() {
        $('#quickPreivew').remove();
    });

}


$(document).ready(function() {
    $("#ageRestrictedTrigger").fancybox({
        'titlePosition'		: 'inside',
        'transitionIn'		: 'none',
        'transitionOut'		: 'none'
    });
    $("#ageRestrictedFailTrigger").fancybox({
        'titlePosition'		: 'inside',
        'transitionIn'		: 'none',
        'transitionOut'		: 'none'
    });

    $('#eventFilter').click(function(){
        if($("#eventFilterPlatform").css('top') != '60px'){
            $('#eventFilterPlatform').animate({
                top: '60px'
            })
            $(this).addClass('active');
        }else{
            $('#eventFilterPlatform').animate({
                top: '-25px'
            })
            $(this).removeClass('active');
        }
    });

    $('#eventFilterPlatform > ul > li').click(function(){
        var cat = $(this).attr('id');
        cat = cat.split('_');
        cat = cat[1]
        if($(this).hasClass('disabled')){
            showMarkers(cat);
            $(this).removeClass('disabled');
        }else{
            if($('#eventFilterPlatform > ul > li.disabled').length != 5){
                hideMarkers(cat);
                $(this).addClass('disabled');
            }
        }
    });


    $('#basicSearchForm').submit(function(){
        $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');

        var form = $(this);
        searchString = $('input[name="generalSearch"]', form).val();
        startDate = $('input[name="startDate"]', form).val();
        endDate = $('input[name="endDate"]', form).val();
        twlelveHour = $('input[name="twelvehour"]', form).val();

        if($('input[name="anyDate"]', form).is(':checked')) {
            anyDate = 1;
        }else{
            anyDate = 0;
        }

        inSearch = true;
        inAdvancedSearch = false;
        clearMarkers();
        preAddMarkers(searchString,startDate,endDate,anyDate,twlelveHour);
        $('#clearSearchResults').fadeIn();
        $('#eventSearch').click();
        return false;
    });


    $('#eventSearch').click(function(){
        if($(this).hasClass('active')){
            $('#basicSearchContainer').fadeOut();
            $('#advancedSearchContainer').fadeOut();
        }else{
            $('#basicSearchContainer').fadeToggle();
        }
        $(this).toggleClass('active');
    });

    $('#eventNew').click(function(){
        window.location = "<?php echo base_url(); ?>index.php/mobile/eventUpdates";
    });

    $('.searchContainerClose').click(function(){
        $('#eventSearch').click();
    });


    $('input[name="startDate"]').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText) {
            $('input[name="anyDate"]').attr('checked', false);
        }
    });
    $('input[name="endDate"]').datepicker({
        dateFormat: 'yy-mm-dd'
    });


    $('#basicSearch').click(function(){
        $('#basicSearchContainer').fadeToggle();
        $('#advancedSearchContainer').fadeToggle();
    });

    $('#advancedSearch').click(function(){
        $('#basicSearchContainer').fadeToggle();
        $('#advancedSearchContainer').fadeToggle();
    });


    $('#clearSearchResults').click(function(){
        $('#showToday').click();
        return false;
    });

    <?php
        $startDate = strtotime("+0 day");
        $startDate = date('Y-m-d', $startDate);
        $endDate = strtotime("+0 day");
        $endDate = date('Y-m-d', $endDate);
    ?>
    var showTodayStart = "<?php echo $startDate; ?>";
    var showTodayEnd = "<?php echo $endDate; ?>";

    <?php
        $startDate = strtotime("+1 day");
        $startDate = date('Y-m-d', $startDate);
        $endDate = strtotime("+1 day");
        $endDate = date('Y-m-d', $endDate);
    ?>
    var showTomorrowStart = "<?php echo $startDate; ?>";
    var showTomorrowEnd = "<?php echo $endDate; ?>";

    <?php
        $startDate = strtotime("+0 day");
        $startDate = date('Y-m-d', $startDate);
        $endDate = strtotime("+7 day");
        $endDate = date('Y-m-d', $endDate);
    ?>
    var showThisWeekStart = "<?php echo $startDate; ?>";
    var showThisWeekEnd = "<?php echo $endDate; ?>";

    <?php
        $startDate = strtotime("+0 day");
        $startDate = date('Y-m-d', $startDate);
        $endDate = strtotime("+30 day");
        $endDate = date('Y-m-d', $endDate);
    ?>
    var showThisMonthStart = "<?php echo $startDate; ?>";
    var showThisMonthEnd = "<?php echo $endDate; ?>";

    <?php
        $startDate = strtotime("+0 day");
        $startDate = date('Y-m-d', $startDate);
    ?>
    var showAllStart = "<?php echo $startDate; ?>";

    $('#showToday').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showTodayStart;
        endDate = showTodayEnd;
        anyDate = 0;

        currentStartSearch = showTodayStart;
        currentEndSearch = showTodayEnd;

        clearMarkers();
        preAddMarkers("",showTodayStart,showTodayEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showToday",
            success: function(data){

            }
        });

        return false;
    });
    $('#showTomorrow').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showTomorrowStart;
        endDate = showTomorrowEnd;
        anyDate = 0;
        currentStartSearch = startDate;
        currentEndSearch = endDate;
        clearMarkers();
        preAddMarkers("",showTomorrowStart,showTomorrowEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showTomorrow",
            success: function(data){

            }
        });

        return false;
    });
    $('#showThisWeek').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showThisWeekStart;
        endDate = showThisWeekEnd;
        anyDate = 0;
        currentStartSearch = startDate;
        currentEndSearch = endDate;
        clearMarkers();
        preAddMarkers("",showThisWeekStart,showThisWeekEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();


        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showThisWeek",
            success: function(data){

            }
        });

        return false;
    });
    $('#showThisMonth').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showThisMonthStart;
        endDate = showThisMonthEnd;
        anyDate = 0;
        currentStartSearch = startDate;
        currentEndSearch = endDate;
        clearMarkers();
        preAddMarkers("",showThisMonthStart,showThisMonthEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showThisMonth",
            success: function(data){

            }
        });

        return false;
    });
    $('#showAll').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showAllStart;
        endDate = showAllStart;
        anyDate = 0;
        currentStartSearch = startDate;
        currentEndSearch = endDate;
        clearMarkers();
        preAddMarkers("",showAllStart,showAllStart,1,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showAll",
            success: function(data){

            }
        });

        return false;
    });
    getSubCats();

    $('.catCheckbox').change(function(){
        getSubCats();
    });




    $('#advancedSearchForm').submit(function(){
        var form = $(this);
        searchString = $('input[name="generalSearch"]', form).val();
        startDate = $('input[name="startDate"]', form).val();
        endDate = $('input[name="endDate"]', form).val();
        place = $('input[name="location"]', form).val();
        twlelveHour = $('input[name="twelvehour"]', form).val();
        genre = $('select[name="subCat"]', form).val();

        if($('input[name="anyDate"]', form).is(':checked')) {
            anyDate = 1;
        }else{
            anyDate = 0;
        }

        catString = '';

        $('.catCheckbox').each(function () {
            if( $(this).is(':checked') ) {
                catString += $(this).val()+',';
                $('#markerfilter_'+$(this).val()).removeClass('disabled');
            }else{
                $('#markerfilter_'+$(this).val()).addClass('disabled');
            }
        });

        if( $('input[name="featured"]').is(':checked') ) {
            featured = 1;
        }else{
            featured = 0;
        }

        catString = catString.substring(0, catString.length - 1);

        var geocoder = new google.maps.Geocoder();
        var address = place;

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status != google.maps.GeocoderStatus.OK) {
                alert('We are having issues geocoding this address. Please be as specific as posible.');
            }else{
                inAdvancedSearch = true;
                clearMarkers();
                var b = new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
                map.setCenter(b);
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/home/updateLatLong/',
                    type: "POST",
                    data: "lat="+results[0].geometry.location.lat()+"&lng="+results[0].geometry.location.lng(),
                    success: function(data){

                    }
                });
                preAddMarkers( searchString,startDate,endDate,anyDate,twlelveHour,results[0].geometry.location.lat(),results[0].geometry.location.lng(),catString,featured,genre);
            }
        });
        $('#eventSearch').click();
        $( "#clearSearchResults" ).fadeIn();
        $('#showingEventsFor > a').removeClass('active');
        return false;
    });

});





function getSubCats(){
    var mainCategories = new Array();
    $('.catCheckbox:checked').each(function() {
        mainCategories.push($(this).val());
    });

    $('select[name="subCat"]').find('option').remove().end();
    $('select[name="subCat"]').append('<option value="All">All</option>');

    $.ajax({
        url: '<?php echo base_url(); ?>index.php/events/reloadSubCats/',
        type: "POST",
        data: "cats="+mainCategories,
        dataType: 'json',
        success: function(data){
            $.each(data, function(index) {
                $('select[name="subCat"]').append('<option value="'+data[index].sub_cat_id+'">'+data[index].sub_cat_name+'</option>');
            });
        }
    });
}



function ajaxLoadEvent(id){
    console.log(id);
    $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
    $('#popupMobile').remove();

    if($('#eventListOpenClose').hasClass('close')){
        $('#eventListOpenClose').click();
    }

    $.ajax({
        url: '<?php echo base_url(); ?>index.php/mobile/viewAjax/'+id,
        type: "POST",
        data: "id="+id,
        success: function(data){
            window.location.hash = id;
            $('.loadingGif').remove();
            $('body').append(data);
            $('#popupMobile').fadeIn();
        }
    });
    return false;
}

$('#closeQuickPreview').live("click",function(){
    $('#popupMobile').fadeToggle();
    return false;
});


</script>
<a href="#ageRestrictedEvent" id="ageRestrictedTrigger"></a>
<a href="#ageRestrictedFail" id="ageRestrictedFailTrigger"></a>
<div style="display: none;">
    <div id="ageRestrictedEvent" style="width:340px;height:auto;overflow:auto;">
        <div class="quickEventContainerBorderTop">
            <span>AGE RESTRICTED EVENT</span>
            <span>This is an <span class="red ageRestrictionValue">18+</span> Event</span>
            <span>Please confirm your age to continue.</span>

            <form class="standardForm clearfix" id="confirmAge">
                <div class="formWrap clearfix">
                    <select name="birthMonth" class="addEventMonth">
                        <option value="00">MM</option>
                        <?php
                        for($i=1;$i<=12;$i++){
                            $num_padded = sprintf("%02s", $i);
                            echo '<option  value="'.$num_padded.'" '.(($birthMonth == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                        }
                        ?>
                    </select>
                    <select name="birthDay" class="addEventDay">
                        <option value="00">DD</option>
                        <?php
                        for($i=1;$i<=31;$i++){
                            $num_padded = sprintf("%02s", $i);
                            echo '<option value="'.$num_padded.'" '.(($birthDay == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                        }
                        ?>
                    </select>
                    <select name="birthYear" class="addEventyear">
                        <option value="0000">YYYY</option>
                        <?php
                        for($i=1900;$i<=date('Y');$i++){
                            echo '<option value="'.$i.'" '.(($birthYear == $i) ? "SELECTED " : "").'>'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <div class="clear-10"></div>
                    <hr />
                    <input style="position:relative;top:0px;right:0px;display:block;width:100% !important;" type="submit" value="CONFIRM AGE" class="yellowButton bold" />
                    <hr />
                </div>
            </form>

        </div>
    </div>

    <div id="ageRestrictedFail" style="width:340px;height:auto;overflow:auto;">
        <div class="quickEventContainerBorderTop">
            <span>AGE RESTRICTED EVENT</span>
            <span>This is an <span class="red ageRestrictionValue">18+</span> Event</span>
            <span>You don't meet the age requirements for this event.</span>
        </div>
    </div>

</div>


<div class="searchContainer" id="basicSearchContainer">
    <div>
        <h3>SEARCH EVENTS</h3>
        <a class="searchContainerClose" href="#"></a>
        <form id="basicSearchForm">
            <input type="text" name="generalSearch" value="" placeholder="Search String" />

            <img class="nifty" src="<?php echo base_url(); ?>themes/showdom/images/nifty.png" />
            <hr />
            <div>
                <label>Start Date</label>
                <input type="text" name="startDate" readonly="true" />
            </div>
            <div>
                <label>End Date</label>
                <input type="text" name="endDate" readonly="true" />
            </div>
            <div>
                <input type="checkbox" name="anyDate" value="0" checked="checked" />
                <label>Any Time</label>
            </div>
            <input type="submit" value="search" class="yellowButton" id="basicFormSubmitTrigger" />
            <input name="twelvehour" value="0" type="hidden" id="basicTwelveHourFormField" />

            <hr/>

            <a id="basicSearch" class="searchToggle" href="#">Advanced Search</a>

        </form>


    </div>
</div>

<div class="searchContainer" id="advancedSearchContainer">
    <div>
        <h3>SEARCH EVENTS</h3>
        <a class="searchContainerClose" href="#"></a>
        <form id="advancedSearchForm">
            <h3>SEARCH EVENTS - ADVANCED</h3>
            <input type="text" name="generalSearch" value="" placeholder="Search String" />

            <img class="nifty" src="<?php echo base_url(); ?>themes/showdom/images/nifty.png" />
            <p>SELECT CATEGORIES, TIMEFRAME, & LOCATION</p>
            <hr />

            <input type="checkbox" name="categories[]" class="catCheckbox" value="1" checked="checked" />
            <label>Music</label>

            <input type="checkbox" name="categories[]" class="catCheckbox" value="2" checked="checked" />
            <label>Theatre & Film</label>

            <input type="checkbox" name="categories[]" class="catCheckbox" value="3" checked="checked" />
            <label>Art & Writing</label>

            <input type="checkbox" name="categories[]" class="catCheckbox" value="4" checked="checked" />
            <label>Comedy</label>

            <input type="checkbox" name="categories[]" class="catCheckbox" value="5" checked="checked" />
            <label>Fashion</label>

            <input type="checkbox" name="categories[]" class="catCheckbox" value="6" checked="checked" />
            <label>Other</label>

            <br/><br/>
            <input type="checkbox" name="featured" value="1" />
            <label class="yellow">Featured</label>

            <hr />
            <label>Select Genre: </label>

            <select style="width: 100%" name="subCat">
                <option value="all">All</option>

            </select>

            <hr/>
            <div>
                <label>Start Date</label>
                <input type="text" name="startDate" />
            </div>

            <div>
                <label>End Date</label>
                <input type="text" name="endDate" />
            </div>
            <div>
                <input type="checkbox" name="anyDate" checked="checked" />
                <label>Any Time</label>
            </div>

            <hr />

            <p>Location</p>
            <input type="text" name="location" value="" id="advancedSearchField" placeholder="Toronto, Ontario Canada" />
            <script>
                var input = document.getElementById('advancedSearchField');
                var autocomplete = new google.maps.places.Autocomplete(input);
            </script>
            <input name="twelvehour" value="0" type="hidden" id="advancedTwelveHourFormField" />
            <input type="submit" value="search" class="yellowButton" id="advancedFormSubmitTrigger" />
            <a class="twelveHoursMobile" href="#"></a>

            <a id="advancedSearch" class="searchToggle" href="#">Basic Search</a>
        </form>


    </div>
</div>



<div id="eventFilterPlatform">
    <ul>
        <li id="markerfilter_1">
        </li>
        <li id="markerfilter_2">
        </li>
        <li id="markerfilter_3">
        </li>
        <li id="markerfilter_4">
        </li>
        <li id="markerfilter_5">
        </li>
        <li id="markerfilter_6">
        </li>
    </ul>
</div>

<ul id="filterButtons">
    <li id="eventSearch">
        <span class="toolTip">SEARCH EVENTS</span>
    </li>
    <li id="eventFilter">
        <span class="toolTip">EVENT FILTER</span>
    </li>
    <li id="eventNew">
        <span class="toolTip">EVENT UPDATES</span>
    </li>
</ul>

<div id="showingEventsFor">
    <a id="showToday" href="" class="active">Today</a>
    <a id="showTomorrow" href="">Tomorrow</a>
    <a id="showThisWeek" href="">This Week</a>
    <a id="showThisMonth" href="">This Month</a>
    <a id="showAll" href="">All</a>
</div>

<a id="clearSearchResults" href="" style="display: none" class="active">Clear Search</a>


<div id="map_event_list">

    <div id="eventsList">

    </div>

</div>


<div id="map_canvas"></div>