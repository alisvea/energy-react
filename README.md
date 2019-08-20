Energy Calculator
=====================================

This is a React, Redux based web app for Svea Solar Energy Calculator. 


### Installations

#### React app
  * Clone the repository: `git clone https://github.com/alisvea/energy-react.git`.
  * CD to directory `cd react` and then run npm install `npm install` .
  * Run the build process `npm run build`.  
  * The above command will create a directory build containing all the needed files i.e js, css, html.  
  * Using ftp client (e.g FileZilla) to ftp.sveasolar.com and copy all the files in build directory to /v2/calculator.  
  
#### SASS app
  * CD to directory `cd sass` and then run npm install `npm install` .
  * Run the build process `npm start`. Then if you make any change to any scss file it will be automatically compiled and copied to css directory. 
  * After making any changes and compiling using the above command, copy the latest css/style.css to Read App by using:
    `npm run build`.
    
### Requirements

   * You many need to install the following.
     1. node >= 10.16.0
     2. npm >= 6.9.0
