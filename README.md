# blogool
Single-page blogging platform

# Deployment

1. Clone the project
	1. git clone https://github.com/siriusthinker/blogool.git

2. Run the new db script found in 'blogool/adminscripts/scripts'
	1.  ./new_db.sh

3. Run the following command to load test data
	1. ./database.sh blogool blogool TLPxtdZqboRh && ./import _test _data.sh blogool blogool TLPxtdZqboRh

4. Include the httpd config in php.ini
	1. Include /srv/www/blogool/adminscripts/etc/httpd/conf.d/blogool_vhost.conf

5. Add the hostname in your /etc/hosts file (change the HOST_IP to the IP address of the host machine)
	1. HOST_IP blogool.siriusthinker.com

6. Restart the apache
	1. service httpd restart
