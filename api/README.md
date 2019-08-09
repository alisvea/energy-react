API- Documentation
=====================================

This gives a brief description of the API.


### Description
This is a simple RESTFul API ( v1, v2 ) and supports basic authentication using username and password supplied by the support.


### API Endpoints

  * Get Collections: `GET https://gasell1.zavann.se/rest/v2/`. In Postman provide username and password.
  * Get Prices per zone `GET https://gasell1.zavann.se/rest/v2/hourlyspotprice?from_date=2019-07-01&to_date=2019-07-31` .
  
### Install
  
  * Copy the php file index.php to your webserver and make sure to have write permissions for the web user.
  
### Requirements

   * You many need to install the following.
     1. php >= 5.4.0
