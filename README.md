# MS-trusted-CAs
MS-trusted-CAs is a set of batch and PHP scripts to automatically download every trusted CA certificates from Microsoft according to [https://unmitigatedrisk.com/?p=259](https://unmitigatedrisk.com/?p=259), and bundles them in a single PEM-formated file.

## Requirements
The batch script assumes you have [wget](http://gnuwin32.sourceforge.net/packages/wget.htm), [openssl](http://developer.covenanteyes.com/building-openssl-for-visual-studio/) and php.exe in your path.

The PHP script needs "allow_url_fopen = On" in your php.ini configuration file.

## Usage
```
mscert.cmd
```
