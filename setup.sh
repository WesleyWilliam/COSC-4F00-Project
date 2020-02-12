mkdir lib ;
wget -O lib/rb-postgres.php "https://redbeanphp.com/downloadredbeanversion.php?f=postgres"
mv config.php config/

chmod -R 701 view/
chmod -R 701 config/
chmod -R 701 model/
chmod -R 701 controller/
chmod -R 701 lib/
chmod -R 701 utilities/
