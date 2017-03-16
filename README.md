# Bees4NUIG
This is to prototype the requirements of the NUIG researchers to capture data from Irish beekeepers. THe idea is to make registration and data entry much easier and thereby improve the number and quality of data points used in the research.

The intention is to also provide mechanisms for the researchers to extract the captured data in a simple way, avoiding duplicates.

## Solution
The solution should be as simple as possible. The prototype will use NodeJS as the server, with Express to manage the UI, with a TBD web-side framework to provide a good user experience. The data will bw stored in a RDMBS rather than a NoSQL solution since it is structured and relational. Accessin the data will be done in a DB-agnostic way, to allow for drop-in replacements of the preferred DB. For the prototype, we will use SQLite because it is lightweight and simple and the potential data volume is rather small.

One aspect of the solution is authentication and the associated registration. This will be managed by passport.js.

The user interface will be based on the [Excel](https://github.com/bpmurray/Bees4NUIG/blob/master/docs/Inspection-form-Excel-version.xls) and [PDF](https://github.com/bpmurray/Bees4NUIG/blob/master/docs/Inspection%20form%20Printable%20version.pdf) documents sent to beekeepers in 2016.

## Timeline
The intention is to have a version providing a reasonable level of functionality by mid-April 2017.

## Volunteers
If anyone, particularly students in NUIG, is interested in helping, please let me know.
