# phpwol
A simple PHP script to monitor local computers and send WOL packets.

# requirements
* Webserver with PHP and MySQL support
* Wakeonlan (To install wakeonlan, use *sudo apt install wakeonlan*)
* Preferrably a Linux server, or you will have to change the wakeonlan method

# installation
* Download the repo
* Put files on your webserver
* Import wol.sql into your database/MySQL server
* Edit sqlcon.php and set your SQL parameters
* Add computers you want to monitor or wake to the table
* Win

It is recommended that you password protect this folder, as it could potentially open up for unwanted security threats.
