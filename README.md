# Bees4NUIG
This is to prototype the requirements of the NUIG researchers to capture data from Irish beekeepers. THe idea is to make registration and data entry much easier and thereby improve the number and quality of data points used in the research.

The intention is to also provide mechanisms for the researchers to extract the captured data in a simple way, avoiding duplicates.

## Timeline
The intention is to have a version providing a reasonable level of functionality by early May 2018.

## Volunteers
If anyone, particularly students in NUIG, is interested in helping, please let me know.

## Solution
The solution should be as simple as possible. The initial idea was to use NodeJS/Express with SQLite but since finding hosting that supports Node proved to be difficult, the project has continued with  the commonly-available PHP and MySQL RDBMS. The GUI is a set of web pages using Twitter Bootstrap and JQuery.

The user interface will be based on the [Excel](https://github.com/bpmurray/Bees4NUIG/blob/master/docs/Inspection-form-Excel-version.xls) and [PDF](https://github.com/bpmurray/Bees4NUIG/blob/master/docs/Inspection%20form%20Printable%20version.pdf) documents sent to beekeepers in 2016.

## Database
The data will be stored in a RDMBS rather than a NoSQL solution since it is structured and relational. Accessing the data will be done in a DB-agnostic way, to allow for drop-in replacements of the preferred DB. Initially we will use SQLite because it is lightweight and simple, and the potential data volume is rather small.

The database schema looks like this:
![Database Schema](https://github.com/bpmurray/Bees4NUIG/blob/master/doc/schema.jpg)

## REST Services
REST services essentially manage the database and certain other encapsulated functionality. All connections will use SSL for security reasons. As usual, the services will follow the mapping to CRUD functions:
- To create a new entity, use _POST_ to the relevant endpoint.
- To update an entity's data, use ~~_PUT_~~ ... because of URL data size limitations, we will use _POST_ here.
- To retrieve an entity's data, use _GET_.
- To delete an entity, use _DELETE_. Note that the API will delete associated relations and, in general, preserver referential integrity.

The available entities correspond to the tables:
- beekeeper
- apiary
- queen
- inspection

####REST URLs
All REST URLs will have the format:
```
GET|POST|DELETE _baseAddress/entity?data=name-value pairs_
```
For example, reading a beekeeper's apiaries would look like:
```
GET .../apiary?beekeeper=12345
```

## Installation
First download the code:
```
   git clone https://github.com/bpmurray/Bees4NUIG.git
```
Then run the DB creation script under the *setup* directory.

## Execution
Host the solution on an Apache server.

