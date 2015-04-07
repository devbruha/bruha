<div id="popup">
    <div id="popupInner" class="clearfix">
        <div id="popupInnerFull" class="cmsPage">
            <?php print_r($content); ?>
			
			<h2>Web Scraper Control</h2>
			
			<?php echo form_open('/scraper_controller/crawlBlogTO') ?>
				<input type="submit" name="submit" value="Crawl BlogTO" /> 
			</form>
			<?php echo form_open('/scraper_controller/crawlJustshows') ?>
				<input type="submit" name="submit" value="Crawl JustShows" /> 
			</form>
			<?php echo form_open('/scraper_controller/crawlColConcerts') ?>
                <input type="submit" name="submit" value="Crawl Collective Concerts" /> 
            </form>
            <?php echo form_open('/scraper_controller/crawlNowTorontoArt') ?>
				<input type="submit" name="submit" value="Crawl Now Toronto Art" /> 
			</form>
            <?php echo form_open('/scraper_controller/crawlNowTorontoComedy') ?>
                <input type="submit" name="submit" value="Crawl Now Toronto Comedy" /> 
            </form>
            
			<?php echo form_open('/scraper_controller/testlogin') ?>
				<input type="submit" name="submit" value="Test" /> 
			</form>
            
			<h2> Add Events from CSV</h2>
			<?php echo form_open('/scraper_controller/addCSV') ?>
				<input type="submit" name="submit" value="Add CSVs" /> 
			</form>
        </div>
    </div>
</div>