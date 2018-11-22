# Appzio PHPLibrary2
This is a bootstrap library for developing actions for Appzio using PHP. It includes the needed shared libraries for different components. Best place to get started is from the Udemy course: https://www.udemy.com/appzio-on-boarding/. 

### Installing the Appzio core
We distribute Appzio core to developer as a Docker container. Account creation, license management and installation instructions you can find from https://dashboard.appzio.com.

### Installing Yii
You don't need the Yii installed, but it will make your life little bit easier if you are using a proper IDE. If you have composer installed and working (sorry, need to use without https, if its not enabled do "php composer.phar config secure-http false" first.) Simply do "php composer.phar install". 

### Unit tests for your app 
Good partner for this toolkit is the rest bootstrap library (https://github.com/appzio/rest-bootstrap-php) and iOS / Android application which is connected to your dev instance. 

### Documentation
Documentation is inline and is also parsed to our documentation site where its searchable: https://docs.appzio.com/.

Included documentation.json is an output of https://github.com/appzio/doctim.

### Creating a new action module
Before creating a new action module, check whether there already exists an action module for this purpose. For example, its better to develop your registration using existing Mregister action module. Using existing modules are done with themes, so it allows you to create fully custom functionality and layout, but leverage the existing code base.

### Trouble shooting
Please refer to online documentation. Most common cause for non-working actions is incorrectly defined namespaces. 