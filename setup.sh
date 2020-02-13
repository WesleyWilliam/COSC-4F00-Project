mkdir lib ;
wget -O lib/rb.tgz "https://redbeanphp.com/downloadredbeanversion.php?f=postgres"
tar -C lib/ -xvf lib/rb.tgz
mkdir licenses
mv lib/licenses.txt licenses/
rm lib/rb.tgz

mv config.php config/

chmod -R 701 *
