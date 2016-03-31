@echo off
wget http://www.download.windowsupdate.com/msdownload/update/v3/static/trustedr/en/authrootstl.cab
expand authrootstl.cab .\authroot.stl
openssl asn1parse -oid authroot.oids -in authroot.stl -inform DER > authroot.dump
php ms-download.php authroot.dump
for /f %%i in ('dir /b *.crt') do openssl x509 -in %%i -inform DER -outform PEM -out %%~ni.cer
del *.crt
copy *.cer ms-cert.crt
