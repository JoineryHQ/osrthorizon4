Directory: _unused/

On review of a full wget mirror of the J4 site, several template override files were
determined not to have been used (see "SCAN METHODOLOGY" below).

Those files have been moved into this directory, preserving any parent directory
structure (e.g. com_content/article/foo.php would be moved to _unused/com_content/article/foo.php).

=================
SCAN METHODOLOGY:

1. In this template (osrthorizon), every template override has something like this
   in it:

   ```php
   if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- START: osrthorizon/html/./com_content/article/default.php -->';}
   ```
   Worth noting: JFactory is deprecated. Skip that concern for now. At time of
   review, some files used Joomla\CMS\Factory instead. At time of writing, the
   plan is to edit all files to use Joomla\CMS\Factory; to reduce needless effort,
   this is planned _after_ we've moved unused files into this directory.

2. This will (as you might see) print an html comment on every website page where
   that template override is used, e.g.
   '<!-- START: osrthorizon/html/./com_content/article/default.php -->' apears
   (along with many similar comments for other template overrides) in the html
   source for http://osrt-j4.local/professionals/677-asrt

3. I've mirrored the entire http://osrt-j4.local site to a local directory at
   /tmp/osrtandromeda-htmlsnap_data/PRISTINE/bod , so that e.g.
   http://osrt-j4.local/professionals/677-asrt is mirrored at
   /tmp/osrtandromeda-htmlsnap_data/PRISTINE/bod/professionals/677-asrt.html

4. For every one of my template overrides, I've grepped the mirrored site files
   to determine actual usage of that template override, e.g.
   ack osrthorizon/html/./com_content/article/default.php -l.

5. For 13 of these template overrides, no usage is found in the mirrored site.

6. Therefore, I conclude: it should be "safe" (should have no visible impact at
   all) to remove these template overrides from the template, since they are not used.
