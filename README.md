# Appzio PHPLibrary2
This is a bootstrap library for developing actions for Appzio using PHP. It includes the needed shared libraries for different components. If you are developing for Appzio, contact devsupport@appzio.com to get your own server instance, sftp access and all the other related goodies. Please refer to https://docs.appzio.com/getting-started/ for setting up your development environment.

### Installing Yii
You don't need the Yii installed, but it will make your life little bit easier if you are using a proper IDE. If you have composer installed and working (sorry, need to use without https, if its not enabled do "php composer.phar config secure-http false" first.) Simply do "php composer.phar install". 

### Unit tests for your app 
Good partner for this toolkit is the rest bootstrap library (https://github.com/appzio/rest-bootstrap-php) and iOS / Android application which is connected to your dev instance. 

### Documentation
Documentation is inline and is also parsed to our documentation site where its searchable: https://docs.appzio.com/.

Included documentation.json is an output of https://github.com/appzio/doctim.

### Creating a new action
In order to create a new action inside Appzio, please login to your web dashboard and navigate to `https://{your_server}/en/aedev/extension/index` or choose the settings icon from the top right hand corner and navigate to "For Developers" section.

### Trouble shooting
Please refer to online documentation. Most common cause for non-working actions is incorrectly defined namespaces. 