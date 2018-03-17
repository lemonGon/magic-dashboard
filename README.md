# Welcome to Boozt Dashboard

## Features
Boozt Magic Dashboard allows you to compute the following actions for a specifica date range (default 30 days).
* Customer count;
* Orders count;
* Revenue;
* A chart which shows sign-ups vs orders number.

## Improvements 
The mobile version is a bit buggy.

When changing the date, the current action needs to be refreshed by clicking again the link eg:
* I click on "Customer Count" using the default date.
* I change the date (either Date From or Date To).
    * I need to click again "Customer Count" in order to get the new results.
    * The "Customer Count" loses the highlight only when the just-changed date losses its focus.
    * A refresh icon beside the "Customer Count" might useful in this case.
      
MySql Date Formats could be replaced by more readable formats.
  
Although error messages are customised, they still appear as proper PHP error results eg:
* When I send Date From newer than Date To.
* When I send incorrect dates' formats.

## Setting up the application
1. Download the application.
2. Run composer update to install the project dependencies.
3. Configure your web server to have the public folder as the web root.
4. Open App/Config.php and enter your database configuration data.
5. Import the database dashboard.sql enclosed herewith.
 
## Technology
### Back-end
Boozt Magic Dashboard is based on native PHP language.
No framework was used for building its server side.

The dashboard is based on an MVC architecture.
 
### Front-end
Pure JavaScript, prototype oriented along with JQuery were used to develop the front-end side and the chart.

The front-end integrates with the back-end mostly through AJAX. 

Asynchronous calls retrieve data that show up to the user. Please check the network tab   

JSON format is used as a data vehicle 

### Database
The dashboard data re stored in a "classic" MySQL database.  

Indexes have been set up to speed up joins and searches.

Relationship are strengthened by constraints.


