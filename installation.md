#quick installation summary.

# Introduction #

so, you've downloaded it and now ?


# Details #
this aims to be a simple step by step install guide to installing pmd.
<br />
first of all, extract it to somewhere under you're apache htdocs. it should<br />
extract under something like 'pmd-1.0.1'.
locate somewhere there the file config.ini, it should be like : <br />
```
[database]
database = "movies"
hostname = "localhost"
password = "root"
username = "root"

[import_directives]
MCImagesDir = "directory_where_MC_stores_images"
MCThumbnailsDir = "directory_where_MC_stores_thumbnails"

[user_config]
app_name = "PHP Movie DB"
display_chunk = "100"
language = "en_US"
site = "http://localhost/pmd-1.0.1/"
version = "1.0.1"
your_full_name = "Sample User"
```
<br />
don't forget to fill in the correct details like db username and pass.<br />
the movie collectorz images directory should be something like :<br />
c:\Documents and Settings\Your Name\My Documents\Movie Collector\Images | Thumbnails<br />
<br />
this was the hard part, now create the db movies with phpmyadmin or some other tool
<br />
create the xml file with Movie Collectorz and store it in the same directory as pmd.
_hope to create some sort of automatic import sometime :)_ <br />
to import it go to http://localhost/pmd-1.0.1/import.php <br />
if everything was ok, now you could start playing with it on http://localhost/pmd-1.0.1/index.php <br />
to configure it : http://localhost/pmd-1.0.1/configuration.php <br />

have fun :)