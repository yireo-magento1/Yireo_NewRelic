Magento module for New Relic &copy;
================================
Homepage: http://www.yireo.com/software/magento-extensions/newrelic

Steps to get it working:
* Make sure to install New Relic on your server first
* Make sure to have New Relics PHP-module installed and active
* Upload the files in the source/ folder to your site
* Flush the Magento cache
* Configure settings under System > Configuration > Advanced > New Relic
* Done

## Instructions for using composer

Use composer to install this extension. First make sure to initialize composer with the right settings:

    composer -n init
    composer install --no-dev

Next, modify your local composer.json file:

    {
        "require": {
            "yireo/magento1-newrelic": "dev-master",
            "magento-hackathon/magento-composer-installer": "*"
        },    
        "repositories":[
            {
                "packagist": false
            },
            {
                "type":"composer",
                "url":"https://packages.firegento.com"
            },
            {
                "type":"composer",
                "url":"https://satis.yireo.com"
            }
        ],
        "extra":{
            "magento-root-dir":"/path/to/magento",
            "magento-deploystrategy":"copy"           
        }
    }

Make sure to set the `magento-root-dir` properly. Test this by running:

    composer update --no-dev

Done.

