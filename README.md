# PHP Autodiscover Autoconfig email Settings

This is a PHP script written in SLIM 4 framework which runs on a virtual server https://autodiscover.yourdomain.com,  it replies to autodiscover, autoconfig requests from email clients which call the autodiscover url. It provides autodiscover capabilities for Outlook, Thundebird but also Apple Mail. A page is shown when you request the root url which is customizable by editing the mainpage template. 

**Installing this script** 

`git clone https://github.com/HostingBE/php-autodiscover-autoconfig.git`

Open config/config.php and enter the configuration settings which apply to you. Their are two methods included to retrieve the email server settings. 

**Email Settings Retrieval**

included are:

* File based
* MySql Database

Via an interface it is simple to add your custom supplier for email server settings see for example the dbaseInterface.php or FileInterface.php.


**DNS settings**
For autodiscover and autoconfig to work, you need to add DNS records to the autodiscover domain you want to configure

```
autodiscover IN CNAME autodiscover.yourdomain.com
autoconfig IN CNAME autoconfig.yourdomain.com
_autodiscover._tcp IN SRV 10 10 443 autodiscover.yourdomain.com
```

**Credits**

I was looking for a modulair PHP version which was easy to customize and easy to extend. I got inspired by  [Monogramm](https://github.com/Monogramm/autodiscover-email-settings/) but that is a docker version. I just needed a PHP version which runs on virtual webhosting.

**License**

This project is distributed under the MIT License

