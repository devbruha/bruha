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

<div id="eventFilterPlatform">
	<ul>
    	<li id="markerfilter_1">
            <span class="toolTip">Music</span>
        </li>
        <li id="markerfilter_2">
            <span class="toolTip">Theatre & Film</span>
        </li>
        <li id="markerfilter_3">
            <span class="toolTip">Art & Writing</span>
        </li>
        <li id="markerfilter_4">
        	<span class="toolTip">Comedy</span>
        </li>
        <li id="markerfilter_5">
        	<span class="toolTip">Fashion</span>
        </li>
        <li id="markerfilter_6">
            <span class="toolTip">Other</span>
        </li>
    </ul>
</div>

<div class="searchContainer" id="basicSearchContainer">
	<div>
    	<div>
            <form id="basicSearchForm">
                <h3>SEARCH EVENTS</h3>
                <input type="text" name="generalSearch" value="" placeholder="Search String" />
                <input type="submit" value="search" class="yellowButton" id="basicFormSubmitTrigger" />
                <a class="twelveHours" href="#"></a>
                <p>SELECT TIME FRAME</p>
                <hr />
                
                <div>
                    <p>Start Date</p>
                    <input type="text" name="startDate" />
                </div>
                
                <div>
                    <p>End Date</p>
                    <input type="text" name="endDate" />
                </div>
                <div>
                    <input type="checkbox" name="anyDate" value="0" checked="checked" />
                    <p>Any Time</p>
                </div>
                <p>Location</p>
                <input type="text" name="location" value="" id="basicSearchField" placeholder="Toronto, Ontario Canada" />
                <script>
                    var input = document.getElementById('basicSearchField');
                    var autocomplete = new google.maps.places.Autocomplete(input);
                </script>

                <input name="twelvehour" value="0" type="hidden" id="basicTwelveHourFormField" />
                <a id="basicSearch" class="searchToggle" href="#">Advanced Search</a>
            </form>
        </div>        
    </div>
    <a class="popUpClose" href="#"></a>
</div>

<div class="searchContainer" id="advancedSearchContainer">
	<div>
    	<div>
            <form id="advancedSearchForm">
                <h3>SEARCH EVENTS - ADVANCED</h3>
                <input type="text" name="generalSearch" value="" placeholder="Search String" />
                <input type="submit" value="search" class="yellowButton" id="advancedFormSubmitTrigger" />
                <a class="twelveHours" href="#"></a>
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

                <select style="width: 480px" name="subCat">
                    <option value="all">All</option>

                </select>

                <hr/>
                <div>
                    <p>Start Date</p>
                    <input type="text" name="startDate" />
                </div>
                
                <div>
                    <p>End Date</p>
                    <input type="text" name="endDate" />
                </div>
                <div>
                    <input type="checkbox" name="anyDate" checked="checked" />
                    <p>Any Time</p>
                </div>
                
                <hr />
                
                <p>Location</p>
                <input type="text" name="location" value="" id="advancedSearchField" placeholder="Toronto, Ontario Canada" />
                <script>
					var input = document.getElementById('advancedSearchField');
					var autocomplete = new google.maps.places.Autocomplete(input);
				</script>
                <input name="twelvehour" value="0" type="hidden" id="advancedTwelveHourFormField" />
                <a id="advancedSearch" class="searchToggle" href="#">Basic Search</a>
            </form>
        </div>        
    </div>
    <a class="popUpClose" href="#"></a>
</div>
