
/*---- SITE JS----*/

function initialize() {

    var gm = google.maps;
    var mapOptions = {
        center: new gm.LatLng(lat, lng),
        zoom: Number(zoomLevel),
        minZoom : 5,
        mapTypeId: gm.MapTypeId.ROADMAP
    };
    map = new gm.Map(document.getElementById("map_canvas"),mapOptions);
    oms = new OverlappingMarkerSpiderfier(map,{markersWontMove: true, markersWontHide: true,keepSpiderfied:true});
    map.setOptions({styles: styles});
    iw = new gm.InfoWindow({
        maxWidth : 1200
    });

    infoBubble2 = new InfoBubble({
        borderRadius: 0
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
            url: baseUrl+'index.php/home/updateLatLong/',
            type: "POST",
            data: "lat="+lat+"&lng="+lng+"&zoom="+zoom,
            success: function(data){

            }
        });
    }

    oms.addListener('click', function(marker) {
        $.ajax({
            url: baseUrl+'index.php/events/checkEventAge/'+marker['id'],
            success: function(data){
                json_obj = jQuery.parseJSON(data);
                minAge = json_obj[0].event_min_age;
                if(minAge == 0){
                    $.ajax({
                        url: baseUrl+'index.php/events/loadContent/'+marker['id'],
                        success: function(data){
                            infoBubble2.setContent(data);
                            infoBubble2.open(map, marker);
                        }
                    });
                }else{

                    $('.ageRestrictionValue').html(minAge+"+");
                    $('#ageRestrictedTrigger').click();
                    $('#confirmAge').unbind('submit');
                    $('#confirmAge').submit(function(){
                        data = $(this).serializeArray();

                        month 	= data[0].value;
                        day 	= data[1].value;
                        year 	= data[2].value;

                        today 		= new Date();
                        dateString 	= year+'-'+month+'-'+day;
                        birthDate	= new Date(dateString);
                        //age 		= today.getFullYear() - birthDate.getFullYear();
                        age 		= today.getFullYear() - year;
                        if(age >= minAge && age != '2013'){
                            $.fancybox.close();
                            $.ajax({
                                url: baseUrl+'index.php/events/loadContent/'+marker['id'],
                                success: function(data){
                                    infoBubble2.setContent(data);
                                    infoBubble2.open(map, marker);
                                }
                            });
                        }else{
                            //	$.fancybox.close();
                            $('#ageRestrictedFailTrigger').click();
                        }

                        return false;
                    });

                }
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

    addMarkers("35",lat,lng);

    if(showFor != '' || showFor != undefined){
        google.maps.event.addListenerOnce(map, 'idle', function(){
            $('#'+showFor).click();
        });

    }

}

function addMarkers(distance,lat,lng){
    $.ajax({
        type: "POST",
        url: baseUrl+"index.php/events/getMarkers",
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
                    }
                }

            };

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
        icon: baseUrl+'/themes/showdom/images/markers/small/'+markerImage,
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
        url: baseUrl+"index.php/events/searchMarkers",
        dataType: "json",
        data: "distance="+distance+"&lat="+lat+"&lng="+lng+"&searchString="+searchString+"&startDate="+startDate+"&endDate="+endDate+"&anyDate="+anyDate+"&cats="+cats+"&twelvehour="+twelvehour+"&featured="+featured+"&subCats="+subCats,
        success: function(result){
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
            };
        }
    });

}

function clearMarkers(){
    for (var i = 0; i < markersArray2.length; i++) {
        markersArray2[i].setMap(null);
    }
    markersArray2.length = 0;
    markersArray.length = 0;
}

function hideMarkers(category) {
    for (var i = 0; i < markersArray2.length; i++) {
        if(markersArray2[i].cat == category){
            markersArray2[i].setVisible(false);
        }
    }
}

function showMarkers(category) {
    for (var i = 0; i < markersArray2.length; i++) {
        if(markersArray2[i].cat == category){
            markersArray2[i].setVisible(true);
        }
    }
    preAddMarkers();
}

function favouriteEvent(elm,id){
    $.ajax({
        type: "POST",
        url: baseUrl+"index.php/events/favourite/"+id,
        success: function(result){
            //$(elm).removeClass('redButton');
            //$(elm).addClass('greenButton');
            $('#unfavouriteEvent').css('display','block');
            $('#favouriteEvent').css('display','none');
        }
    });
    $(this).attr();
}

function unfavouriteEvent(elm,id){
    $.ajax({
        type: "POST",
        url: baseUrl+"index.php/events/unfavouriteAjax/"+id,
        success: function(result){
            //$(elm).removeClass('greenButton');
            //$(elm).addClass('redButton');
            $('#unfavouriteEvent').css('display','none');
            $('#favouriteEvent').css('display','block');
        }
    });
}

function fancybox(elm){
    $("a.quickpreview").fancybox({
        'titlePosition'		: 'inside',
        'transitionIn'		: 'none',
        'transitionOut'		: 'none'
    });
    $("a.quickpreview").click();
}

$(document).ready(function() {

    /*
    $("#headerAds").width($("#headerAds").width() + 800);
    $('#headerAds').css({"left": -400});

    doc_width = $(document).width();
    numAds = Math.ceil(doc_width/400);

    incVal = 0;
    for(var i=0;i<numAds;i++){
        loadNewRandomAd(1);
    }
    loadNewRandomAd(0);
*/


    //var int=self.setInterval(function(){animateAds()},7000);
    /*function animateAds(){
     loadNewRandomAd(0);
     $("#headerAdSliderOutter a").animate({
     left: "+=400px",
     }, "slow" );
     }*/

    function cleanUpAds(){
        $('#headerAdSliderOutter a').each(function(index) {
            left = $(this).css('left');
            left = left.substring(0, left.length - 2);
            if(left > Number(doc_width+800)){
                $(this).remove();
            }
        });
    }

    function loadNewRandomAd(init){
        $.ajax({
            type: "POST",
            url: baseUrl+"index.php/ads/getRandomSliderAd",
            async: false,
            success: function(result){
                $('#headerAdSliderOutter').prepend(result);
                if(init==1){
                    $('#headerAdSliderOutter a').each(function(index) {
                        left = parseInt($(this).css("left")) + 400;
                        $(this).css({"left": left});
                    });
                }else{
                    cleanUpAds();
                }
            }
        });
    }

    $('#headerAdSliderOutter').fadeIn(1000);

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

    $('#clearSearchResults').click(function(){
        $('#showToday').click();
        return false;
    });

    $('#showToday').click(function(){
        inSearch = true;
        searchString = "";
        startDate = showTodayStart;
        endDate = showTodayEnd;
        anyDate = 0;

        clearMarkers();
        preAddMarkers("",showTodayStart,showTodayEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: baseUrl+'index.php/home/updateShowFor/',
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
        clearMarkers();
        preAddMarkers("",showTomorrowStart,showTomorrowEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: baseUrl+'index.php/home/updateShowFor/',
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
        clearMarkers();
        preAddMarkers("",showThisWeekStart,showThisWeekEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: baseUrl+'index.php/home/updateShowFor/',
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
        clearMarkers();
        preAddMarkers("",showThisMonthStart,showThisMonthEnd,0,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: baseUrl+'index.php/home/updateShowFor/',
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
        clearMarkers();
        preAddMarkers("",showAllStart,showAllStart,1,0);
        $('#showingEventsFor > a').removeClass('active');
        $(this).addClass('active');
        $('#clearSearchResults').fadeOut();

        $.ajax({
            url: baseUrl+'index.php/home/updateShowFor/',
            type: "POST",
            data: "showFor=showAll",
            success: function(data){

            }
        });
        return false;
    });

    $('#createAnEvent').click(function(){
        $('#signUpTrigger').click();
        return false;
    });

    $('#signUpTrigger').click(function(){
        $('#signUp').css('display','block');
        $(this).css('display','none');
        $('#signUp').animate({
            top: '155px'
        });
    });

    $('#notRightNow a').click(function(){
        $('#signUp').css('display','none');
        $('#signUpTrigger').css('display','block');
        $('#signUp').animate({
            top: '-600px'
        });
    });

    var windowHeight = $(window).height();
    windowHeight = windowHeight-215;
    $('#popup').css('min-height',windowHeight);

    if($("#popup").length == 1) {
        //var animateTo = $(window).height() - 60;

        //var animateTo = $('#popup').height()+160;
        $("#footer").append('<a id="popUpDown" class=""></a>');
        /*
        $('#popUpDown').live("click",function(){
            $('#popup').animate({
                'margin-top':animateTo+'px'
            }, 500, function() {
                $("#footer").remove('#popUpDown');
                $("#footer").append('<a id="popUpUp" class=""></a>');
            });

        });
        $('#popUpUp').live("click",function(){
            $('#popup').animate({
                'margin-top':'160px'
            }, 500, function() {
                $("#footer").remove('#popUpUp');
                $("#footer").append('<a id="popUpDown" class=""></a>');
            });

        });
        */

        $('#popup').append('<img id="closePopUpX" style="position:absolute;right: -10px;top:-10px;cursor: pointer" src="http://showdom.com/themes/showdom/images/infoBubbleClose.png">');


        $('#popUpDown,#closePopUpX').live("click",function(){
           $('#popup').fadeToggle();
            $("#footer").remove('#popUpDown');
            $("#footer").append('<a id="popUpUp" class=""></a>');
        });

        $('#popUpUp').live("click",function(){
            $('#popup').fadeToggle();
            $("#footer").remove('#popUpUp');
            $("#footer").append('<a id="popUpDown" class=""></a>');
        });

    }


    $('#basicSearchForm .twelveHours').click(function(){
        $('#basicTwelveHourFormField').val('1');
        $('#basicSearchForm').submit();
    });

    $('#basicFormSubmitTrigger').click(function(){
        $('#basicTwelveHourFormField').val('0');
    });

    $('#advancedSearchForm .twelveHours').click(function(){
        $('#advancedTwelveHourFormField').val('1');
        $('#advancedSearchForm').submit();
    });

    $('#advancedFormSubmitTrigger').click(function(){
        $('#advancedTwelveHourFormField').val('0');
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
                    url: baseUrl+'index.php/home/updateLatLong/',
                    type: "POST",
                    data: "lat="+results[0].geometry.location.lat()+"&lng="+results[0].geometry.location.lng(),
                    success: function(data){

                    }
                });
                preAddMarkers( searchString,startDate,endDate,anyDate,twlelveHour,results[0].geometry.location.lat(),results[0].geometry.location.lng(),catString,featured,genre);
                if(!$('#eventFilter').hasClass('active')){
                    $('#eventFilter').click();
                }
            }
        });
        $('#eventSearch').click();
        $( "#clearSearchResults" ).fadeIn();
        $('#showingEventsFor > a').removeClass('active');
        return false;
    });

    $('#basicSearchForm').submit(function(){
        var form = $(this);
        searchString = $('input[name="generalSearch"]', form).val();
        startDate = $('input[name="startDate"]', form).val();
        endDate = $('input[name="endDate"]', form).val();
        place = $('input[name="location"]', form).val();
        twlelveHour = $('input[name="twelvehour"]', form).val();

        if($('input[name="anyDate"]', form).is(':checked')) {
            anyDate = 1;
        }else{
            anyDate = 0;
        }

        inSearch = true;
        inAdvancedSearch = false;

        var geocoder = new google.maps.Geocoder();
        var address = place;

        console.log(address);
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status != google.maps.GeocoderStatus.OK && address != '') {
                alert('We are having issues geocoding this address. Please be as specific as posible.');
            }else{
                if(address != ''){
                    inAdvancedSearch = true;
                    clearMarkers();
                    var b = new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
                    map.setCenter(b);
                    $.ajax({
                        url: baseUrl+'index.php/home/updateLatLong/',
                        type: "POST",
                        data: "lat="+results[0].geometry.location.lat()+"&lng="+results[0].geometry.location.lng(),
                        success: function(data){

                        }
                    });
                    preAddMarkers( searchString,startDate,endDate,anyDate,twlelveHour,results[0].geometry.location.lat(),results[0].geometry.location.lng());
                    if(!$('#eventFilter').hasClass('active')){
                        $('#eventFilter').click();
                    }
                }else{
                    clearMarkers();
                    preAddMarkers(searchString,startDate,endDate,anyDate,twlelveHour);
                }
            }
        });

        //clearMarkers();
        //preAddMarkers(searchString,startDate,endDate,anyDate,twlelveHour);
        $('#eventSearch').click();

        $( "#clearSearchResults" ).fadeIn();
        $('#showingEventsFor > a').removeClass('active');
        return false;
    });

    $('.popUpClose').click(function(){
        $(this).parent('div').fadeToggle();
        $('#eventSearch').removeClass('active');
    });

    $('#basicSearch').click(function(){
        $('#basicSearchContainer').fadeToggle();
        $('#advancedSearchContainer').fadeToggle();
    });

    $('#advancedSearch').click(function(){
        $('#basicSearchContainer').fadeToggle();
        $('#advancedSearchContainer').fadeToggle();
    });

    $('#eventFilter,#eventNew').click(function(){
        $(this).toggleClass('active');
    });

    $('#eventNew').click(function(){
        window.location.href =baseUrl+"index.php/updates";
        return false;
    });


    $('input[name="startDate"]').datepicker({
        showOn: 'button',
        buttonImageOnly: true,
        buttonImage: baseUrl+'themes/showdom/images/calIcon.png',
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText) {
            $('input[name="anyDate"]').attr('checked', false);
        }
    });
    $('input[name="endDate"]').datepicker({
        showOn: 'button',
        buttonImageOnly: true,
        buttonImage: baseUrl+'themes/showdom/images/calIcon.png',
        dateFormat: 'yy-mm-dd'
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


    $('#eventFilter').click(function(){
        if($("#eventFilterPlatform").css('bottom') != '60px'){
            $('#eventFilterPlatform').animate({
                bottom: '60px'
            })
        }else{
            $('#eventFilterPlatform').animate({
                bottom: '-260px'
            })
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

    getSubCats();

    $('.catCheckbox').change(function(){
        getSubCats();
    });

    function getSubCats(){
        var mainCategories = new Array();
        $('.catCheckbox:checked').each(function() {
            mainCategories.push($(this).val());
        });

        $('select[name="subCat"]').find('option').remove().end();
        $('select[name="subCat"]').append('<option value="All">All</option>');

        $.ajax({
            url: baseUrl+'index.php/events/reloadSubCats/',
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

    $("#signUpForm").validate({
        validClass: "success"
    });

});